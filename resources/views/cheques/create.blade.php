@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Créer un nouveau chèque</h1>

        {{-- Section OCR --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Scanner un chèque avec OCR
            </h2>

            <div class="mb-4">
                <label for="chequeImage" class="block text-sm font-medium text-gray-700 mb-2">
                    Image du chèque
                </label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <input 
                        type="file" 
                        id="chequeImage" 
                        accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                    >
                    <button 
                        type="button" 
                        id="scanButton"
                        disabled
                        style="background-color: #9ca3af; color: white; padding: 10px 24px; border-radius: 8px; border: none; font-weight: bold; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span id="scanButtonText">Sélectionnez une image</span>
                    </button>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Formats acceptés : JPEG, PNG, BMP, GIF, WEBP (Max 5 MB)
                </p>
            </div>

            <div id="imagePreview" class="mb-4 hidden">
                <img src="" alt="Preview" class="max-w-full h-auto rounded border max-h-64 mx-auto">
            </div>

            <div id="scanLoader" class="hidden mb-4 text-center py-4">
                <svg class="animate-spin h-8 w-8 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-gray-600">Analyse en cours...</p>
            </div>

            <div id="ocrResults" class="hidden">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <h3 class="text-lg font-semibold mb-3 text-green-700">✓ Données extraites</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div><label class="block text-sm font-medium text-gray-600">Montant</label><p id="ocr_amount" class="text-lg font-bold text-gray-900">-</p></div>
                        <div><label class="block text-sm font-medium text-gray-600">Date</label><p id="ocr_date" class="text-lg font-bold text-gray-900">-</p></div>
                        <div><label class="block text-sm font-medium text-gray-600">Numéro de chèque</label><p id="ocr_cheque_number" class="text-lg font-bold text-gray-900">-</p></div>
                        <div><label class="block text-sm font-medium text-gray-600">Nom du client</label><p id="ocr_client_name" class="text-lg font-bold text-gray-900">-</p></div>
                        <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-600">Nom de la banque</label><p id="ocr_bank_name" class="text-lg font-bold text-gray-900">-</p></div>
                    </div>

                    <details class="mb-4">
                        <summary class="cursor-pointer text-sm font-medium text-gray-600">Voir le texte complet</summary>
                        <pre id="ocr_full_text" class="mt-2 p-3 bg-white border rounded text-xs overflow-x-auto">-</pre>
                    </details>
                </div>
            </div>

            <div id="ocrError" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                <strong>Erreur!</strong> <span id="ocrErrorMessage"></span>
            </div>
        </div>

        {{-- Formulaire principal --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-6">Informations du chèque</h2>
            
            <form action="{{ route('cheques.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de chèque *</label>
                        <input type="text" id="cheque_number" name="cheque_number" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant (DH) *</label>
                        <input type="number" step="0.01" id="amount" name="amount" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                        <input type="date" id="date" name="date" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du client *</label>
                        <input type="text" id="client_name" name="client_name" class="w-full px-3 py-2 border rounded-md" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banque</label>
                        <input type="text" id="bank_name" name="bank" class="w-full px-3 py-2 border rounded-md">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('cheques.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Annuler</a>
                    <button type="submit" style="background-color: #0B666A; color: white; padding: 10px 24px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer;">
                        💾 Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('chequeImage');
    const scanButton = document.getElementById('scanButton');
    const scanButtonText = document.getElementById('scanButtonText');
    const imagePreview = document.getElementById('imagePreview');
    const scanLoader = document.getElementById('scanLoader');
    const ocrResults = document.getElementById('ocrResults');
    const ocrError = document.getElementById('ocrError');
    
    let extractedData = {};

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        document.getElementById('cheque_number').value = '';
        document.getElementById('amount').value = '';
        document.getElementById('date').value = '';
        document.getElementById('client_name').value = '';
        document.getElementById('bank_name').value = '';
        
        ocrResults.classList.add('hidden');
        ocrError.classList.add('hidden');
        extractedData = {};
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
            scanButton.disabled = false;
            scanButton.style.backgroundColor = '#22c55e';
            scanButtonText.textContent = 'Scanner avec OCR';
        } else {
            imagePreview.classList.add('hidden');
            scanButton.disabled = true;
            scanButton.style.backgroundColor = '#9ca3af';
            scanButtonText.textContent = 'Sélectionnez une image';
        }
    });

    scanButton.addEventListener('click', async function() {
        const file = imageInput.files[0];
        if (!file) {
            alert('Veuillez sélectionner une image');
            return;
        }

        extractedData = {};
        ocrResults.classList.add('hidden');
        ocrError.classList.add('hidden');
        
        const formData = new FormData();
        formData.append('image', file);

        scanLoader.classList.remove('hidden');
        scanButton.disabled = true;
        scanButtonText.textContent = 'Scan en cours...';

        try {
            const response = await fetch('{{ route("ocr.scan") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            const data = await response.json();

            if (data.success) {
                extractedData = data.data;
                
                document.getElementById('ocr_amount').textContent = data.data.amount ? data.data.amount + ' DH' : '-';
                document.getElementById('ocr_date').textContent = data.data.date || '-';
                document.getElementById('ocr_cheque_number').textContent = data.data.cheque_number || '-';
                document.getElementById('ocr_client_name').textContent = data.data.client_name || '-';
                document.getElementById('ocr_bank_name').textContent = data.data.bank_name || '-';
                document.getElementById('ocr_full_text').textContent = data.data.full_text || '-';
                ocrResults.classList.remove('hidden');
                
                if (data.data.cheque_number) document.getElementById('cheque_number').value = data.data.cheque_number;
                if (data.data.amount) document.getElementById('amount').value = data.data.amount;
                if (data.data.date) document.getElementById('date').value = data.data.date;
                if (data.data.client_name) document.getElementById('client_name').value = data.data.client_name;
                if (data.data.bank_name) document.getElementById('bank_name').value = data.data.bank_name;
                
                const notification = document.createElement('div');
                notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #22c55e; color: white; padding: 12px 20px; border-radius: 8px; z-index: 9999; font-weight: bold;';
                notification.textContent = '✓ Scan terminé - Champs remplis';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 2000);
                
            } else {
                document.getElementById('ocrErrorMessage').textContent = data.message || 'Erreur';
                ocrError.classList.remove('hidden');
            }
        } catch (error) {
            document.getElementById('ocrErrorMessage').textContent = 'Erreur de connexion';
            ocrError.classList.remove('hidden');
        } finally {
            scanLoader.classList.add('hidden');
            scanButton.disabled = false;
            scanButton.style.backgroundColor = '#22c55e';
            scanButtonText.textContent = 'Scanner avec OCR';
        }
    });
});
</script>

<style>
.animate-spin {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection