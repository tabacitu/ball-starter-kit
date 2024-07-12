<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('settings/{section?}', \App\Livewire\Pages\SettingsPage::class)->name('settings');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', \App\Livewire\Pages\DashboardPage::class)->name('dashboard');
});
