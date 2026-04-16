@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">📄 Liste des chèques</h2>
                    <a href="{{ route('cheques.create') }}" class="btn btn-primary">➕ Ajouter un chèque</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Formulaire de filtres -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('cheques.index') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">🔍 Recherche</label>
                                    <input type="text" name="search" class="form-control" placeholder="Client ou numéro..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">📊 Statut</label>
                                    <select name="status" class="form-select">
                                        <option value="">Tous</option>
                                        <option value="en_attente" {{ request('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="valide" {{ request('status') == 'valide' ? 'selected' : '' }}>Validé</option>
                                        <option value="refuse" {{ request('status') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">🏦 Banque</label>
                                    <input type="text" name="bank" class="form-control" placeholder="Banque..." value="{{ request('bank') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
                                        <a href="{{ route('cheques.index') }}" class="btn btn-secondary">🗑️ Réinitialiser</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tableau des chèques -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N° chèque</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Banque</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cheques as $cheque)
                                <tr>
                                    <td>{{ $cheque->cheque_number }}</td>
                                    <td>{{ $cheque->client_name }}</td>
                                    <td>{{ number_format($cheque->amount, 2) }} DH</td>
                                    <td>{{ $cheque->bank }}</td>
                                    <td>{{ $cheque->date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($cheque->status == 'valide')
                                            <span class="badge bg-success">✅ Validé</span>
                                        @elseif($cheque->status == 'refuse')
                                            <span class="badge bg-danger">❌ Refusé</span>
                                        @else
                                            <span class="badge bg-warning">⏳ En attente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('cheques.show', $cheque->id) }}" class="btn btn-sm btn-info">👁️ Voir</a>
                                            <a href="{{ route('cheques.edit', $cheque->id) }}" class="btn btn-sm btn-warning">✏️ Modifier</a>
                                            <form action="{{ route('cheques.destroy', $cheque->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce chèque ?')">🗑️ Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun chèque enregistré</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $cheques->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection