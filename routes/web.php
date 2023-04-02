<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home/spend-list-store', [HomeController::class, 'storeSpendingList'])->name('spending_list.store');

Route::get('/setting', [SettingController::class, 'index'])->name('setting');
Route::post('/setting/commitment-store', [SettingController::class, 'storeCommitment'])->name('commitment.store');