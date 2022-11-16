<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\JwtAuth;
use App\Comment;

class CommentController extends Controller
{
    public $params;
    public $params_array;

    public function __construct(Request $request)
    {
        $this->middleware('api.auth', ['except'=>['index', 'show']]);

        $json = $request->input('json', null);
        $this->params = json_decode($json);
        $this->params_array = json_decode($json, true);
    }

    private function getIdentity($request)
    {
        // Comprobar identidad del usuario
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);

        return $user;
    }

    public function index()
    {
        $comments = Comment::all()->load('user')->load('book');

        $data = [
            'status'    => 'success',
            'code'      => 200,
            'comments'=> $comments
        ];

        return response()-> json($data);
    }

    public function show($id)
    {
        $comment = Comment::find($id)->load('user')->load('book');

        if (is_object($comment)) {
            $data = [
                'status'    => 'success',
                'code'      => 200,
                'comment'  => $comment
            ];
        } else {
            $data = [
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'El comentario no existe.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request)
    {
        // Si valida datos
        if (!empty($this->params_array)) {
            // Conseguir el usuario autenticado
            $user = $this->getIdentity($request);

            // Validar los datos
            $validate = \Validator::make($this->params_array, [
                'comment' => 'required',
                'book_id' => 'required',
            ]);

            // Guardar categoría
            if ($validate->fails()) {
                $data = [
                    'status'    => 'error',
                    'code'      => 404,
                    'message'   => 'No se ha guardado el comentario, datos invalidos.'
                ];
            } else {
                $comment = new Comment();

                $comment->user_id = $user->sub;
                $comment->book_id = $this->params->book_id;
                $comment->comment = $this->params->comment;

                $comment->save();

                $data = [
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'Se ha guardado el comentario.',
                    'comment'   => $comment,
                ];
            }

        } else {
            $data = [
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'No se ha enviado el comentario, faltan datos.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request)
    {
        // Datos para devolver
        $data = [
            'code'      => 400,
            'status'    => 'error',
            'message'   => 'Datos enviados incorrectamente'
        ];

        // Verificar si los datos llegaron
        if (!empty($this->params_array)) {
            $validate = \Validator::make($this->params_array, [
                'comment'         => 'required',
            ]);

             // Verificar validez de los datos
             if ($validate ->fails()) {
                $data['errors'] = $validate ->errors();
                return response() ->json($data, $data['code']);
            }

            // Ocultar campos q no se cambiarán
            unset($this->params_array['id']);
            unset($this->params_array['user_id']);
            unset($this->params_array['book_id']);
            unset($this->params_array['created_at']);

            // Conseguir usuario identificado
            $user = $this->getIdentity($request);

            // Buscar el registro a actualizar
            $comment = Comment::where('id', $id)
                ->where('user_id', $user->sub)
                ->first();

            if (!empty($comment) && is_object($comment)) {
                // Actualizar el registro en concreto
                $comment->update($this->params_array);
                // Devolver algo
                $data = [
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'El comentario se ha actualizado correctamente.',
                    'comment'   => $comment
                ];
            } else {
                $data = [
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No tiene permiso para editar este comentario.'
                ];
            }
        } else {
            $data = [
                'status'    => 'error',
                'code'      => 400,
                'message'   => 'El comentario no se ha actualizado, faltan datos.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request)
    {
        // Recoger datos por post
        $user = $this->getIdentity($request);

        // Conseguir entrada
        $comment = Comment::where('id', $id)
                    ->where('user_id', $user->sub)
                    ->first();

        // Si la entrada tiene datos
        if (!empty($comment)) {
            // Eliminar entrada
            $comment->delete();

            // Devolver respuesta
            $data = [
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'El comentario se ha eliminado correctamente.',
                'comment'      => $comment
            ];
        } else {
            $data = [
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'El comentario no se puede eliminar.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function test(){
        return "Action Test on CommentController";
    }
}
