<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChequeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cheque::with('user');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('bank')) {
            $query->where('bank', 'like', '%' . $request->bank . '%');
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('client_name', 'like', '%' . $request->search . '%')
                  ->orWhere('cheque_number', 'like', '%' . $request->search . '%');
            });
        }
        
        $cheques = $query->latest()->paginate(10);
        $cheques->appends($request->all());
        $banques = Cheque::select('bank')->distinct()->pluck('bank');
        
        return view('cheques.index', compact('cheques', 'banques'));
    }

    public function create()
    {
        return view('cheques.create');
    }

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

    public function show($id)
    {
        $cheque = Cheque::with('user')->findOrFail($id);
        return view('cheques.show', compact('cheque'));
    }

    public function edit($id)
    {
        $cheque = Cheque::findOrFail($id);
        return view('cheques.edit', compact('cheque'));
    }

   public function update(Request $request, $id)
{
    $cheque = Cheque::findOrFail($id);

    $request->validate([
        'client_name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'bank' => 'required|string|max:255',
        'cheque_number' => 'required|string|unique:cheques,cheque_number,' . $id,
        'date' => 'required|date',
        'status' => 'required|in:en_attente,valide,refuse', // ✅ AJOUTÉ
        'image' => 'nullable|image|max:2048',
    ]);

    $cheque->client_name = $request->client_name;
    $cheque->amount = $request->amount;
    $cheque->bank = $request->bank;
    $cheque->cheque_number = $request->cheque_number;
    $cheque->date = $request->date;
    $cheque->status = $request->status; // ✅ AJOUTÉ

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('cheques', 'public');
        $cheque->image = $path;
    }

    $cheque->save();

    return redirect()->route('cheques.index')->with('success', 'Chèque modifié avec succès');
}

    public function destroy($id)
    {
        $cheque = Cheque::findOrFail($id);
        $cheque->delete();

        return redirect()->route('cheques.index')->with('success', 'Chèque supprimé avec succès');
    }

    public function updateStatus(Request $request, $id)
{
    
    $cheque = Cheque::findOrFail($id);
    $cheque->status = $request->status;
    
    if ($request->status !== 'valide') {
        $cheque->is_signed = false;
        $cheque->signature_data = null;
        $cheque->signed_by = null;
        $cheque->signed_at = null;
    }
    
    $cheque->save();
    
    return redirect()->route('cheques.index')->with('success', 'Statut mis à jour');
}

    public function sign(Request $request, $id)
{
    $cheque = Cheque::findOrFail($id);
    
    if (auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
    }
    
    // Vérifier que le chèque est en attente
    if ($cheque->status !== 'en_attente') {
        return response()->json(['success' => false, 'message' => 'Le chèque doit être en attente pour être signé'], 400);
    }
    
    $signatureData = $request->input('signature_data');
    
    if (!$signatureData) {
        return response()->json(['success' => false, 'message' => 'Signature requise'], 400);
    }
    
    $cheque->signature_data = $signatureData;
    $cheque->signed_by = auth()->user()->name;
    $cheque->signed_at = now();
    $cheque->is_signed = true;
    $cheque->status = 'valide';  // Passage automatique à validé
    $cheque->save();
    
    return response()->json(['success' => true, 'message' => 'Chèque signé et validé']);
}
   public function updateStatusWithSignature(Request $request)
{
    $cheque = Cheque::findOrFail($request->id);
    
    if (auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
    }
    
    $signatureData = $request->signature_data;
    
    if (!$signatureData) {
        return response()->json(['success' => false, 'message' => 'Signature requise'], 400);
    }
    
    $cheque->status = $request->status;
    $cheque->signature_data = $signatureData;
    $cheque->signed_by = auth()->user()->name;
    $cheque->signed_at = now();
    $cheque->is_signed = true;
    $cheque->save();
    
    return response()->json(['success' => true, 'message' => 'Statut mis à jour avec signature']);
}
}