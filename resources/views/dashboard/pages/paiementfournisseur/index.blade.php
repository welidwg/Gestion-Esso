@extends('dashboard/base')
@section('title')
    Liste des Paiements Fournisseurs
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-money-bill-wave me-2"></i>Liste des Paiements Fournisseurs
                            </h4>
                            <small class="opacity-75">Gestion des paiements aux fournisseurs</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-light text-primary fs-6 me-3">
                                {{ $paiements->count() }} paiement(s)
                            </span>
                            <a href="{{ route('paiementfournisseur.create') }}" class="btn btn-light">
                                <i class="fas fa-plus-circle me-1"></i>Nouveau Paiement
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
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Rechercher un fournisseur...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2 justify-content-md-end">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-filter me-1"></i>Filtrer
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item filter-option" href="#" data-filter="all">Tous
                                                    les paiements</a></li>
                                            <li><a class="dropdown-item filter-option" href="#"
                                                    data-filter="Carte bancaire">Carte bancaire</a></li>
                                            <li><a class="dropdown-item filter-option" href="#"
                                                    data-filter="Espèce">Espèce</a></li>
                                            <li><a class="dropdown-item filter-option" href="#"
                                                    data-filter="Virement">Virement</a></li>
                                            <li><a class="dropdown-item filter-option" href="#"
                                                    data-filter="Chèque">Chèque</a></li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetFilters()">
                                        <i class="fas fa-refresh me-1"></i>Réinitialiser
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Responsive Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle" id="paiementsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="sortable" data-sort="date">
                                            <i class="fas fa-calendar me-1"></i>Date
                                        </th>
                                        <th scope="col" class="sortable" data-sort="fournisseur">
                                            <i class="fas fa-building me-1"></i>Fournisseur
                                        </th>
                                        <th scope="col" class="sortable text-end" data-sort="montant_ttc">
                                            <i class="fas fa-euro-sign me-1"></i>Montant TTC
                                        </th>
                                        <th scope="col" class="sortable" data-sort="mode_de_paiement">
                                            <i class="fas fa-credit-card me-1"></i>Mode de Paiement
                                        </th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @forelse($paiements as $paiement)
                                        @php
                                            $total += $paiement->montant_ttc;
                                        @endphp
                                        <tr class="paiement-row" data-method="{{ $paiement->mode_de_paiement }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded p-2 me-2">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">
                                                            {{ \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ \Carbon\Carbon::parse($paiement->date)->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        {{ substr($paiement->fournisseur, 0, 1) }}
                                                    </div>
                                                    <span class="fw-medium">{{ $paiement->fournisseur }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold text-success fs-5">
                                                    {{ number_format($paiement->montant_ttc, 2, ',', ' ') }} €
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $methodBadges = [
                                                        'Carte bancaire' => 'primary',
                                                        'Espèce' => 'success',
                                                        'Virement' => 'info',
                                                        'Chèque' => 'warning',
                                                        'Prélèvement' => 'secondary',
                                                    ];
                                                    $badgeClass = $methodBadges[$paiement->mode_de_paiement] ?? 'dark';
                                                @endphp
                                                <span class="badge bg-{{ $badgeClass }}">
                                                    <i
                                                        class="fas fa-{{ $paiement->mode_de_paiement == 'Carte bancaire' ? 'credit-card' : ($paiement->mode_de_paiement == 'Espèce' ? 'money-bill' : 'university') }} me-1"></i>
                                                    {{ $paiement->mode_de_paiement }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('paiementfournisseur.show', $paiement->id) }}"
                                                        class="btn btn-outline-primary" title="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- <a href="{{ route('paiementfournisseur.edit', $paiement->id) }}"
                                                        class="btn btn-outline-secondary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a> --}}
                                                    <form method="POST"
                                                        action="{{ route('paiementfournisseur.destroy', $paiement->id) }}"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Supprimer ce paiement ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger"
                                                            title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Aucun paiement trouvé</h5>
                                                    <p class="text-muted">Commencez par ajouter votre premier paiement
                                                        fournisseur.</p>
                                                    <a href="{{ route('paiementfournisseur.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Ajouter un paiement
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($paiements->count() > 0)
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2" class="text-end">Total Général:</th>
                                            <th class="text-end fw-bold text-success fs-4">
                                                {{ number_format($total, 2, ',', ' ') }} €
                                            </th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>

                        <!-- Statistics Cards -->
                        @if ($paiements->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="fas fa-chart-pie me-2"></i>Statistiques des Paiements
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                @php
                                                    $methods = $paiements->groupBy('mode_de_paiement');
                                                @endphp
                                                @foreach ($methods as $method => $items)
                                                    @php
                                                        $methodTotal = $items->sum('montant_ttc');
                                                        $percentage = $total > 0 ? ($methodTotal / $total) * 100 : 0;
                                                    @endphp
                                                    <div class="col-md-2 col-6 mb-3">
                                                        <div class="p-3 border rounded">
                                                            <div class="fw-bold text-primary mb-1">{{ $items->count() }}
                                                            </div>
                                                            <small class="text-muted d-block">{{ $method }}</small>
                                                            <div class="fw-bold text-success">
                                                                {{ number_format($methodTotal, 2, ',', ' ') }} €</div>
                                                            <small
                                                                class="text-muted">{{ number_format($percentage, 1) }}%</small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Pagination -->
                        @if ($paiements->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Affichage de <strong>{{ $paiements->firstItem() ?? 0 }}</strong> à
                                    <strong>{{ $paiements->lastItem() ?? 0 }}</strong> sur
                                    <strong>{{ $paiements->total() }}</strong> paiements
                                </div>
                                <nav aria-label="Navigation des paiements">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($paiements->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="fas fa-chevron-left"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $paiements->previousPageUrl() }}"
                                                    rel="prev">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($paiements->links()->elements[0] as $page => $url)
                                            @if ($page == $paiements->currentPage())
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
                                        @if ($paiements->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $paiements->nextPageUrl() }}"
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

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.paiement-row');

            rows.forEach(row => {
                const fournisseur = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const method = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const text = fournisseur + ' ' + method;

                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });

            updateVisibleStats();
        });

        // Filter functionality
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = this.dataset.filter;
                const rows = document.querySelectorAll('.paiement-row');

                rows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else {
                        const method = row.dataset.method;
                        row.style.display = method === filter ? '' : 'none';
                    }
                });

                // Update active filter state
                document.querySelectorAll('.filter-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                this.classList.add('active');

                updateVisibleStats();
            });
        });

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            const rows = document.querySelectorAll('.paiement-row');
            rows.forEach(row => row.style.display = '');

            document.querySelectorAll('.filter-option').forEach(opt => {
                opt.classList.remove('active');
            });
            document.querySelector('.filter-option[data-filter="all"]').classList.add('active');

            updateVisibleStats();
        }

        // Sort functionality (basic implementation)
        document.querySelectorAll('.sortable').forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.sort;
                // Implement sorting logic here
                console.log('Sorting by:', column);
            });
        });

        // Update statistics for visible rows
        function updateVisibleStats() {
            // This would update statistics based on visible rows
            // Implementation depends on your specific needs
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
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

        .paiement-row td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.75em;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
        }

        .filter-option.active {
            background-color: #0d6efd;
            color: white;
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

            .card-header .d-flex {
                flex-direction: column;
                gap: 1rem;
            }

            .card-header .btn {
                width: 100%;
            }
        }
    </style>


@endsection
