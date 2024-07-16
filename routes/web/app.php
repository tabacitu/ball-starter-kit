<?php

use App\Livewire\Pages\DashboardPage;
use App\Livewire\Pages\SettingsPage;
use App\Livewire\Pages\UserListPage;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('settings/{section?}', SettingsPage::class)->name('settings');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardPage::class)->name('dashboard');
    Route::get('user-list', UserListPage::class)->name('user-list')->middleware(['password.confirm']);
});
