<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class JwtAuth{

    public $key;

    public function __construct()
    {
        $this->key = 'key_test_for_jwt_in_api-54632';
    }

    public function signin($email, $password, $getToken = null)
    {
        // Verificar si el usuario existe
        $user = User::where([
            'email'     => $email,
            'password'  => $password,
        ])->first();

        //var_dump($user);die();

        // Verificar credenciales
        $signin = false;
        if(is_object($user)){
            $signin = true;
        }

        // Generar token con datos de login
        if($signin){
            $token = array(
                'sub'       => $user->id,
                'email'     => $user->email,
                'name'      => $user->name,
                'surname'   => $user->surname,
                'iat'       => time(),
                'exp'       => time() + (7* 24 * 60 * 60)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $jwt_decoded = JWT::decode($jwt, $this->key, ['HS256']);
            
            // Devolver datos decoficados o el token
            if(is_null($getToken)){
                $data = $jwt;
            } else {
                $data = $jwt_decoded;
            }

        } else {
            // Response datos correctos
            $data = array(
                'status'    => 'error',
                'message'   => 'Login incorrecto',
            );
        }

        return $data;
    }

}