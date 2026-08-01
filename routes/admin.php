<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('admin.security-headers')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('admin.login');
        Route::post('login', [LoginController::class, 'store'])->name('admin.login.attempt');
    });

    Route::middleware(['auth', 'admin.role', 'admin.active'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');

        Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::put('profile/password', [PasswordController::class, 'update'])->name('admin.password.update');
    });
});
