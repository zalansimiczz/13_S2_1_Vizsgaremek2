<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerAuthController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\PartnerUserController;
use App\Http\Controllers\SoforController;

/*
|--------------------------------------------------------------------------
| Alap átirányítás
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('partner.login');
});

/*
|--------------------------------------------------------------------------
| Partner autentikáció
|--------------------------------------------------------------------------
*/
Route::prefix('partner')->group(function () {

    Route::get('/login', [PartnerAuthController::class, 'showLogin'])
        ->name('partner.login');

    Route::post('/login', [PartnerAuthController::class, 'login'])
        ->name('partner.login.post');

    Route::get('/register', [PartnerAuthController::class, 'showRegister'])
        ->name('partner.register');

    Route::post('/register', [PartnerAuthController::class, 'register'])
        ->name('partner.register.post');

    Route::get('/logout', [PartnerAuthController::class, 'logout'])
        ->name('partner.logout');
});

/*
|--------------------------------------------------------------------------
| VÉDETT PARTNER ROUTE-OK
|--------------------------------------------------------------------------
*/
Route::middleware('auth.partner')
    ->prefix('partner')
    ->name('partner.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [PartnerDashboardController::class, 'index'])
            ->name('dashboard');

        // Partner felhasználók
        Route::post('/users', [PartnerUserController::class, 'store'])
            ->name('users.store');

        Route::post('/users/{id}/toggle', [PartnerUserController::class, 'toggle'])
            ->name('users.toggle');

        // Sofőrök (CRUD) - dashboardon használjuk (form action)
        Route::post('/soforok', [SoforController::class, 'store'])
            ->name('soforok.store');

        Route::put('/soforok/{id}', [SoforController::class, 'update'])
            ->name('soforok.update');

        Route::delete('/soforok/{id}', [SoforController::class, 'destroy'])
            ->name('soforok.destroy');
    });





