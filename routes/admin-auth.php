<?php

use App\Http\Controllers\Admin\Auth\LoginAdminController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\RegisteredAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function (){
    Route::middleware('guest:admin')->group(function () {
        Route::get('register', [RegisteredAdminController::class, 'create'])->name('register');
        Route::post('register', [RegisteredAdminController::class, 'store']);

        Route::get('login', [LoginAdminController::class, 'create'])->name('login');
        Route::post('login', [LoginAdminController::class, 'store']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileAdminController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileAdminController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileAdminController::class, 'destroy'])->name('profile.destroy');

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [LoginAdminController::class, 'destroy'])->name('logout');
    });
});
