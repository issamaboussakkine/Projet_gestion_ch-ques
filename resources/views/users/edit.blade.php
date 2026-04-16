<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier un utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Nom complet</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Rôle --}}
                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 font-bold mb-2">Rôle</label>
                            <select name="role" id="role" class="w-full border border-gray-300 rounded px-3 py-2" required>
                                <option value="employe" {{ $user->role == 'employe' ? 'selected' : '' }}>Employé</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Boutons --}}
                        <div class="flex justify-between">
                            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Mettre à jour
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>