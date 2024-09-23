<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json(['message' => 'Api Laravel JWT!']);
});

Route::prefix('/users')->group( base_path('routes/users/users_routes.php'));
Route::prefix('/docs')->group(base_path('routes/docs/docs_routes.php'))->middleware('api');
