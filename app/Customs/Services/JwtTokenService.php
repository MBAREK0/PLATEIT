<?php

namespace App\Customs\Services;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\Key;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;
class JwtTokenService
{
    public function decode($token)
    {
        $token = str_replace('Bearer ', '', $token);
        $secretKey = env('JWT_SECRET');
        $decoded = null;
        $decoded = JWT::decode($token,new Key($secretKey,'HS256'));
        return  $decoded;
    }

    public function encode($payload)
    {
        $secretKey = env('JWT_SECRET');
        $jwt = JWT::encode($payload, $secretKey, 'HS256');
        return $jwt;
    }

    public function refresh($token){
        $decodedToken = $this->decode($token);
        $decodedToken->exp = Carbon::now()->addMinutes(2*60)->timestamp;
        $decodedToken->jti = Str::random(32);
        $decodedToken->iat = Carbon::now()->timestamp;
        $decodedToken->nbf = Carbon::now()->timestamp;
        $newToken = $this->encode((array)$decodedToken);
        return $newToken;
    }
    public function get_user($token){
        $decodedToken = $this->decode($token);
        $user_id = $decodedToken->sub;
        $user = User::where('id', $user_id)->first();
        if(!$user){
            return false;
        }
        return $user;
    }

    public function validateCredentials($email, $password){
        $data['error'] = '';
        $user = User::where('email', $email)->first();
        if(!$user){
            $data['error'] = 'User Not Found !';
            $data['http_code'] = 404;
            return $data;
        }

        if(!Hash::check($password, $user->password)){
            $data['error'] = 'passwod incorrect';
            $data['http_code'] = 401;
            return $data;

        }

        $data['user']= $user;
        $data['token'] = $this->genarateToken($user->id);
        $data['http_code'] = 200;
        return $data;

    }

    public function genarateToken($user_id){

            $user = User::where('id', $user_id)->first();
        $secretKey = env('JWT_SECRET');
        $token = JWT::encode(
            array(
             'iss' => 'http://127.0.0.1:8000/api/auth/login',
             'iat' => time(),
             'nbf' => time(),
             'exp' => time()+ 2 * 3600,
             'sub' => $user_id,
             'data' =>array(
                 'user_id' => $user->id,
                 'role' =>$user->role
             )
            ),
            $secretKey,
            'HS256'
        );
        return $token;
    }
    public function get_role($token){
        $token_decoded = $this->decode($token);
        return $token_decoded->data->role;
    }
}
