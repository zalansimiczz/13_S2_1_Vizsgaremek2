<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerAuthController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\PartnerUserController;
use App\Http\Controllers\SoforController;

Route::get('/', function () {
    return redirect()->route('partner.login');
});

//autentikacio route
Route::get('/partner/login', [PartnerAuthController::class, 'showLogin'])->name('partner.login');
Route::post('/partner/login', [PartnerAuthController::class, 'login'])->name('partner.login.post');
Route::get('/partner/register', [PartnerAuthController::class, 'showRegister'])->name('partner.register');
Route::post('/partner/register', [PartnerAuthController::class, 'register'])->name('partner.register.post');
Route::get('/partner/logout', [PartnerAuthController::class, 'logout'])->name('partner.logout');

//partner routeok
Route::middleware('auth.partner')->prefix('partner')->group(function () {
Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('partner.dashboard');

//userek kezelese route
Route::post('/users', [PartnerUserController::class, 'store'])->name('partner.users.store');
Route::post('/users/{id}/toggle', [PartnerUserController::class, 'toggle'])->name('partner.users.toggle');

//soforok kezelese routeok
Route::post('/soforok', [SoforController::class, 'store'])->name('partner.soforok.store');
Route::post('/soforok/{id}/update', [SoforController::class, 'update'])->name('partner.soforok.update');
Route::post('/soforok/{id}/toggle', [SoforController::class, 'toggle'])->name('partner.soforok.toggle');
Route::delete('/soforok/{id}', [SoforController::class, 'destroy'])->name('partner.soforok.destroy');
});