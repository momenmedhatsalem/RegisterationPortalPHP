<?php

use App\Http\Controllers\FormUserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
});

Route::post('/submit', [FormUserController::class, 'store']);
