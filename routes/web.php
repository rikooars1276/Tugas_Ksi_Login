<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

// ================= ROOT =================
Route::get('/', function () {
    return redirect()->route('login');
});

// ================= LOGIN =================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'proseslogin'])
    ->name('login');

// ================= REGISTER =================
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

// ================= DASHBOARD =================
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

// ================= EMAIL VERIFICATION =================

// halaman notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// proses verify
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    $request->fulfill();

    return redirect('/dashboard');

})->middleware(['auth', 'signed'])->name('verification.verify');

// kirim ulang email
Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Link verifikasi dikirim ulang!');

})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ================= FORGOT PASSWORD =================

// halaman forgot password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('password.request');

// kirim link reset password
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
    ->name('password.email');

// halaman reset password
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
    ->name('password.reset');

// proses reset password
Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');