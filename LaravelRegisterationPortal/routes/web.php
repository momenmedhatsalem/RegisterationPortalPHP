<?php

use App\Http\Controllers\FormUserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
});

Route::post('/submit', [FormUserController::class, 'store']);
Route::post('/check-whatsapp', [FormUserController::class, 'ajaxCheckWhatsApp'])->name('check.whatsapp');
Route::get('/check-whatsapp', [FormUserController::class, 'ajaxCheckWhatsApp'])->name('check.whatsapp');

Route::post('/check-unique', [App\Http\Controllers\UniquenessController::class, 'checkUnique']);

// routes/web.php
Route::get('/setlocale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});


