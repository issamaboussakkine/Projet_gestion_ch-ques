@extends('layouts.app')
@section('content')
<div class="py-8">
  <div class="max-w-7xl mx-auto px-4">

    {{-- Titre --}}
    <div class="mb-8">
      <h1 class="text-2xl font-medium" style="color:#071952;">Tableau de bord</h1>
      <p class="text-sm mt-1" style="color:#6b7280;">Bienvenue, {{ Auth::user()->name }} 👋</p>
    </div>

    {{-- Cartes statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

      {{-- Total chèques --}}
      <div class="bg-white rounded-xl overflow-hidden" style="border:0.5px solid #e5e7eb;">
        <div class="px-4 py-2.5" style="background:#071952;">
          <p class="text-white text-xs font-medium uppercase tracking-wider">Total chèques</p>
        </div>
        <div class="px-4 py-5 flex items-end justify-between">
          <div>
            <p class="text-3xl font-medium" style="color:#071952;">{{ $totalCheques }}</p>
            <p class="text-xs mt-1" style="color:#9ca3af;">chèques enregistrés</p>
          </div>
          <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#e8eaf6;">
            <span style="font-size:18px;">📄</span>
          </div>
        </div>
      </div>

      {{-- Montant total --}}
      <div class="bg-white rounded-xl overflow-hidden" style="border:0.5px solid #e5e7eb;">
        <div class="px-4 py-2.5" style="background:#0B666A;">
          <p class="text-white text-xs font-medium uppercase tracking-wider">Montant total</p>
        </div>
        <div class="px-4 py-5 flex items-end justify-between">
          <div>
            <p class="text-3xl font-medium" style="color:#0B666A;">{{ number_format($montantTotal, 2) }}</p>
            <p class="text-xs mt-1" style="color:#9ca3af;">dirhams</p>
          </div>
          <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#e0f2f1;">
            <span style="font-size:18px;">💰</span>
          </div>
        </div>
      </div>

      {{-- En attente --}}
      <div class="bg-white rounded-xl overflow-hidden" style="border:0.5px solid #e5e7eb;">
        <div class="px-4 py-2.5" style="background:#d97706;">
          <p class="text-white text-xs font-medium uppercase tracking-wider">En attente</p>
        </div>
        <div class="px-4 py-5 flex items-end justify-between">
          <div>
            <p class="text-3xl font-medium" style="color:#d97706;">{{ $enAttente }}</p>
            <p class="text-xs mt-1" style="color:#9ca3af;">à traiter</p>
          </div>
          <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#fef3c7;">
            <span style="font-size:18px;">⏳</span>
          </div>
        </div>
      </div>

      {{-- Validés --}}
      <div class="bg-white rounded-xl overflow-hidden" style="border:0.5px solid #e5e7eb;">
        <div class="px-4 py-2.5" style="background:#16a34a;">
          <p class="text-white text-xs font-medium uppercase tracking-wider">Validés</p>
        </div>
        <div class="px-4 py-5 flex items-end justify-between">
          <div>
            <p class="text-3xl font-medium" style="color:#16a34a;">{{ $valides }}</p>
            <p class="text-xs mt-1" style="color:#9ca3af;">confirmés</p>
          </div>
          <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#d1fae5;">
            <span style="font-size:18px;">✅</span>
          </div>
        </div>
      </div>

    </div>

    {{-- Boutons d'action --}}
    <div class="flex justify-center gap-4">
      <a href="{{ route('cheques.index') }}"
         class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium text-white"
         style="background:#071952;">
        📄 Voir les chèques
      </a>
      <a href="{{ route('cheques.create') }}"
         class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium text-white"
         style="background:#0B666A;">
        ➕ Ajouter un chèque
      </a>
    </div>

  </div>
</div>
@endsection