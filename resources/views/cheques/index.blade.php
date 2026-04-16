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

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>N°</th>
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
                                    <span class="badge bg-{{ $cheque->status == 'valide' ? 'success' : ($cheque->status == 'refuse' ? 'danger' : 'warning') }}">
                                        {{ $cheque->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('cheques.show', $cheque->id) }}" class="btn btn-sm btn-info">Voir</a>
                                    <a href="{{ route('cheques.edit', $cheque->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                    <form action="{{ route('cheques.destroy', $cheque->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce chèque ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun chèque enregistré</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $cheques->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection