<?php

use App\Http\Controllers\ParametreController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('parametres/profil', [ParametreController::class, 'profil'])->name('parametres.profil');
    Route::put('parametres/profil', [ParametreController::class, 'updateProfil'])->name('parametres.profil.update');
    Route::put('parametres/password', [ParametreController::class, 'updatePassword'])->name('parametres.password.update');
});