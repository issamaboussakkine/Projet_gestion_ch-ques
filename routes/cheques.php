<?php

use App\Http\Controllers\ChequeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('cheques', ChequeController::class);
    Route::patch('/cheques/{cheque}/status', [ChequeController::class, 'updateStatus'])->name('cheques.updateStatus');
    
    // Ajoute cette ligne pour la signature
    Route::post('/cheques/{id}/sign', [ChequeController::class, 'sign'])->name('cheques.sign');
});