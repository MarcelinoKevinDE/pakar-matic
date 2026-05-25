<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\Admin\AdminDashboardController;

// Root redirect
Route::get('/', fn() => redirect()->route('diagnosa.index'));

// Public diagnosis routes
Route::prefix('diagnosa')->name('diagnosa.')->group(function () {
    Route::get('/',        [DiagnosaController::class, 'index']) ->name('index');
    Route::post('/proses', [DiagnosaController::class, 'proses'])->name('proses');
    // Safety redirect — catches stale browser GET on proses URL
    Route::get('/proses',  fn() => redirect()->route('diagnosa.index'));
});

// About page
Route::get('/about', [DiagnosaController::class, 'about'])->name('about');

// Admin routes — protect with your auth middleware
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard',              [AdminDashboardController::class, 'index'])      ->name('dashboard');
    Route::get('/history',                [AdminDashboardController::class, 'history'])    ->name('history');
    Route::get('/history/{diagnosisHistory}', [AdminDashboardController::class, 'historyShow'])->name('history.show');
});