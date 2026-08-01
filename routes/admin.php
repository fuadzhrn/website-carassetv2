<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModulePlaceholderController;
use App\Http\Controllers\Admin\PageWorkspaceController;
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

        Route::get('pages', [PageWorkspaceController::class, 'index'])->name('admin.pages.index');
        Route::get('pages/home', [PageWorkspaceController::class, 'home'])->name('admin.pages.home');
        Route::get('pages/business', [PageWorkspaceController::class, 'business'])->name('admin.pages.business');
        Route::get('pages/partnership', [PageWorkspaceController::class, 'partnership'])->name('admin.pages.partnership');
        Route::get('pages/simulation', [PageWorkspaceController::class, 'simulation'])->name('admin.pages.simulation');
        Route::get('pages/about-contact', [PageWorkspaceController::class, 'aboutContact'])->name('admin.pages.about-contact');

        Route::get('media', [ModulePlaceholderController::class, 'media'])->name('admin.media.index');
        Route::get('seo', [ModulePlaceholderController::class, 'seo'])->name('admin.seo.index');
        Route::get('messages', [ModulePlaceholderController::class, 'messages'])->name('admin.messages.index');
        Route::get('settings', [ModulePlaceholderController::class, 'settings'])->name('admin.settings.index');
    });
});
