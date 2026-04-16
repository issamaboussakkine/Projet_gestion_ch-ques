<?php

use App\Http\Controllers\ChequeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('cheques', ChequeController::class);
    Route::patch('/cheques/{cheque}/status', [ChequeController::class, 'updateStatus'])->name('cheques.updateStatus');
});