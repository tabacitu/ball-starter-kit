<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [AuthController::class, 'verifyEmailNotice'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::get('confirm-password', [AuthController::class, 'confirmPassword'])->name('password.confirm');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
