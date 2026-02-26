<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
});



Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/invitation/reponse/{token}', [InvitationController::class, 'showReponse'])
        ->name('invitation.reponse')
        ->middleware('signed'); // Middleware crucial pour la sécurité Gmail
    // reponse de user
    Route::post('/invitation/decider', [InvitationController::class, 'decider'])
        ->name('invitation.decider');
});


Route::middleware(['auth','role:member'])->group(function () {
    Route::post('/colocation/create', [ColocationController::class, 'store'])->name('colocation.store');
});



Route::middleware(['auth','role:owner'])->group(function () {
   Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
   //membres
   Route::get('/owner/membres', [OwnerController::class, 'membres'])->name('owner.membres');
   Route::post('/owner/inviter', [InvitationController::class, 'envoyer'])->name('owner.inviter');

   Route::get('/categories', [OwnerController::class, 'indexCategories'])->name('categories.index');
   Route::post('/categories', [OwnerController::class, 'storeCategorie'])->name('categories.store');
});