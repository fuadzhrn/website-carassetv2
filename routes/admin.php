<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ModulePlaceholderController;
use App\Http\Controllers\Admin\PageWorkspaceController;
use App\Http\Controllers\Admin\Pages\BusinessController;
use App\Http\Controllers\Admin\Pages\BusinessSectionController;
use App\Http\Controllers\Admin\Pages\HomeController;
use App\Http\Controllers\Admin\Pages\HomeSectionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SiteSettingController;
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

        Route::get('pages/home', [HomeController::class, 'index'])->name('admin.pages.home');
        Route::patch('pages/home/sections/{sectionKey}', [HomeSectionController::class, 'update'])
            ->whereIn('sectionKey', ['hero', 'income-opportunity', 'process-summary', 'partnership-choice', 'consultation-cta'])
            ->name('admin.pages.home.sections.update');

        Route::get('pages/business', [BusinessController::class, 'index'])->name('admin.pages.business');
        Route::patch('pages/business/sections/{sectionKey}', [BusinessSectionController::class, 'update'])
            ->whereIn('sectionKey', ['opportunity', 'own', 'operate', 'grow', 'business-flow'])
            ->name('admin.pages.business.sections.update');

        Route::get('pages/partnership', [PageWorkspaceController::class, 'partnership'])->name('admin.pages.partnership');
        Route::get('pages/simulation', [PageWorkspaceController::class, 'simulation'])->name('admin.pages.simulation');
        Route::get('pages/about-contact', [PageWorkspaceController::class, 'aboutContact'])->name('admin.pages.about-contact');

        Route::get('media', [MediaController::class, 'index'])->name('admin.media.index');
        Route::get('media/create', [MediaController::class, 'create'])->name('admin.media.create');
        Route::post('media', [MediaController::class, 'store'])->name('admin.media.store');
        Route::get('media/{media}/edit', [MediaController::class, 'edit'])->name('admin.media.edit');
        Route::patch('media/{media}', [MediaController::class, 'update'])->name('admin.media.update');
        Route::put('media/{media}/replace', [MediaController::class, 'replace'])->name('admin.media.replace');
        Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('admin.media.destroy');

        Route::get('seo', [ModulePlaceholderController::class, 'seo'])->name('admin.seo.index');
        Route::get('messages', [ModulePlaceholderController::class, 'messages'])->name('admin.messages.index');

        Route::get('settings', [SiteSettingController::class, 'index'])->name('admin.settings.index');
        Route::patch('settings', [SiteSettingController::class, 'update'])->name('admin.settings.update');
    });
});
