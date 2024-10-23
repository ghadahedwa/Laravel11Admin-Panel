<?php

use App\Http\Controllers\SuperAdmin\Auth\LoginSuperAdminController;
use App\Http\Controllers\SuperAdmin\ProfileSuperAdminController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SuperAdmin\Auth\RegisteredSuperAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin')->name('superadmin.')->group(function (){
    Route::middleware('guest:superadmin')->group(function () {
        Route::get('register', [RegisteredSuperAdminController::class, 'create'])->name('register');
        Route::post('register', [RegisteredSuperAdminController::class, 'store']);

        Route::get('login', [LoginSuperAdminController::class, 'create'])->name('login');
        Route::post('login', [LoginSuperAdminController::class, 'store']);
    });

    Route::middleware('auth:superadmin')->group(function () {
        Route::get('/dashboard', function () {
            return view('superadmin.dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileSuperAdminController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileSuperAdminController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileSuperAdminController::class, 'destroy'])->name('profile.destroy');

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [LoginSuperAdminController::class, 'destroy'])->name('logout');
    });
});
