<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\ChequeController;
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

// Routes Google Login
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->middleware('web');
// Route OCR
Route::post('/ocr/scan', [OcrController::class, 'scan'])->middleware(['auth'])->name('ocr.scan');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/test-auth', function () {
    return response()->json([
        'auth_check' => Auth::check(),
        'session_id' => session()->getId(),
        'cookies' => request()->cookies->all(),
    ]);
})->middleware('auth');

// Routes séparées
require __DIR__.'/cheques.php';
require __DIR__.'/users.php';
require __DIR__.'/statistiques.php';
require __DIR__.'/parametres.php';



require __DIR__.'/auth.php';