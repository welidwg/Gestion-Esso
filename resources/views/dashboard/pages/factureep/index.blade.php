@extends('dashboard/base')
@section('title')
    Liste des Factures Epicerie
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-center align-items-center">

                            <h4 class="mb-0">
                                Liste des Factures Epicerie
                            </h4>

                        </div>

                        <div class="d-flex align-items-center">
                            <span class="badge bg-light text-primary fs-6 me-3">{{ $factures->count() }} facture(s)</span>
                            <a href="{{ route('factureep.create') }}" class="btn btn-light">
                                <i class="fas fa-plus-circle me-1"></i>Nouvelle facture
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters and Search -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                                </div>
                            </div>
                            {{-- <div class="col-md-6 text-md-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-filter me-1"></i>Filtrer
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" data-filter="all">Toutes</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="recent">30 derniers
                                                jours</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="high-amount">Montant
                                                élevé</a></li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Responsive Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle" id="facturesTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="sortable" data-sort="nom_de_fournisseur">
                                            Fournisseur
                                        </th>
                                        <th scope="col" class="sortable" data-sort="date">
                                            Date
                                        </th>
                                        <th scope="col" class="sortable" data-sort="designation">
                                            Désignation
                                        </th>
                                        <th scope="col" class="sortable text-end" data-sort="prix_unite">
                                            Prix Unité
                                        </th>
                                        <th scope="col" class="sortable text-end" data-sort="qte">
                                            Quantité
                                        </th>
                                        <th scope="col" class="sortable text-end" data-sort="prix_ht">
                                            Prix HT
                                        </th>
                                        <th scope="col" class="sortable text-end" data-sort="tva">
                                            TVA %
                                        </th>
                                        <th scope="col" class="sortable text-end" data-sort="prix_ttc">
                                            Prix TTC
                                        </th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($factures as $facture)
                                        <tr class="facture-row">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        {{ substr($facture->nom_de_fournisseur, 0, 1) }}
                                                    </div>
                                                    <span class="fw-medium">{{ $facture->nom_de_fournisseur }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-truncate" style="max-width: 200px;"
                                                    title="{{ $facture->designation }}">
                                                    {{ $facture->designation }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold text-primary">
                                                {{ number_format($facture->prix_unite, 2, ',', ' ') }} €
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-info text-dark">{{ $facture->qte }}</span>
                                            </td>
                                            <td class="text-end fw-bold">
                                                {{ number_format($facture->prix_ht, 2, ',', ' ') }} €
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-warning text-dark">{{ $facture->tva }}%</span>
                                            </td>
                                            <td class="text-end fw-bold text-success">
                                                {{ number_format($facture->prix_ttc, 2, ',', ' ') }} €
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('factureep.show', $facture->id) }}"
                                                        class="btn btn-outline-primary" title="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <button class="btn btn-outline-danger" title="Supprimer"
                                                        onclick="confirmDelete({{ $facture->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Aucune facture trouvée</h5>
                                                    <p class="text-muted">Commencez par ajouter votre première facture.</p>
                                                    <a href="{{ route('factureep.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Ajouter une facture
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($factures->count() > 0)
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="5" class="text-end">Totaux:</th>
                                            <th class="text-end fw-bold text-primary">
                                                {{ number_format($factures->sum('prix_ht'), 2, ',', ' ') }} €
                                            </th>
                                            <th></th>
                                            <th class="text-end fw-bold text-success">
                                                {{ number_format($factures->sum('prix_ttc'), 2, ',', ' ') }} €
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                @endif

                            </table>
                            @if ($factures->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="text-muted">
                                        Affichage de <strong>{{ $factures->firstItem() ?? 0 }}</strong> à
                                        <strong>{{ $factures->lastItem() ?? 0 }}</strong> sur
                                        <strong>{{ $factures->total() }}</strong> factures
                                    </div>
                                    <nav aria-label="Navigation des paiements">
                                        <ul class="pagination pagination-sm mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($factures->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $factures->previousPageUrl() }}"
                                                        rel="prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($factures->links()->elements[0] as $page => $url)
                                                @if ($page == $factures->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link"
                                                            href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($factures->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $factures->nextPageUrl() }}"
                                                        rel="next">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cette facture ? Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.facture-row');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Sort functionality
        document.querySelectorAll('.sortable').forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.sort;
                sortTable(column);
            });
        });

        function sortTable(column) {
            // Implementation for sorting would go here
            console.log('Sorting by:', column);
        }

        // Delete confirmation
        function confirmDelete(factureId) {
            const form = document.getElementById('deleteForm');
            form.action = `/factureep/${factureId}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
            font-weight: 600;
        }

        .sortable {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .sortable:hover {
            background-color: #e9ecef;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.04);
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .facture-row td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.75em;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-group-sm>.btn {
                padding: 0.2rem 0.4rem;
            }

            .avatar-sm {
                width: 24px;
                height: 24px;
                font-size: 12px;
            }
        }
    </style>
    {{-- <script>
        $(document).ready(function() {
            $('#facturesTable').DataTable({
                order: []
            });
        });
    </script> --}}
    <!-- Include Bootstrap Icons -->
@endsection
