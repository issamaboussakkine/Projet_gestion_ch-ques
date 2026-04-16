@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Tableau de bord</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Photo de profil au centre -->
                    <div class="text-center mb-4">
                        @if(Auth::user()->photo)
                            <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Photo" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #007bff;">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <span class="text-white" style="font-size: 40px;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="text-center">Bonjour {{ Auth::user()->name }} ! 👋</h4>
                    
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="alert alert-info text-center">
                                <h2>{{ $totalCheques }}</h2>
                                <p>Total chèques</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-success text-center">
                                <h2>{{ number_format($montantTotal, 2) }} DH</h2>
                                <p>Montant total</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-warning text-center">
                                <h2>{{ $enAttente }}</h2>
                                <p>En attente</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-success text-center">
                                <h2>{{ $valides }}</h2>
                                <p>Validés</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('cheques.index') }}" class="btn btn-primary">Voir les chèques</a>
                        <a href="{{ route('cheques.create') }}" class="btn btn-success">Ajouter un chèque</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection