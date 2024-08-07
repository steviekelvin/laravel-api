<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/users')->group( base_path('routes/users/users_routes.php'));
Route::middleware('auth:api')->prefix('/docs')->group(base_path('routes/docs/docs_routes.php'));
