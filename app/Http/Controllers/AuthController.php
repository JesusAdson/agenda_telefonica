<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credenciais = $request->all(['email', 'password']);
        
        $token = auth('api')->attempt($credenciais);

        if($token){
            return $this->respondWithToken($token);
        }else{
            return response()->json(['erro' => 'Usuário ou senha inválidos'], 403);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['sucesso' => 'Deslogado']);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}
