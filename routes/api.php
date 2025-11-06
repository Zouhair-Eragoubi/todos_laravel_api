<?php

use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(['status' => 'API is running']);
});
//grpoup routes for categories
Route::prefix('categories')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\CategoriesController::class, 'index']);
    Route::post('create', [App\Http\Controllers\Api\CategoriesController::class, 'store']);
    Route::get('show/{id}', [App\Http\Controllers\Api\CategoriesController::class, 'show']);
    Route::put('update/{id}', [App\Http\Controllers\Api\CategoriesController::class, 'update']);
    Route::delete('delete/{id}', [App\Http\Controllers\Api\CategoriesController::class, 'destroy']);
});

//grpoup routes for todos
Route::prefix('todos')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\TodosController::class, 'index']);
    Route::post('create', [App\Http\Controllers\Api\TodosController::class, 'store']);
    Route::get('show/{id}', [App\Http\Controllers\Api\TodosController:: class, 'show']);
    Route::put('update/{id}', [App\Http\Controllers\Api\TodosController::class, 'update']);
    Route::delete('delete/{id}', [App\Http\Controllers\Api\TodosController::class, 'destroy']);
    Route::patch('toggle-completion/{id}', [App\Http\Controllers\Api\TodosController::class, 'toggleCompletion']);
});

