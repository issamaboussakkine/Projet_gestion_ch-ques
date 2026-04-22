<?php

use App\Http\Controllers\StatistiqueController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
});