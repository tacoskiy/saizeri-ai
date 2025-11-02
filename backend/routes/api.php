<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MenuController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/token', fn() => response()->json([
        'success' => true,
    ]));
    Route::prefix('message')->group(function () {
        Route::get('/logs', [MessageController::class, 'index']);
        Route::post('/', [MessageController::class, 'store']);
    });
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index']);
        Route::get('/search', [MenuController::class, 'search']);
        Route::post('/update/{menuId}', [MenuController::class, 'update']);
    });
});