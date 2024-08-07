<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Rotas de autenticação e usuario
 */

Route::middleware('auth:api')->get('/', [UserController::class, 'show']);
Route::post('/login', [UserController::class, 'login']);
