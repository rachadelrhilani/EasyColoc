<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('Userdashboards.dashboard'); })->name('dashboard');
    Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/colocation/create', [ColocationController::class, 'store'])->name('colocation.store');
});