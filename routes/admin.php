<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InternApplicationController;
use App\Http\Controllers\Admin\NewsletterController;
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

        // Member applications
        Route::get('/applications',                              [ApplicationController::class, 'index'])->name('applications');
        Route::get('/applications/{application}',               [ApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}/status',      [ApplicationController::class, 'updateStatus'])->name('applications.status');

        // Intern applications
        Route::get('/intern-applications',                                [InternApplicationController::class, 'index'])->name('intern-applications');
        Route::get('/intern-applications/{internApplication}',           [InternApplicationController::class, 'show'])->name('intern-applications.show');
        Route::patch('/intern-applications/{internApplication}/status',  [InternApplicationController::class, 'updateStatus'])->name('intern-applications.status');

        // Newsletter subscribers
        Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletters');

        // Admin users
        Route::get('/admin-users',                    [AdminUserController::class, 'index'])->name('admin-users');
        Route::get('/admin-users/create',             [AdminUserController::class, 'create'])->name('admin-users.create');
        Route::post('/admin-users',                   [AdminUserController::class, 'store'])->name('admin-users.store');
        Route::get('/admin-users/{adminUser}/edit',   [AdminUserController::class, 'edit'])->name('admin-users.edit');
        Route::put('/admin-users/{adminUser}',        [AdminUserController::class, 'update'])->name('admin-users.update');
        Route::delete('/admin-users/{adminUser}',     [AdminUserController::class, 'destroy'])->name('admin-users.destroy');
    });

});
