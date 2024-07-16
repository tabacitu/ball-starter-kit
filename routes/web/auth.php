<?php

use App\Livewire\Pages\Auth\ConfirmPasswordPage;
use App\Livewire\Pages\Auth\ForgotPasswordPage;
use App\Livewire\Pages\Auth\LoginPage;
use App\Livewire\Pages\Auth\RegisterPage;
use App\Livewire\Pages\Auth\ResetPasswordPage;
use App\Livewire\Pages\Auth\VerifyEmailPage;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', RegisterPage::class)->name('register');
    Route::get('login', LoginPage::class)->name('login');
    Route::get('forgot-password', ForgotPasswordPage::class)->name('password.request');
    Route::get('reset-password/{token}', ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyEmailPage::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailPage::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::get('confirm-password', ConfirmPasswordPage::class)->name('password.confirm');
    Route::post('logout', [LoginPage::class, 'logout'])->name('logout');
});
