<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodosController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriesController;

Route::get('/status', function () {
    return response()->json(['status' => 'API is running']);
});
//register api routes here

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/user', 'user')->middleware('auth:sanctum');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

//grpoup routes for categories
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

//grpoup routes for todos
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

