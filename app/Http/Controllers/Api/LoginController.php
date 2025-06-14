<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) 
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) 
        {
          $user = Auth::user();

          $token = $request->user()->createToken('api-Token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'Usuário logado com sucesso',
            ], 201);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Email ou senha inválidos',
            ], 404);    
        }
    }

    public function logout(User $user): JsonResponse
        {
            try{
                $user->tokens()->delete();
                
                return response()->json([
                    'status' => true,
                    'message' => "logout realizado com sucesso",
                ])->setStatusCode(200);
            }catch (Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => "Erro ao realizar logout",
                ])->setStatusCode(400);
            }
        }
}
