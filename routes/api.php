<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

 


Route::post('/login',[LoginController::class,'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/users',[UserController::class,'index']);
    Route::post('/logout/{user}',[LoginController::class,'logout']);
});

//Route::get('/users',[UserController::class,'index']);
Route::get('/users/{user}',[UserController::class,'show']);
Route::post('/users',[UserController::class,'store']);
Route::put('/users/{user}',[UserController::class,'update']);
Route::delete('/users/{user}',[UserController::class,'destroy']);



Route::get('/product',[ProductController::class,'index']);
Route::get('/product/{product}',[ProductController::class,'show']);
Route::post('/product',[ProductController::class,'store']);
Route::put('/product/{product}',[ProductController::class,'update']);
Route::delete('/product/{product}',[ProductController::class,'destroy']); 