@extends('layouts.app')
@section('content')
<div class="py-8">
  <div class="max-w-7xl mx-auto px-4">

    {{-- Header page --}}
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-medium" style="color:#071952;">📄 Liste des chèques</h1>
        <p class="text-sm mt-0.5" style="color:#6b7280;">Gérez et suivez tous vos chèques</p>
      </div>
      <a href="{{ route('cheques.create') }}"
         class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium text-white"
         style="background:#0B666A;">
        ➕ Ajouter un chèque
      </a>
    </div>

    {{-- Message succès --}}
    @if(session('success'))
    <div class="mb-5 p-4 rounded-lg flex items-center gap-3" style="background:#d1fae5;border:0.5px solid #6ee7b7;">
      <span style="color:#059669;font-size:16px;">✅</span>
      <span class="text-sm" style="color:#065f46;">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Filtres --}}
    <div class="bg-white rounded-xl mb-5 overflow-hidden" style="border:0.5px solid #e5e7eb;">
      <div class="px-5 py-3 flex items-center gap-2" style="background:#0B666A;">
        <span class="text-white text-sm font-medium"> Filtrer les chèques</span>
      </div>
      <div class="p-5">
        <form method="GET" action="{{ route('cheques.index') }}">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>
              <label class="block text-xs font-medium mb-1.5" style="color:#6b7280;">Recherche</label>
              <input type="text" name="search"
                placeholder="Client ou numéro..."
                value="{{ request('search') }}"
                class="w-full px-3 py-2 rounded-lg text-sm"
                style="border:0.5px solid #d1d5db;outline:none;color:#111827;">
            </div>

            <div>
              <label class="block text-xs font-medium mb-1.5" style="color:#6b7280;">Statut</label>
              <select name="status" class="w-full px-3 py-2 rounded-lg text-sm" style="border:0.5px solid #d1d5db;outline:none;color:#111827;background:#fff;">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                <option value="valide"     {{ request('status') == 'valide'     ? 'selected' : '' }}>✅ Validé</option>
                <option value="refuse"     {{ request('status') == 'refuse'     ? 'selected' : '' }}>❌ Refusé</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-medium mb-1.5" style="color:#6b7280;">Banque</label>
              <input type="text" name="bank"
                placeholder="Nom de la banque..."
                value="{{ request('bank') }}"
                class="w-full px-3 py-2 rounded-lg text-sm"
                style="border:0.5px solid #d1d5db;outline:none;color:#111827;">
            </div>

            <div class="flex items-end gap-2">
            <button type="submit" form="filterForm"
    class="px-4 py-0.5 rounded text-sm font-medium text-white"
    style="background:#071952;">
    Appliquer
</button>
              <a href="{{ route('cheques.index') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium"
                style="background:#f3f4f6;color:#374151;border:0.5px solid #e5e7eb;">
                ✕
              </a>
            </div>

          </div>
        </form>
      </div>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-xl overflow-hidden" style="border:0.5px solid #e5e7eb;">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr style="background:#071952;">
              <th class="px-5 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">N° chèque</th>
              <th class="px-5 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Client</th>
              <th class="px-5 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Montant</th>
              <th class="px-5 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Banque</th>
              <th class="px-5 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date</th>
              <th class="px-5 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Statut</th>
              <th class="px-5 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($cheques as $cheque)
            <tr style="border-bottom:0.5px solid #e5e7eb;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">

              <td class="px-5 py-3.5 text-sm font-mono" style="color:#374151;">
                {{ $cheque->cheque_number }}
              </td>

              <td class="px-5 py-3.5">
    <span class="text-sm font-medium" style="color:#111827;">{{ $cheque->client_name }}</span>
</td>

              <td class="px-5 py-3.5 text-sm font-medium" style="color:#0B666A;">
                {{ number_format($cheque->amount, 2) }} DH
              </td>

              <td class="px-5 py-3.5 text-sm" style="color:#374151;">{{ $cheque->bank }}</td>

              <td class="px-5 py-3.5 text-sm" style="color:#374151;">{{ $cheque->date->format('d/m/Y') }}</td>

              <td class="px-5 py-3.5">
                @if($cheque->status == 'valide')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" style="background:#d1fae5;color:#065f46;">
                    <span class="w-1.5 h-1.5 rounded-full inline-block" style="background:#10b981;"></span> Validé
                  </span>
                @elseif($cheque->status == 'refuse')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" style="background:#fee2e2;color:#991b1b;">
                    <span class="w-1.5 h-1.5 rounded-full inline-block" style="background:#ef4444;"></span> Refusé
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" style="background:#fef3c7;color:#92400e;">
                    <span class="w-1.5 h-1.5 rounded-full inline-block" style="background:#f59e0b;"></span> En attente
                  </span>
                @endif
              </td>

              <td class="px-5 py-3.5">
                <div class="flex items-center gap-1.5">
                  <a href="{{ route('cheques.show', $cheque->id) }}"
                     class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-medium"
                     style="background:#e0f2fe;color:#0369a1;"> Voir details  </a>
                  <a href="{{ route('cheques.edit', $cheque->id) }}"
                     class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-medium"
                     style="background:#fef3c7;color:#92400e;">✏️ Modifier</a>
                  <form action="{{ route('cheques.destroy', $cheque->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      onclick="return confirm('Supprimer ce chèque ?')"
                      class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-medium"
                      style="background:#fee2e2;color:#991b1b;">🗑️</button>
                  </form>
                </div>
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="7" class="px-5 py-12 text-center">
                <div class="flex flex-col items-center gap-2">
                  <span style="font-size:32px;">📭</span>
                  <p class="text-sm font-medium" style="color:#374151;">Aucun chèque enregistré</p>
                  <p class="text-xs" style="color:#9ca3af;">Commencez par ajouter votre premier chèque</p>
                  <a href="{{ route('cheques.create') }}"
                     class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium text-white"
                     style="background:#0B666A;">➕ Ajouter un chèque</a>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      @if($cheques->hasPages())
      <div class="px-5 py-4" style="border-top:0.5px solid #e5e7eb;">
        {{ $cheques->links() }}
      </div>
      @endif

    </div>
  </div>
</div>
@endsection