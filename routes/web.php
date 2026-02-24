<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


    Route::get('/', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});