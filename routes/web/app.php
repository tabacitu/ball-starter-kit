<?php

use App\Http\Controllers\AccountSettingsController;
use App\Livewire\Pages\DashboardPage;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('account-settings', [AccountSettingsController::class, 'index'])->name('account.settings');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardPage::class)->name('dashboard');
});
