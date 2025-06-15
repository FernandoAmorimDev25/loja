<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/users",
 *     operationId="getUsers",
 *     tags={"Usúarios"},
 *     summary="Listar todos os usuários",
 *     description="Retorna a lista completa de usúarios",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de usúarios retornada com sucesso",
 *         )
 * )
 */
    public function index(User $user): JsonResponse
    {

        return response()->json([
            'status' => true,
            'users' => $user->orderBy('id', 'desc')->paginate(5),

        ])->setStatusCode(200);
    }

/**
 * @OA\Get(
 *     path="/api/users/{user}",
 *     operationId="recuperar o usúario por id",
 *     tags={"Usúarios"},
 *     summary="detalhes do usuário",
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         description="ID do usúario (id e do tipo uuid e necessario copiar o codigo id gerado na lista de usúarios entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     description="Detalhamento do usúario",
 *     @OA\Response(
 *         response=200,
 *         description="Mostra os detalhes do usúario com sucesso",
 *     )
 * )
 */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => true,
            'id' => $user,

        ])->setStatusCode(200);
    }

/**
 * @OA\Post(
 *     path="/api/users",
 *     operationId="Criar um novo Usúario",
 *     tags={"Usúarios"},
 *     summary="novo usúario",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="João silva"),
 *             @OA\Property(property="email", type="string", example="2i2ww@google.com"),
 *             @OA\Property(property="password", type="string", example="T@rt@14#"),
 *         )
 *     ),
 *     description="Criação do usúario",
 *     @OA\Response(
 *         response=201,
 *         description="Mostra o usuário criado com sucesso",
 *     )
 * )
 */
    public function store(UserRequest $request)
    {
        try {
            
        $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => "Usuário cadastrado com sucesso",
        ])->setStatusCode(201);

        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Usuário não cadastrado",
            ])->setStatusCode(400);
        }
    }

   /**
 * @OA\Put(
 *     path="/api/users/{user}",
 *     operationId="Atualizar um usúario",
 *     tags={"Usúarios"},
 *     summary="atualizar usúario",
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *          description="ID do usúario (id e do tipo uuid e necessario copiar o codigo id gerado na lista de usúarios entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="João silva souza"),
 *             @OA\Property(property="email", type="string", example="joao@google.com"),
 *             @OA\Property(property="password", type="string", example="T@rt@14#"),
 *         )
 *     ),
 *     description="Atualização do usúario",
 *     @OA\Response(
 *         response=200,
 *         description="Mostra atualização do usúario com sucesso",
 *     )
 * )
 */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        try{

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => "Usuário atualizado com sucesso",
        ])->setStatusCode(200);
        
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Usuário não atualizado",
            ])->setStatusCode(400);
        }
    }

   /**
 * @OA\Delete(
 *     path="/api/users/{user}",
 *     operationId="Deletar um usúario",
 *     tags={"Usúarios"},
 *     summary="deletar usúario",
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         description="ID do usúario (id e do tipo uuid e necessario copiar o codigo id gerado na lista de usúarios entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     description="categoria deletada",
 *     @OA\Response(
 *         response=200,
 *         description="Mostra o usúario deletado com sucesso",
 *         )
 *     )
 * )
 */
    public function destroy(User $user): JsonResponse
    {
        try{

        $user->delete();
        return response()->json([
            'status' => true,
            'message' => "Usuário deletado com sucesso",
        ])->setStatusCode(200);
        
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Erro ao deletar usuário",
            ])->setStatusCode(400);
        }
    }
}
