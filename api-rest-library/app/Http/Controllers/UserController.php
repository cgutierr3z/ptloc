<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        if($checkToken){
            echo 'LOGIN';
        } else {
            echo 'PLEASE LOGIN';
        }

        die();
    }

    public function test(){
        return "Action Test on UserController";
    }
}
