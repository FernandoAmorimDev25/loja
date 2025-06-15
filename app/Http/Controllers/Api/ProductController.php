<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Product $product): JsonResponse
    {
        /*$users = User::paginate(3);
        
        if(!empty(Request::get('name')))
        {
            $users = User::where([['name', 'like', '%'.Request::get('name').'%']])->get();
        }
        if(!empty(Request::get('email')))
        {
            $users = User::where([['email', 'like', '%'.Request::get('email').'%']])->get();
        }

        $paginate = User::paginate(3);*/

        return response()->json([
            'status' => true,
            'products' => $product->orderBy('id', 'desc')->paginate(5),

        ])->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'status' => true,
            'id' => $product,

        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request) 
    {
        try {
            
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category' => $request->category,
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
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        try{

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category' => $request->category,
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
     * Remove the specified resource from storage.
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
