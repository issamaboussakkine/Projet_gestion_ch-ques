@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">🔍 Détail du chèque</h2>
                    <div>
                        <a href="{{ route('cheques.edit', $cheque->id) }}" class="btn btn-warning">✏️ Modifier</a>
                        <a href="{{ route('cheques.index') }}" class="btn btn-secondary">Retour</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Client</th>
                            <td>{{ $cheque->client_name }}</td>
                        </tr>
                        <tr>
                            <th>Montant</th>
                            <td>{{ number_format($cheque->amount, 2) }} DH</td>
                        </tr>
                        <tr>
                            <th>Banque</th>
                            <td>{{ $cheque->bank }}</td>
                        </tr>
                        <tr>
                            <th>Numéro de chèque</th>
                            <td>{{ $cheque->cheque_number }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $cheque->date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                <span class="badge bg-{{ $cheque->status == 'valide' ? 'success' : ($cheque->status == 'refuse' ? 'danger' : 'warning') }}">
                                    {{ $cheque->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Ajouté par</th>
                            <td>{{ $cheque->user->name }}</td>
                        </tr>
                        @if($cheque->image)
                        <tr>
                            <th>Image</th>
                            <td>
                                <a href="{{ asset('storage/' . $cheque->image) }}" target="_blank" class="btn btn-sm btn-info">Voir l'image</a>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection