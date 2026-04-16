<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\User;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index()
    {
        $totalCheques = Cheque::count();
        $chequesEnAttente = Cheque::where('status', 'en_attente')->count();
        $chequesValides = Cheque::where('status', 'valide')->count();
        $chequesRefuses = Cheque::where('status', 'refuse')->count();
        
        $banques = Cheque::select('bank', \DB::raw('count(*) as total'))
            ->groupBy('bank')
            ->get();
        
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalEmployes = User::where('role', 'employe')->count();
        
        return view('statistiques.index', compact(
            'totalCheques', 'chequesEnAttente', 'chequesValides', 'chequesRefuses',
            'banques', 'totalUsers', 'totalAdmins', 'totalEmployes'
        ));
    }
}