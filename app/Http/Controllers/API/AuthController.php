<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validateData['password'] = bcrypt($request->password);

        $user = User::create($validateData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken,
            'message' => "registro realizado com sucesso!",
            'status' => Response::HTTP_OK
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)){
            return response([
                'message' => 'Credenciais Inválidas!',
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'access_token' => $accessToken,
            'message' => "login realizado com sucesso!",
            'status' => Response::HTTP_OK
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user()->tokens()->delete();

        return response([
            'user' => $user,
            'message' => 'logout efetuado com sucesso!',
            'status' => Response::HTTP_OK
        ]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function unauthorized()
    {
        return response([
            'message' => "Acesso negado! Você precisa estar logado para realizar esta operação!",
            'status' => Response::HTTP_UNAUTHORIZED
        ]);
    }
}
