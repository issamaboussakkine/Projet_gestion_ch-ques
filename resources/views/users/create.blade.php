<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Nom complet</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Rôle --}}
                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-bold mb-2">Rôle</label>
                            <select name="role" id="role" class="w-full border border-gray-300 rounded px-3 py-2" required>
                                <option value="employe">Employé</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Mot de passe --}}
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-bold mb-2">Mot de passe</label>
                            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Confirmation mot de passe --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex justify-between">
                            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer l'utilisateur
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>