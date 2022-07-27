<?php

use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
    Route::post('check-email', 'checkEmail')->name('check_email');
    Route::post('check-hash', 'checkHash')->name('check_hash');
    Route::post('forget-password', 'forgetPassword')->name('forget_password');
    Route::post('reset-password', 'resetPassword')->name('reset_password');
    Route::get('check-token', 'checkToken')->name('check_token')->middleware('auth:sanctum');
    Route::get('logout', 'logout')->name('logout')->middleware('auth:sanctum');
    Route::post('profile', 'profile')->name('profile')->middleware('auth:sanctum');
});
