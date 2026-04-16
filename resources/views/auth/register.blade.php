<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Colonne gauche -->
            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nom complet')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Colonne droite -->
            <div class="space-y-4">
                <!-- Photo avec aperçu -->
                <div>
                    <x-input-label for="photo" :value="__('Photo de profil')" />
                    <div class="mt-1 flex flex-col items-center space-y-3">
                        <!-- Aperçu de la photo -->
                        <div id="photo-preview" class="w-32 h-32 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="photo" type="file" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*" onchange="previewImage(event)">
                        <p class="text-xs text-gray-500">Format : JPG, PNG (max 2MB)</p>
                    </div>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>

                <!-- Entreprise -->
                <div>
                    <x-input-label for="entreprise" :value="__('Entreprise')" />
                    <x-text-input id="entreprise" class="block mt-1 w-full" type="text" name="entreprise" :value="old('entreprise')" />
                    <x-input-error :messages="$errors->get('entreprise')" class="mt-2" />
                </div>

                <!-- Poste -->
                <div>
                    <x-input-label for="poste" :value="__('Poste')" />
                    <x-text-input id="poste" class="block mt-1 w-full" type="text" name="poste" :value="old('poste')" />
                    <x-input-error :messages="$errors->get('poste')" class="mt-2" />
                </div>

                <!-- Téléphone -->
                <div>
                    <x-input-label for="telephone" :value="__('Téléphone')" />
                    <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone" :value="old('telephone')" />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                </div>

                <!-- Adresse -->
                <div>
                    <x-input-label for="adresse" :value="__('Adresse')" />
                    <textarea id="adresse" name="adresse" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('adresse') }}</textarea>
                    <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex items-center justify-between mt-6 pt-4 border-t">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Déjà inscrit ? Se connecter') }}
            </a>

            <x-primary-button>
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('photo-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '<svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>';
            }
        }
    </script>
</x-guest-layout>