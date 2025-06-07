<?php

use App\Http\Controllers\FormUserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/store', [FormUserController::class, 'store']);