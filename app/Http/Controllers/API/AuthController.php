<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create($request->input());
        $user->password = bcrypt($request->password);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken,
            'message' => "registro realizado com sucesso!",
            'status' => Response::HTTP_OK
        ]);
    }

    public function login(AuthLoginRequest $request)
    {
        $loginData = $request->except(['name']);

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

    public function authorized()
    {
        return response([
            'message' => "Acesso negado! Você precisa estar logado para realizar esta operação!",
            'status' => Response::HTTP_UNAUTHORIZED
        ]);
    }
}
