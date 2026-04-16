@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>📊 Statistiques</h3>
                </div>
                <div class="card-body">
                    
                    @php
                        $testTotalCheques = \App\Models\Cheque::count();
                        $testTotalUsers = \App\Models\User::count();
                    @endphp

                    <div class="alert alert-info">
                        <p><strong>Utilisateur :</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Total chèques :</strong> {{ $testTotalCheques }}</p>
                        <p><strong>Total utilisateurs :</strong> {{ $testTotalUsers }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="alert alert-primary text-center">
                                <h2>{{ $totalCheques ?? 0 }}</h2>
                                <p>Total chèques</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-warning text-center">
                                <h2>{{ $chequesEnAttente ?? 0 }}</h2>
                                <p>En attente</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-success text-center">
                                <h2>{{ $chequesValides ?? 0 }}</h2>
                                <p>Validés</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-danger text-center">
                                <h2>{{ $chequesRefuses ?? 0 }}</h2>
                                <p>Refusés</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">🏦 Chèques par banque</div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr><th>Banque</th><th>Nombre</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse($banques ?? [] as $banque)
                                            <tr><td>{{ $banque->bank }}</td><td>{{ $banque->total }}</td></tr>
                                            @empty
                                            <tr><td colspan="2">Aucun chèque enregistré</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">👥 Utilisateurs</div>
                                <div class="card-body">
                                    <p><strong>Total :</strong> {{ $totalUsers ?? 0 }}</p>
                                    <p><strong>Administrateurs :</strong> {{ $totalAdmins ?? 0 }}</p>
                                    <p><strong>Employés :</strong> {{ $totalEmployes ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection