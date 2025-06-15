<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/category",
 *     operationId="getCategories",
 *     tags={"Categorias"},
 *     summary="Listar todas as categorias",
 *     description="Retorna a lista completa de categorias",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de categorias retornada com sucesso",
 *         )
 * )
 */
    public function index(Category $category): JsonResponse
    {
        return response()->json([
            'status' => true,
            'categories' => $category->orderBy('id', 'desc')->paginate(5),

        ])->setStatusCode(200);
    }

/**
 * @OA\Get(
 *     path="/api/category/{category}",
 *     operationId="recuperar o categoria por id",
 *     tags={"Categorias"},
 *     summary="detalhes da categoria",
 *     @OA\Parameter(
 *         name="category",
 *         in="path",
 *         description="ID da category (id e do tipo uuid precisa copiar o codigo id gerado na lista de categorias entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     security={{"bearer":{}}},
 *     description="Detalhamento da categoria",
 *     @OA\Response(
 *         response=200,
 *         description="Mostra os detalhes da categoria com sucesso",
 *     )
 * )
 */
    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'status' => true,
            'id' => $category,

        ])->setStatusCode(200);
    }

/**
 * @OA\Post(
 *     path="/api/category",
 *     operationId="Criar uma nova Categoria",
 *     tags={"Categorias"},
 *     summary="nova categoria",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Roupas"),
 *         )
 *     ),
 *     description="Criação da categoria",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=201,
 *         description="Mostra a categoria criada com sucesso",
 *     )
 * )
 */
    public function store(CategoryRequest $request) 
    {
        try {

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'categories' => $category,
            'message' => "Categoria cadastrada com sucesso",
        ])->setStatusCode(201);

        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Categoria não cadastrada",
            ])->setStatusCode(400);
        }
    }

/**
 * @OA\Put(
 *     path="/api/category/{category}",
 *     operationId="Atualizar uma categoria",
 *     tags={"Categorias"},
 *     summary="atualizar categoria",
 *     @OA\Parameter(
 *         name="category",
 *         in="path",
 *         description="ID da category (id e do tipo uuid precisa copiar o codigo id gerado na lista de categorias entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Roupas quentes"),
 *         )
 *     ),
 *     description="Atualização da categoria",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Mostra atualização da categoria com sucesso",
 *     )
 * )
 */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        try{

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'category' => $category,
            'message' => "Categoria atualizada com sucesso",
        ])->setStatusCode(200);
        
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Erro ao atualizar a categoria",
            ])->setStatusCode(400);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/category/{category}",
 *     operationId="Deletar uma Categoria",
 *     tags={"Categorias"},
 *     summary="deletar categoria",
 *     @OA\Parameter(
 *         name="category",
 *         in="path",
 *         description="ID da category (id e do tipo uuid precisa copiar o codigo id gerado na lista de categorias entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     description="categoria deletada",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Mostra a categoria deletada com sucesso",
 *         )
 *     )
 * )
 */

    public function destroy(Category $category): JsonResponse
    {
        try{

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => "Categoria deletada com sucesso",
        ])->setStatusCode(200);
        
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Erro ao deletar a categoria",
            ])->setStatusCode(400);
        }
    }
}
