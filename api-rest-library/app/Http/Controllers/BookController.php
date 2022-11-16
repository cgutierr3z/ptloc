<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\JwtAuth;
use App\Book;

class BookController extends Controller
{
    public $params;
    public $params_array;

    public function __construct(Request $request)
    {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);

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
        $books = Book::all()->load('user');

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'books'     => $books,
        ]);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (is_object($book)) {
            $book->load('user');
            $data = [
                'status'    => 'success',
                'code'      => 200,
                'book'  => $book
            ];
        } else {
            $data = [
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'El libro no existe'
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
                'title'         => 'required|alpha_num',
                'author'        => 'required|alpha',
                'description'   => 'required|alpha_num',
                'image'         => 'required',
            ]);

            // Guardar libro
            if ($validate->fails()) {
                $data = [
                    'status'    => 'error',
                    'code'      => 404,
                    'message'   => 'No se ha guardado el libro, datos invalidos.'
                ];
            } else {
                $book = new Book();
                $book->user_id      = $user->sub;
                $book->title        = $this->params->title;
                $book->author       = $this->params->author;
                $book->description  = $this->params->description;
                $book->no_comments  = 0;
                $book->image        = $this->params->image;
                $book->status       = 'DISPONIBLE';
                $book->save();

                $data = [
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'Se ha guardado el libro.',
                    'book'      => $book
                ];
            }

        } else {
            $data = [
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'No se ha guardado el libro, faltan datos.'
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
                'title'         => 'required|alpha_num',
                'author'        => 'required|alpha',
                'description'   => 'required|alpha_num',
                'image'         => 'required',
            ]);

            // Verificar validez de los datos
            if ($validate ->fails()) {
                $data['errors'] = $validate ->errors();
                return response() ->json($data, $data['code']);
            }

            // Ocultar campos q no se cambiarán
            unset($this->params_array['id']);
            unset($this->params_array['user_id']);
            unset($this->params_array['created_at']);

            // Conseguir usuario identificado
            $user = $this->getIdentity($request);

            // Buscar el registro a actualizar
            $book = Book::where('id', $id)
                ->where('user_id', $user->sub)
                ->first();

            if (!empty($book) && is_object($book)) {
                // Actualizar el registro en concreto
                $book->update($this->params_array);
                // Devolver algo
                $data = [
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'El libro  se ha actualizado correctamente.',
                    'book'      => $book
                ];
            } else {
                $data = [
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No tiene permiso para editar este libro.'
                ];
            }
        } else {
            $data = [
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'El libro no se ha actualizado, faltan datos.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request)
    {
        // Recoger de usuario datos por post
        $user = $this->getIdentity($request);

        // Conseguir entrada
        $book = Book::where('id', $id)
                    ->where('user_id', $user->sub)
                    ->first();

        // Si la entrada tiene datos
        if (!empty($book)) {
            // Eliminar entrada
            $book->delete();

            // Devolver respuesta
            $data = [
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'El libro se ha eliminado correctamente.',
                'book'      => $book
            ];
        } else {
            $data = [
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'El libro no se puede eliminar.'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function upload(Request $request)
    {
        // Recoger la imagen de la petición
        $image = $request->file('file0');

        // Validar la imagen
        $validate = \Validator::make($request->all(), [
            'file0' => 'required|mimes:jpg,jpeg,png,gif'
        ]);

        // Guardar la imagen
        if (!$image || $validate->fails()) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error al subir la imagen del libro.'
            ];
        } else {
            $image_name = time() . $image->getClientOriginalName();

            \Storage::disk('images')->put($image_name, \File::get($image));

            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'La imagen se ha subido correctamente.',
                'image' => $image_name
            ];
        }

        // Devolver datos
        return response()->json($data, $data['code']);
    }


    public function test(){
        return "Action Test on BookController";
    }
}
