<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerAuthController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\PartnerUserController;

Route::get('/', function () {
    return redirect()->route('partner.login');
});

// Auth
Route::get('/partner/login', [PartnerAuthController::class, 'showLogin'])->name('partner.login');
Route::post('/partner/login', [PartnerAuthController::class, 'login'])->name('partner.login.post');

Route::get('/partner/register', [PartnerAuthController::class, 'showRegister'])->name('partner.register');
Route::post('/partner/register', [PartnerAuthController::class, 'register'])->name('partner.register.post');

Route::get('/partner/logout', [PartnerAuthController::class, 'logout'])->name('partner.logout');

// Protected partner routes
Route::middleware('auth.partner')->prefix('partner')->group(function () {
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('partner.dashboard');

    Route::post('/users', [PartnerUserController::class, 'store'])->name('partner.users.store');
    Route::post('/users/{id}/toggle', [PartnerUserController::class, 'toggle'])->name('partner.users.toggle');
});
