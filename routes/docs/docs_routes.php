<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocController;
use Illuminate\Support\Facades\Route;

/**
 * Rotas dautenticadas
 */

Route::get('/', [DocController::class, 'index'])->name('docs');
Route::get('/{id}', [DocController::class, 'show'])->name('doc.index');
