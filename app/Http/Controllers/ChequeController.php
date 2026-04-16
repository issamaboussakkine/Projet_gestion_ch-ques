<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChequeController extends Controller
{
    // Afficher la liste des chèques
   public function index(Request $request)
{
    $query = Cheque::with('user');
    
    // Filtre par statut
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    // Filtre par banque
    if ($request->filled('bank')) {
        $query->where('bank', 'like', '%' . $request->bank . '%');
    }
    
    // Recherche par client ou numéro de chèque
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('client_name', 'like', '%' . $request->search . '%')
              ->orWhere('cheque_number', 'like', '%' . $request->search . '%');
        });
    }
    
    $cheques = $query->latest()->paginate(10);
    
    // Pour garder les filtres dans la pagination
    $cheques->appends($request->all());
    
    // Liste des banques pour le filtre
    $banques = Cheque::select('bank')->distinct()->pluck('bank');
    
    return view('cheques.index', compact('cheques', 'banques'));
}

    // Afficher le formulaire d'ajout
    public function create()
    {
        return view('cheques.create');
    }

    // Enregistrer un nouveau chèque
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'bank' => 'required|string|max:255',
            'cheque_number' => 'required|string|unique:cheques',
            'date' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $cheque = new Cheque();
        $cheque->client_name = $request->client_name;
        $cheque->amount = $request->amount;
        $cheque->bank = $request->bank;
        $cheque->cheque_number = $request->cheque_number;
        $cheque->date = $request->date;
        $cheque->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cheques', 'public');
            $cheque->image = $path;
        }

        $cheque->save();

        return redirect()->route('cheques.index')->with('success', 'Chèque ajouté avec succès');
    }

    // Afficher le détail d'un chèque
    public function show($id)
    {
        $cheque = Cheque::with('user')->findOrFail($id);
        return view('cheques.show', compact('cheque'));
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $cheque = Cheque::findOrFail($id);
        return view('cheques.edit', compact('cheque'));
    }

    // Mettre à jour un chèque
    public function update(Request $request, $id)
    {
        $cheque = Cheque::findOrFail($id);

        $request->validate([
            'client_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'bank' => 'required|string|max:255',
            'cheque_number' => 'required|string|unique:cheques,cheque_number,' . $id,
            'date' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $cheque->client_name = $request->client_name;
        $cheque->amount = $request->amount;
        $cheque->bank = $request->bank;
        $cheque->cheque_number = $request->cheque_number;
        $cheque->date = $request->date;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cheques', 'public');
            $cheque->image = $path;
        }

        $cheque->save();

        return redirect()->route('cheques.index')->with('success', 'Chèque modifié avec succès');
    }

    // Supprimer un chèque
    public function destroy($id)
    {
        $cheque = Cheque::findOrFail($id);
        $cheque->delete();

        return redirect()->route('cheques.index')->with('success', 'Chèque supprimé avec succès');
    }

    // Modifier le statut
    public function updateStatus(Request $request, $id)
    {
        $cheque = Cheque::findOrFail($id);
        $cheque->status = $request->status;
        $cheque->save();

        return redirect()->route('cheques.index')->with('success', 'Statut mis à jour');
    }
}