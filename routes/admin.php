<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    // ── Guest-only routes (redirect to dashboard if already logged in) ──
    Route::middleware('admin.guest')->group(function () {
        Route::get('/bgc-secure-login',  [AuthController::class, 'showLogin'])->name('login');
        Route::post('/bgc-secure-login', [AuthController::class, 'login'])->name('login.post');
    });

    // ── Authenticated admin routes ──
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout',    [AuthController::class, 'logout'])->name('logout');
    });

});
