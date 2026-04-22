@extends('layouts.app')
@section('content')
<div class="py-8">
  <div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-xl overflow-hidden" style="border:0.5px solid #e5e7eb;">

      {{-- Header --}}
      <div class="px-6 py-4 flex justify-between items-center" style="background:#071952;">
        <h2 class="text-white text-lg font-medium">✏️ Modifier le chèque</h2>
        <a href="{{ route('cheques.index') }}"
           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-white"
           style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);">← Retour</a>
      </div>

      <div class="p-6">

        {{-- Erreurs --}}
        @if($errors->any())
        <div class="mb-5 p-4 rounded-lg flex gap-3" style="background:#fee2e2;border:0.5px solid #fca5a5;">
          <span style="color:#dc2626;font-size:16px;">⚠️</span>
          <ul class="text-sm list-none" style="color:#991b1b;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('cheques.update', $cheque->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 gap-4">

            {{-- Nom du client --}}
            <div>
              <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Nom du client</label>
              <input type="text" name="client_name"
                value="{{ old('client_name', $cheque->client_name) }}"
                class="w-full px-4 py-2.5 rounded-lg text-sm @error('client_name') border-red-400 @enderror"
                style="border:0.5px solid #d1d5db;outline:none;color:#111827;"
                required>
              @error('client_name')
                <p class="mt-1 text-xs" style="color:#dc2626;">{{ $message }}</p>
              @enderror
            </div>

            {{-- Montant --}}
            <div>
              <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Montant (DH)</label>
              <div class="relative">
                <input type="number" step="0.01" name="amount"
                  value="{{ old('amount', $cheque->amount) }}"
                  class="w-full px-4 py-2.5 rounded-lg text-sm pr-12 @error('amount') border-red-400 @enderror"
                  style="border:0.5px solid #d1d5db;outline:none;color:#111827;"
                  required>
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-medium" style="color:#0B666A;">DH</span>
              </div>
              @error('amount')
                <p class="mt-1 text-xs" style="color:#dc2626;">{{ $message }}</p>
              @enderror
            </div>

            {{-- Banque --}}
            <div>
              <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Banque</label>
              <input type="text" name="bank"
                value="{{ old('bank', $cheque->bank) }}"
                class="w-full px-4 py-2.5 rounded-lg text-sm @error('bank') border-red-400 @enderror"
                style="border:0.5px solid #d1d5db;outline:none;color:#111827;"
                required>
              @error('bank')
                <p class="mt-1 text-xs" style="color:#dc2626;">{{ $message }}</p>
              @enderror
            </div>

            {{-- Numéro de chèque --}}
            <div>
              <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Numéro de chèque</label>
              <input type="text" name="cheque_number"
                value="{{ old('cheque_number', $cheque->cheque_number) }}"
                class="w-full px-4 py-2.5 rounded-lg text-sm font-mono @error('cheque_number') border-red-400 @enderror"
                style="border:0.5px solid #d1d5db;outline:none;color:#111827;"
                required>
              @error('cheque_number')
                <p class="mt-1 text-xs" style="color:#dc2626;">{{ $message }}</p>
              @enderror
            </div>

            {{-- Date --}}
            <div>
              <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Date</label>
              <input type="date" name="date"
                value="{{ old('date', $cheque->date) }}"
                class="w-full px-4 py-2.5 rounded-lg text-sm @error('date') border-red-400 @enderror"
                style="border:0.5px solid #d1d5db;outline:none;color:#111827;"
                required>
              @error('date')
                <p class="mt-1 text-xs" style="color:#dc2626;">{{ $message }}</p>
              @enderror
            </div>

            {{-- Statut --}}
            <div>
              <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Statut</label>
              <select name="status"
                class="w-full px-4 py-2.5 rounded-lg text-sm @error('status') border-red-400 @enderror"
                style="border:0.5px solid #d1d5db;outline:none;color:#111827;background:#fff;">
                <option value="en_attente" {{ old('status', $cheque->status) == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                <option value="valide"     {{ old('status', $cheque->status) == 'valide'     ? 'selected' : '' }}>✅ Validé</option>
                <option value="refuse"     {{ old('status', $cheque->status) == 'refuse'     ? 'selected' : '' }}>❌ Refusé</option>
              </select>
              @error('status')
                <p class="mt-1 text-xs" style="color:#dc2626;">{{ $message }}</p>
              @enderror
            </div>

            {{-- Image --}}
            <div>
              <label class="block text-sm font-medium mb-1.5" style="color:#374151;">
                Image du chèque
                <span class="text-xs font-normal ml-1" style="color:#9ca3af;">(optionnel)</span>
              </label>
              @if($cheque->image)
              <div class="flex items-center gap-3 mb-2 p-3 rounded-lg" style="background:#f0fdf4;border:0.5px solid #bbf7d0;">
                <span style="color:#16a34a;font-size:16px;">🖼️</span>
                <span class="text-sm" style="color:#15803d;">Image actuelle :</span>
                <a href="{{ asset('storage/' . $cheque->image) }}" target="_blank"
                   class="text-sm font-medium underline" style="color:#0B666A;">Voir</a>
              </div>
              @endif
              <div class="w-full px-4 py-3 rounded-lg text-sm" style="border:0.5px dashed #d1d5db;background:#f9fafb;">
                <input type="file" name="image" accept="image/*"
                  class="w-full text-sm"
                  style="color:#6b7280;">
                <p class="mt-1 text-xs" style="color:#9ca3af;">Laisser vide pour conserver l'image actuelle</p>
              </div>
              @error('image')
                <p class="mt-1 text-xs" style="color:#dc2626;">{{ $message }}</p>
              @enderror
            </div>

          </div>

          {{-- Actions --}}
          <div class="flex justify-end gap-3 mt-6 pt-5" style="border-top:0.5px solid #e5e7eb;">
            <a href="{{ route('cheques.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium"
               style="background:#f3f4f6;color:#374151;border:0.5px solid #e5e7eb;">
              Annuler
            </a>
            <button type="submit"
               class="inline-flex items-center gap-2 px-6 py-2 rounded-lg text-sm font-medium text-white"
               style="background:#0B666A;">
              💾 Mettre à jour
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection