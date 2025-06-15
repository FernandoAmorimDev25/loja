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

/**
 * @OA\Post(
 *     path="/api/login",
 *     operationId="login",
 *     tags={"Login"},
 *     summary="logar usúario",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="2i2ww@google.com"),
 *             @OA\Property(property="password", type="string", example="T@rt@14#"),
 *         )
 *     ),
 *     description="Login do usúario",
 *     @OA\Response(
 *         response=201,
 *         description="Mostra o usuário logado com sucesso",
 *     )
 * )
 */
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


/**
 * @OA\Post(
 *     path="/api/logout/{user}",
 *     operationId="logout",
 *     tags={"Logout"},
 *     operationId="logout",
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         description="ID do usúario (id e do tipo uuid precisa copiar o codigo id gerado na lista de produtos entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     summary="deslogar usúario",
 *     description="Logout do usúario",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=201,
 *         description="Mostra o usuário deslogado com sucesso",
 *     )
 * )
 */
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
