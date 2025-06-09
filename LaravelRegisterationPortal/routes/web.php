<?php

use App\Http\Controllers\FormUserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
});

Route::post('/submit', [FormUserController::class, 'store']);
Route::post('/check-whatsapp', [FormUserController::class, 'ajaxCheckWhatsApp'])->name('check.whatsapp');



// routes/web.php
Route::get('/setlocale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});


