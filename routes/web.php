<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/')->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/home/spending-stat', [HomeController::class, 'spendingStat']);
    
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    
    Route::get('/setting/commitment-list', [SettingController::class, 'listCommitment'])->name('commitment.list');
    Route::post('/setting/commitment-store', [SettingController::class, 'storeCommitment'])->name('commitment.store');
    Route::post('/setting/commitment-update', [SettingController::class, 'updateCommitment'])->name('commitment.update');
    Route::get('/setting/commitment-delete/{id}', [SettingController::class, 'deleteCommitment'])->name('commitment.delete');
    
    Route::post('/setting/spend-list-store', [SettingController::class, 'storeSpendingList'])->name('spending_list.store');
});