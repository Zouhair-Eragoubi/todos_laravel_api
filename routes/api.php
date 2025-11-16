<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodosController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriesController;

// test route
Route::get('/status', function () {
    return response()->json(['status' => 'API is running']);
});

//auth routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/user', 'user')->middleware('auth:sanctum');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

//group routes for categories
Route::prefix('categories')
    ->controller(CategoriesController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('create', 'store');
        Route::get('show/{id}', 'show');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
    });

//group routes for todos
Route::prefix('todos')
    ->middleware('auth:sanctum')
    ->controller(TodosController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('create', 'store');
        Route::get('show/{id}', 'show');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
        Route::patch('toggle-completion/{id}', 'toggleCompletion');
    });

