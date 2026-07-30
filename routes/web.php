<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/bisnis-carasset', [PageController::class, 'business'])->name('business');
Route::get('/program-kemitraan', [PageController::class, 'partnership'])->name('partnership');
Route::get('/simulasi-perlindungan', [PageController::class, 'simulation'])->name('simulation');
Route::get('/tentang-kontak', [PageController::class, 'aboutContact'])->name('about-contact');
