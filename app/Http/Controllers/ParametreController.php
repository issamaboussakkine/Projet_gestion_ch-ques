<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParametreController extends Controller
{
    public function profil()
    {
        return view('parametres.profil');
    }
    
    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);
        
        auth()->user()->update($request->only('name', 'email'));
        
        return back()->with('success', 'Profil mis à jour');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);
        
        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);
        
        return back()->with('success', 'Mot de passe modifié');
    }
}