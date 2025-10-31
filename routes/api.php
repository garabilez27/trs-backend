<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth:api')->group(function() {
    Route::get('users/me', [AuthController::class, 'me']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);

    Route::post('products', [ProductController::class, 'store']);

    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    Route::put('products/{id}', [ProductController::class, 'update']);
});