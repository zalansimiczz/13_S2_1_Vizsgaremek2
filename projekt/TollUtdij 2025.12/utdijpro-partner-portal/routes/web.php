<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\PartnerAuthController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\PartnerUserController;
use App\Http\Controllers\SoforController;
use App\Http\Controllers\JarmuController;
use App\Models\User;

//alap route
Route::get('/', function () {
    return redirect()->route('partner.login');
});

//partner auth
Route::get('/partner/login', [PartnerAuthController::class, 'showLogin'])
    ->name('partner.login');

Route::post('/partner/login', [PartnerAuthController::class, 'login'])
    ->name('partner.login.post');

Route::get('/partner/register', [PartnerAuthController::class, 'showRegister'])
    ->name('partner.register');

Route::post('/partner/register', [PartnerAuthController::class, 'register'])
    ->name('partner.register.post');

Route::get('/partner/logout', [PartnerAuthController::class, 'logout'])
    ->name('partner.logout');

//vedett routeok
    Route::middleware(['auth.partner', 'verified.partner'])
      ->prefix('partner')
      ->group(function () {

    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])
        ->name('partner.dashboard');

    //user kezeles
    Route::post('/users', [PartnerUserController::class, 'store'])
        ->name('partner.users.store');

    Route::post('/users/{id}/toggle', [PartnerUserController::class, 'toggle'])
        ->name('partner.users.toggle');

    //sofor kezeles
    Route::post('/soforok', [SoforController::class, 'store'])
        ->name('partner.soforok.store');

    Route::post('/soforok/{id}/update', [SoforController::class, 'update'])
        ->name('partner.soforok.update');

    Route::post('/soforok/{id}/toggle', [SoforController::class, 'toggle'])
        ->name('partner.soforok.toggle');

    Route::delete('/soforok/{id}', [SoforController::class, 'destroy'])
        ->name('partner.soforok.destroy');
});

//sofor kezeles
    Route::post('/jarmuvek', [JarmuController::class, 'store'])
        ->name('partner.jarmuvek.store');

    Route::post('/jarmuvek/{id}/update', [JarmuController::class, 'update'])
        ->name('partner.jarmuvek.update');

    Route::post('/jarmuvek/{id}/toggle', [JarmuController::class, 'toggle'])
        ->name('partner.jarmuvek.toggle');

    Route::delete('/jarmuvek/{id}', [JarmuController::class, 'destroy'])
        ->name('partner.jarmuvek.destroy');

//email verifikacio
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})
->middleware('auth.partner')
->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

    if (! $request->hasValidSignature()) {
        abort(403);
    }

    $user = User::findOrFail($id);

    if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    session([
        'user_id'   => $user->id,
        'ceg_id'    => $user->ceg_id,
        'user_name' => $user->teljes_nev ?: $user->email,
    ]);

    return redirect()
        ->route('partner.dashboard')
        ->with('message', 'Email sikeresen megerősítve!');

})
->middleware(['signed'])
->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {

    $user = User::findOrFail(session('user_id'));

    $user->sendEmailVerificationNotification();

    return back()->with('message', 'Email sikeresen elküldve!');

})
->middleware(['auth.partner', 'throttle:6,1'])
->name('verification.send');

//riportok
Route::get('/reports', [\App\Http\Controllers\PartnerReportController::class, 'index'])
    ->name('partner.reports');
Route::post('/reports', [\App\Http\Controllers\PartnerReportController::class, 'generate'])
    ->name('partner.reports.generate');

//settings
Route::put('/settings/profile', [PartnerSettingsController::class, 'updateProfile'])->name('settings.profile.update');
Route::put('/settings/company', [PartnerSettingsController::class, 'updateCompany'])->name('settings.company.update');

Route::post('/settings/apikeys', [PartnerSettingsController::class, 'storeApiKey'])->name('settings.apikeys.store');
Route::post('/settings/apikeys/{id}/regen', [PartnerSettingsController::class, 'regenApiKey'])->name('settings.apikeys.regen');
Route::delete('/settings/apikeys/{id}', [PartnerSettingsController::class, 'destroyApiKey'])->name('settings.apikeys.destroy');
    

