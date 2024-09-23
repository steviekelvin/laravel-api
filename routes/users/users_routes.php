<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Rotas de autenticação e usuario
 */
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('/', [UserController::class, 'show']);
});
