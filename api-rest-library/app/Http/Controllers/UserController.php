<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class UserController extends Controller
{
    public function signup(Request $request){
        //return "Action SingUp on UserController";

        // Recoger datos
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //var_dump($params_array);
        //die();

        // Bloque validacion de datos
        // Si el formato de los parametros es correcto los valida
        if (!empty($params) || !empty($params_array)) {
            //Limpiar datos
            $params_array = array_map('trim', $params_array);

            // Validar datos
            $validate = \Validator::make($params_array, [
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'email'     => 'required|email|unique:users',
                'password'  => 'required',
            ]);

            // Verificar si hay algun error de validacion
            if ($validate->fails()) {
                // Validacion fallida
                // Response hay error de validacion
                $data = array(
                    'status'    => 'error',
                    'code'      => 404,
                    'message'   => 'No se ha podio registrar el usuario.',
                    'errors'    => $validate->errors()
                );
            } else {
                // Validacion correcta

                // Cifrar password
                //$pass = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4]);
                $pass = hash('sha256', $params->password);

                // Crear objeto de usuario
                $user = new User();
                $user->name     = $params_array['name'];
                $user->surname  = $params_array['surname'];
                $user->email    = $params_array['email'];
                $user->role     = 'ROLE_USER';
                $user->password = $pass;

                // Guardar usuario
                $user->save(); 

                // Response datos correctos
                $data = array(
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'Se ha registrado el usuario correctamente.',
                    'user'      => $user
                );
            }
        } else {
            // Response parametros con formato incorrecto
            $data = array(
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'Los datos enviados y/o el formato no son correctos.'
            ); 
        }

        return response()->json($data, $data['code']);
    }

    public function login(Request $request){
        //return "Action Login on UserController";

        $jwtAuth = new \JwtAuth();

        // Recoger datos
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        // Validar datos
        $validate = \Validator::make($params_array, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        // Verificar si hay algun error de validacion
        if ($validate->fails()) {
            // Validacion fallida
            // Response hay error de validacion
            $data = array(
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'No se ha podido iniciar sesion.',
                'errors'    => $validate->errors()
            );
        } else {
            // Cifrar password
            $pwd = hash('sha256', $params->password);

            // Devolver token o datos
            $data = $jwtAuth->signin($params->email, $pwd);
            if(!empty($params->getToken)){
                $data = $jwtAuth->signin($params->email, $pwd, true);
            }
        }

        return response()->json($data, 200);
    }

    public function update(Request $request){
        

        // Recoger datos
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if($checkToken && !empty($params_array)){
            // Actualizar usuario

            // Obtener id de usuario
            $user = $jwtAuth->checkToken($token, true);

            // Validar datos
            $validate = \Validator::make($params_array, [
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'email'     => 'required|email|unique:users,'.$user->sub,
            ]);

            // Quitar campos innecesarios
            unset($params_array['id']);
            unset($params_array['role']);
            unset($params_array['password']);
            unset($params_array['created_at']);
            unset($params_array['remember_token']);

            // Actualizar BD
            $user_update = User::where('id', $user->sub)->update($params_array);

            // Devolver array con response
            $data = array(
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'El usuario se ha actualizado.',
                'user'      => $user,
                'changes'   => $params_array
            );
        } else {
            $data = array(
                'status'    => 'error',
                'code'      => 400,
                'message'   => 'El usuario no esta identificado.'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function upload(Request $request)
    {
        // Recoger datos de imagen
        $image = $request->file('file0');
        //var_dump($image);die();

        // Validar datos de imagen
        $validate = \Validator::make($request->all(), [
            'file0' => 'required|mimes:jpg,jpeg,png,gif'
        ]);

        //Guardar imagen
        if (!$image || $validate->fails()) {
            $data = array(
                'code'    => 400,
                'status' => 'error',
                'message' => 'Error al subir imagen.'
            );
        } else {
            $image_name = time() . $image->getClientOriginalName();
            \Storage::disk('users')->put($image_name, \File::get($image));

            $data = array(
                'code'    => 200,
                'status' => 'success',
                'message' => 'La imagen se subio correctamente.',
                'image' => $image_name
            );
        }

        //return response($data, $data['code'])->header('Content-Type','text/plain');
        return response()->json($data, $data['code']);
    }

    public function getImage($filename)
    {
        $isset = \Storage::disk('users')->exists($filename);
        if ($isset) {
            $file = \Storage::disk('users')->get($filename);
            return new Response($file, 200);
        } else {
            $data = array(
                'code'    => 400,
                'status' => 'error',
                'message' => 'La imagen no existe'
            );
            return response()->json($data, $data['code']);
        }
    }

    public function detail($id)
    {
        $user = User::find($id);
        if (is_object($user)) {
            $data = array(
                'code' => 200,
                'status' => 'success',
                'user' => $user
            );
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'El usuario no existe'
            );
        }
        return response()->json($data, $data['code']);
    }

    public function test(){
        return "Action Test on UserController";
    }
}
