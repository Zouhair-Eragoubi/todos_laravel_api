<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todos', [App\Http\Controllers\TodosController::class, 'index']);

