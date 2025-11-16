<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// for any others route return welcome view (for SPA)
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

