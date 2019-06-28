<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\models\User;

class JwtAuth
{
    public $key='';
    public function __construct()
    {
        $this->key='BasspKey';
    }

    public function signUp($userEmail, $userPwd, $getToken=null)
    {
        //Buscar si existe el usuario
        $user=User::where([
          'userEmail'=>$userEmail,
          'userPwd'=>$userPwd
        ])->first();
        //Comprobar si son correctas
        $signup=false;
        if (is_object($user)) {
            $signup=true;
        }

        if ($signup) {
            //Generar el token con los datos del usuario
            //Generar el token con los datos del Usuario
            $token = [
              'userId' => $user->userId,
              'userName'=>$user->userName,
              'userEmail'=>$user->userEmail,
              'lastName'=>$user->userLastName,
              'userRolId'=>$user->userRolId,
              'iat'=>time(),
              //Una semana
              'exp'=>time()+(7*24*60*60)
            ];

            //token
            $jwt=JWT::encode($token, $this->key, 'HS256');
            //Datos del usuario
            $decoded=JWT::decode($jwt, $this->key, ['HS256']);

            if (is_null($getToken)) {
                $data=$jwt;
            } else {
                //Datos del usuario
                $data=$decoded;
            }
        } else {
            $data = [
              'code'=> 404,
              'estatus' => 'error',
              'message'=>  'Login incorrecto, el usuario con estas credenciales no existe'
            ];
        }

        //Devolver los datos decodificados o el token
        return $data;
    }

    public function checkToken($jwt, $getIdentity=false)
    {
        $auth=false;
        try {
            $jwt=str_replace('"', '', $jwt);
            $decoded=JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth=false;
        } catch (\DomainException $e) {
            $auth=false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->userId)) {
            $auth=true;
            if ($getIdentity) {
                return $decoded;
            }
        } else {
            $auth=false;
        }
        return $auth;
    }
}
