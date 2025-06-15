<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

 


Route::post('/login',[LoginController::class,'login'])->name('login');

//Criei essas rotas para criarem seus usuários para o login e logout caso nao queriam usar as seeders e factories

Route::get('/users',[UserController::class,'index']);
Route::get('/users/{user}',[UserController::class,'show']);
Route::post('/users',[UserController::class,'store']);
Route::put('/users/{user}',[UserController::class,'update']);
Route::delete('/users/{user}',[UserController::class,'destroy']);

//rotas de autenticacao
Route::group(['middleware' => ['auth:sanctum']], function () {

Route::get('/product',[ProductController::class,'index']);
Route::get('/product/{product}',[ProductController::class,'show']);
Route::post('/product',[ProductController::class,'store']);
Route::put('/product/{product}',[ProductController::class,'update']);
Route::delete('/product/{product}',[ProductController::class,'destroy']);

Route::get('/category',[CategoryController::class,'index']);
Route::get('/category/{category}',[CategoryController::class,'show']);
Route::post('/category',[CategoryController::class,'store']);
Route::put('/category/{category}',[CategoryController::class,'update']);
Route::delete('/category/{category}',[CategoryController::class,'destroy']);

Route::post('/logout/{user}',[LoginController::class,'logout']);
});



