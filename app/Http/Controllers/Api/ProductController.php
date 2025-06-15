<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="API de Produtos",
 *     version="1.0",
 *     description="Documentação da API de Produtos usando Swagger(antes de criar os produtos a(s) categoria precisam ser criada primeiro)",
 *     @OA\Contact(
 *         email="suporte@exemplo.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor local"
 * )
 */

class ProductController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/product",
 *     operationId="getProducts",
 *     tags={"Produtos"},
 *     summary="Listar todos os produtos",
 *     description="Retorna a lista completa de produtos",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de produtos retornada com sucesso",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="nome", type="string", example="Camiseta"),
 *                 @OA\Property(property="preco", type="number", format="float", example=49.99),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 */
     
    public function index(Product $product): JsonResponse
    {
        return response()->json([
            'status' => true,
            'products' => $product->orderBy('id', 'desc')->paginate(5),

        ])->setStatusCode(200);
    }

/**
 * @OA\Get(
 *     path="/api/product/{product}",
 *     operationId="recuperar o produto por id",
 *     tags={"Produtos"},
 *     summary="detalhes do produto",
 *     @OA\Parameter(
 *         name="product",
 *         in="path",
 *         description="ID do Produto (id e do tipo uuid precisa copiar o codigo id gerado na lista de produtos entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     description="Detalhamento do produto",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Mostra o detalhe do produto com sucesso",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="nome", type="string", example="Camiseta"),
 *                 @OA\Property(property="preco", type="number", format="float", example=49.99),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'status' => true,
            'id' => $product,

        ])->setStatusCode(200);
    }

/**
 * @OA\Post(
 *     path="/api/product",
 *     operationId="Criar um novo Produto",
 *     tags={"Produtos"},
 *     summary="novo do produto",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Camiseta"),
 *             @OA\Property(property="description", type="string", example="Descrição da camiseta"),
 *             @OA\Property(property="price", type="number", format="float", example=49.99),
 *             @OA\Property(property="quantity", type="integer", example=10),
 *             @OA\Property(property="category_id", type="string", example="9f2846be-da65-44f6-b453-6abdde55acb1"),
 *         )
 *     ),
 *     description="Criação do produto",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=201,
 *         description="Mostra o produto criado com sucesso",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="nome", type="string", example="Camiseta"),
 *                 @OA\Property(property="preco", type="number", format="float", example=49.99),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="category_id", type="string", example="9f2846be-da65-44f6-b453-6abdde55acb1"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 */
    
    public function store(ProductRequest $request) 
    {
        try {

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'status' => true,
            'products' => $product,
            'message' => "Produto cadastrado com sucesso",
        ])->setStatusCode(201);

        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Produto não cadastrado",
            ])->setStatusCode(400);
        }
    }

/**
 * @OA\Put(
 *     path="/api/product/{product}",
 *     operationId="Atualizar um Produto",
 *     tags={"Produtos"},
 *     summary="atualizar produto",
 *     @OA\Parameter(
 *         name="product",
 *         in="path",
 *         description="ID do Produto (id e do tipo uuid precisa copiar o codigo id gerado na lista de produtos entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Camiseta do guns"),
 *             @OA\Property(property="description", type="string", example="Descrição da camiseta"),
 *             @OA\Property(property="price", type="number", format="float", example=49.99),
 *             @OA\Property(property="quantity", type="integer", example=10),
 *             @OA\Property(property="category_id", type="string", example="9f2846be-da65-44f6-b453-6abdde55acb1"),
 *         )
 *     ),
 *     description="Atualização do produto",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Mostra atualização do produto com sucesso",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="nome", type="string", example="Camiseta"),
 *                 @OA\Property(property="preco", type="number", format="float", example=49.99),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        try{

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'status' => true,
            'product' => $product,
            'message' => "Produto atualizado com sucesso",
        ])->setStatusCode(200);
        
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Erro ao atualizar o Produto",
            ])->setStatusCode(400);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/product/{product}",
 *     operationId="Deletar um Produto",
 *     tags={"Produtos"},
 *     summary="deletar produto",
 *     @OA\Parameter(
 *         name="product",
 *         in="path",
 *         description="ID do Produto (id e do tipo uuid precisa copiar o codigo id gerado na lista de produtos entre as aspas duplas e colar no campo abaixo)",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     description="Ele não deleta o produto inteiro, apenas diminui quantidade e quando essa quantidade chegar a zero ele deleta o produto,
 *     o valor colocado é 1 para demonstrar o funcionamento,mas pode ser alterado dependendo do valor inserido no frontend",
 *     security={{"bearer":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Mostra atualização do produto com sucesso",
 *         )
 *     )
 * )
 */
    public function destroy(Product $product, $quantidadeRemovida = 1): JsonResponse
    {
        try{
            $product->quantity -= $quantidadeRemovida;

            if ($product->quantity <= 0) 
            {
                $product->quantity = 0;
                $product->delete();
            }
            else 
            {
                $product->save();
            }

        return response()->json([
            'status' => true,
            'message' => "produto deletado com sucesso",
        ])->setStatusCode(200);
        
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Erro ao deletar o produto",
            ])->setStatusCode(400);
        }
    }
}
