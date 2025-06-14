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
     * Display a listing of the resource.
     */
    public function index(User $user): JsonResponse
    {

        return response()->json([
            'status' => true,
            'users' => $user->orderBy('id', 'desc')->paginate(5),

        ])->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => true,
            'id' => $user,

        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
