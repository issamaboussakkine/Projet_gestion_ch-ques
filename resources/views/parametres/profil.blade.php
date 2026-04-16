@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>⚙️ Paramètres du profil</h3>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Photo de profil -->
                    <div class="text-center mb-4">
                        <h4>Photo de profil</h4>
                        @if(Auth::user()->photo)
                            <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Photo" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #007bff; margin-bottom: 10px;">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <span class="text-white" style="font-size: 50px;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('parametres.profil.update') }}" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            @method('PUT')
                            <input type="file" name="photo" id="photo" class="form-control" style="display: inline-block; width: auto;">
                            <button type="submit" class="btn btn-sm btn-primary">Changer la photo</button>
                        </form>
                    </div>

                    <hr>

                    <h4>📝 Modifier mes informations</h4>
                    <form method="POST" action="{{ route('parametres.profil.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="entreprise" class="form-label">Entreprise</label>
                            <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', auth()->user()->entreprise) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="poste" class="form-label">Poste</label>
                            <input type="text" name="poste" id="poste" value="{{ old('poste', auth()->user()->poste) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', auth()->user()->telephone) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea name="adresse" id="adresse" rows="2" class="form-control">{{ old('adresse', auth()->user()->adresse) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>

                    <hr class="my-4">

                    <h4>🔒 Changer mon mot de passe</h4>
                    <form method="POST" action="{{ route('parametres.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection