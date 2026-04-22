@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Mon Profil</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Photo de profil -->
                    <div class="text-center mb-4">
                        @if(Auth::user()->photo)
                            <img src="{{ Storage::url(Auth::user()->photo) }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #007bff;">
                        @else
                            <div style="width: 120px; height: 120px; border-radius: 50%; background: #6c757d; display: inline-flex; align-items: center; justify-content: center;">
                                <span style="font-size: 50px; color: white;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Informations (lecture seule) -->
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nom complet</th>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Entreprise</th>
                            <td>{{ Auth::user()->entreprise ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Poste</th>
                            <td>{{ Auth::user()->poste ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{{ Auth::user()->telephone ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Adresse</th>
                            <td>{{ Auth::user()->adresse ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Site web</th>
                            <td>{{ Auth::user()->site_web ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Domaine d'activité</th>
                            <td>{{ Auth::user()->domaine_activite ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Bio</th>
                            <td>{{ Auth::user()->bio ?? 'Non renseigné' }}</td>
                        </tr>
                    </table>

                    <div class="text-center mt-3">
                        <a href="{{ route('parametres.profil') }}" class="btn btn-primary">
                            Modifier mon profil
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection