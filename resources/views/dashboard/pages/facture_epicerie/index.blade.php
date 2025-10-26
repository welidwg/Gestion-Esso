@extends('dashboard/base')

@section('title', 'Liste des Factures Epicerie')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-primary">
                        <i class="fas fa-file-invoice me-2"></i>Factures Epicerie
                    </h4>
                    <div class="btn-group">
                        <a href="{{ route('articlefacture.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-cube me-2"></i>Nouvel Article
                        </a>
                        <a href="{{ route('factureepicerie.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nouvelle Facture
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div class="flex-grow-1">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                @if ($factures->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold text-dark">
                                        <i class="fas fa-hashtag me-2"></i>ID
                                    </th>
                                    <th class="fw-semibold text-dark">
                                        <i class="fas fa-truck me-2"></i>Fournisseur
                                    </th>
                                    <th class="fw-semibold text-dark">
                                        <i class="fas fa-calendar me-2"></i>Date
                                    </th>
                                    <th class="fw-semibold text-dark text-center">
                                        <i class="fas fa-cubes me-2"></i>Articles
                                    </th>
                                    <th class="fw-semibold text-dark text-center">
                                        <i class="fas fa-cogs me-2"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)
                                    <tr class="border-bottom">
                                        <td class="fw-medium text-muted">#{{ $facture->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-building text-muted me-2"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium">{{ $facture->nom_de_fournisseur }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $facture->date->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary fs-6">
                                                {{ count($facture->articles) }}
                                                <i class="fas fa-cube ms-1"></i>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('factureepicerie.show', $facture->id) }}"
                                                    class="btn btn-outline-primary rounded-start-2" title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('factureepicerie.edit', $facture->id) }}"
                                                    class="btn btn-outline-warning" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('factureepicerie.destroy', $facture->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Confirmer la suppression de cette facture ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger rounded-end-2" type="submit"
                                                        title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Affichage de <strong>{{ $factures->firstItem() }}</strong> à
                            <strong>{{ $factures->lastItem() }}</strong> sur
                            <strong>{{ $factures->total() }}</strong> factures
                        </div>
                        <div>
                            {{ $factures->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune facture enregistrée</h5>
                        <p class="text-muted mb-4">Commencez par créer votre première facture.</p>
                        <a href="{{ route('factureepicerie.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Créer une facture
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .bg-opacity-10 {
            background-opacity: 0.1;
        }
    </style>
@endsection
