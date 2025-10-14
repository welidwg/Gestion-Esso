@extends('dashboard/base')

@section('title', 'Liste des Factures Epicerie')

@section('content')
    <div class="container py-4">
        <h2>Liste des Factures Epicerie</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('factureepicerie.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Ajouter une nouvelle facture
        </a>
        <a href="{{ route('articlefacture.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Ajouter un article
        </a>

        @if ($factures->count())
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Nom de fournisseur</th>
                        <th>Date</th>
                        <th>Nombre d'articles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($factures as $facture)
                        <tr>
                            <td>{{ $facture->id }}</td>
                            <td>{{ $facture->nom_de_fournisseur }}</td>
                            <td>{{ $facture->date->format('d/m/Y') }}</td>
                            <td>{{ count($facture->articles) }}</td>
                            <td>
                                <a href="{{ route('factureepicerie.show', $facture->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <form action="{{ route('factureepicerie.destroy', $facture->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Confirmer la suppression?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $factures->links() }}
        @else
            <p>Aucune facture enregistrée pour le moment.</p>
        @endif
    </div>
@endsection
