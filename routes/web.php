<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalCheques = \App\Models\Cheque::count();
    $enAttente = \App\Models\Cheque::where('status', 'en_attente')->count();
    $valides = \App\Models\Cheque::where('status', 'valide')->count();
    $refuses = \App\Models\Cheque::where('status', 'refuse')->count();
    $montantTotal = \App\Models\Cheque::sum('amount');
    $derniersCheques = \App\Models\Cheque::with('user')->latest()->take(5)->get();
    $banques = \App\Models\Cheque::select('bank', \DB::raw('count(*) as total'))
                                 ->groupBy('bank')
                                 ->get();
    
    return view('dashboard', compact(
        'totalCheques', 
        'enAttente', 
        'valides', 
        'refuses', 
        'montantTotal', 
        'derniersCheques',
        'banques'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes séparées (chacun ajoutera ses routes dans SON fichier)
require __DIR__.'/cheques.php';
require __DIR__.'/users.php';
require __DIR__.'/statistiques.php';
require __DIR__.'/parametres.php';

require __DIR__.'/auth.php';