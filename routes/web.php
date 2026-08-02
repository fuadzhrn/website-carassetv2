<?php

use App\Http\Controllers\Public\ContactFormController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/bisnis-carasset', [PageController::class, 'business'])->name('business');
Route::get('/program-kemitraan', [PageController::class, 'partnership'])->name('partnership');
Route::get('/simulasi-perlindungan', [PageController::class, 'simulation'])->name('simulation');
Route::get('/tentang-kontak', [PageController::class, 'aboutContact'])->name('about-contact');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::post('/konsultasi', [ContactFormController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('consultation.store');
