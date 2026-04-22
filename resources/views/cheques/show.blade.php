@extends('layouts.app')

@section('content')
<div class="py-8">
  <div class="max-w-3xl mx-auto px-4">

    <div class="bg-white rounded-xl overflow-hidden" style="border:0.5px solid #e5e7eb;">
      <div class="px-5 py-3" style="background:#0B666A;">
        <h2 class="text-white text-lg font-medium">Detail du cheque</h2>
      </div>

      <div class="p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-medium text-gray-500">Numero de cheque</label>
            <p class="text-lg font-semibold" style="color:#071952;">{{ $cheque->cheque_number }}</p>
          </div>
          <div>
            <label class="block text-xs font-medium text-gray-500">Client</label>
            <p class="text-lg font-semibold">{{ $cheque->client_name }}</p>
          </div>
          <div>
            <label class="block text-xs font-medium text-gray-500">Montant</label>
            <p class="text-lg font-semibold" style="color:#0B666A;">{{ number_format($cheque->amount, 2) }} DH</p>
          </div>
          <div>
            <label class="block text-xs font-medium text-gray-500">Banque</label>
            <p class="text-lg font-semibold">{{ $cheque->bank }}</p>
          </div>
          <div>
            <label class="block text-xs font-medium text-gray-500">Date</label>
            <p class="text-lg font-semibold">{{ $cheque->date->format('d/m/Y') }}</p>
          </div>
          <div>
            <label class="block text-xs font-medium text-gray-500">Statut</label>
            @if($cheque->status == 'valide')
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium" style="background:#d1fae5;color:#065f46;">Valide</span>
            @elseif($cheque->status == 'refuse')
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium" style="background:#fee2e2;color:#991b1b;">Refuse</span>
            @else
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium" style="background:#fef3c7;color:#92400e;">En attente</span>
            @endif
          </div>
        </div>

        @if($cheque->image)
        <div class="mt-4">
          <label class="block text-xs font-medium text-gray-500 mb-2">Image du cheque</label>
          <img src="{{ Storage::url($cheque->image) }}" class="w-48 h-48 object-cover rounded shadow">
        </div>
        @endif

        {{-- SIGNATURE MANUSCRITE (uniquement si statut = en_attente) --}}
        @if(auth()->user()->role === 'admin' && $cheque->status === 'en_attente')
        <div class="mt-6 p-4 border rounded" style="background:#f9fafb;">
            <h4 class="font-semibold mb-3">Signature electronique</h4>
            <canvas id="signatureCanvas" width="500" height="200" style="border:1px solid #ccc; background:white; cursor:crosshair; border-radius:8px;"></canvas>
            <div class="mt-3 flex gap-2">
                <button type="button" id="clearSignature" class="px-4 py-2 rounded text-sm font-medium text-white" style="background:#6c757d;">Effacer</button>
                <button type="button" id="saveSignature" class="px-4 py-2 rounded text-sm font-medium text-white" style="background:#0B666A;">Signer le cheque</button>
            </div>
        </div>
        @endif

        {{-- AFFICHAGE DE LA SIGNATURE EXISTANTE (si deja signe) --}}
        @if($cheque->is_signed && $cheque->signature_data)
        <div class="mt-6 p-4 rounded" style="background:#d1fae5; border:1px solid #a7f3d0;">
            <p class="font-semibold mb-2">Signature apposee</p>
            <p class="text-sm"><strong>Signe par :</strong> {{ $cheque->signed_by }}</p>
            <p class="text-sm"><strong>Date :</strong> {{ $cheque->signed_at ? \Carbon\Carbon::parse($cheque->signed_at)->format('d/m/Y H:i') : '-' }}</p>
            <div class="mt-2">
                <img src="{{ $cheque->signature_data }}" alt="Signature" style="border:1px solid #ccc; max-width:200px; background:white;">
            </div>
        </div>
        @endif

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('cheques.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium" style="background:#f3f4f6;color:#374151;">Retour</a>
            @if(auth()->user()->role === 'admin' && $cheque->status != 'valide')
                <a href="{{ route('cheques.edit', $cheque->id) }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white" style="background:#0B666A;">Modifier</a>
            @endif
        </div>

      </div>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signatureCanvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    let drawing = false;
    
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    
    function startDrawing(e) {
        drawing = true;
        const pos = getPosition(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }
    
    function draw(e) {
        if (!drawing) return;
        e.preventDefault();
        const pos = getPosition(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }
    
    function stopDrawing() {
        drawing = false;
        ctx.beginPath();
    }
    
    function getPosition(e) {
        const rect = canvas.getBoundingClientRect();
        let clientX, clientY;
        if (e.touches) {
            clientX = e.touches[0].clientX;
            clientY = e.touches[0].clientY;
        } else {
            clientX = e.clientX;
            clientY = e.clientY;
        }
        return {
            x: clientX - rect.left,
            y: clientY - rect.top
        };
    }
    
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseleave', stopDrawing);
    canvas.addEventListener('touchstart', startDrawing);
    canvas.addEventListener('touchmove', draw);
    canvas.addEventListener('touchend', stopDrawing);
    
    document.getElementById('clearSignature')?.addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.beginPath();
    });
    
    document.getElementById('saveSignature')?.addEventListener('click', function() {
        const signatureData = canvas.toDataURL();
        
        fetch('{{ route("cheques.sign", $cheque->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ signature_data: signatureData })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de l\'enregistrement');
        });
    });
});
</script>
@endsection