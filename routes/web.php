<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
});



Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/finances', [DepenseController::class, 'index'])->name('depenses.index');
    Route::post('/finances', [DepenseController::class, 'store'])->name('depenses.store');
    Route::get('/finances/balances', [DepenseController::class, 'balances'])->name('finances.balances');
    Route::post('/paiements/valider', [PaiementController::class, 'valider'])->name('paiements.valider');
});


Route::middleware(['auth','role:member'])->group(function () {
    Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard');
    Route::post('/colocation/create', [ColocationController::class, 'store'])->name('colocation.store');
     Route::get('/invitation/reponse/{token}', [InvitationController::class, 'showReponse'])
        ->name('invitation.reponse'); 
    Route::post('/invitation/decider', [InvitationController::class, 'decider'])
        ->name('invitation.decider');
});



Route::middleware(['auth','role:owner'])->group(function () {
   Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
   Route::get('/owner/membres', [OwnerController::class, 'membres'])->name('owner.membres');
   Route::post('/owner/inviter', [InvitationController::class, 'envoyer'])->name('owner.inviter');

   Route::get('/categories', [OwnerController::class, 'indexCategories'])->name('categories.index');
   Route::post('/categories', [OwnerController::class, 'storeCategorie'])->name('categories.store');
});