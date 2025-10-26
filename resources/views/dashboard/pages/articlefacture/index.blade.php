@extends('dashboard/base')

@section('title', 'Articles des Factures')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-primary">
                        <i class="fas fa-cube me-2"></i>Articles des Factures
                    </h4>
                    <a href="{{ route('articlefacture.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter un Article
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Search Bar -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0"
                                placeholder="Rechercher un article...">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted" id="resultCount">
                            {{ $articles->total() }} article(s) trouvé(s)
                        </span>
                    </div>
                </div>

                @if ($articles->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="articlesTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold">
                                        <i class="fas fa-tag me-2"></i>Désignation
                                    </th>
                                    <th class="fw-semibold">
                                        <i class="fas fa-euro-sign me-2"></i>Prix Unité (€)
                                    </th>
                                    <th class="fw-semibold">
                                        <i class="fas fa-percent me-2"></i>Taux TVA (%)
                                    </th>
                                    <th class="fw-semibold text-center">
                                        <i class="fas fa-cogs me-2"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr class="article-row">
                                        <td class="fw-medium">{{ $article->designation }}</td>
                                        <td>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                {{ $article->prix_unite !== null ? number_format($article->prix_unite, 2) : '-' }}
                                                €
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                {{ $article->tva !== null ? number_format($article->tva, 1) : '-' }} %
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('articlefacture.edit', $article->id) }}"
                                                    class="btn btn-outline-warning rounded-start-2" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('articlefacture.destroy', $article->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Confirmer la suppression ?')">
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
                            Affichage de <strong>{{ $articles->firstItem() }}</strong> à
                            <strong>{{ $articles->lastItem() }}</strong> sur
                            <strong>{{ $articles->total() }}</strong> résultats
                        </div>
                        <div>
                            {{ $articles->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-cube fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun article enregistré</h5>
                        <p class="text-muted mb-4">Commencez par ajouter votre premier article.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');
            const resultCount = document.getElementById('resultCount');
            const articleRows = document.querySelectorAll('.article-row');

            // Function to filter articles
            function filterArticles() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                articleRows.forEach(row => {
                    const designation = row.cells[0].textContent.toLowerCase();
                    const prix = row.cells[1].textContent.toLowerCase();
                    const tva = row.cells[2].textContent.toLowerCase();

                    if (designation.includes(searchTerm) ||
                        prix.includes(searchTerm) ||
                        tva.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update result count
                resultCount.textContent = `${visibleCount} article(s) trouvé(s)`;

                // Show/hide table header when no results
                const tableHead = document.querySelector('thead');
                if (visibleCount === 0 && searchTerm !== '') {
                    tableHead.style.display = 'none';
                } else {
                    tableHead.style.display = '';
                }
            }

            // Event listeners
            searchInput.addEventListener('input', filterArticles);

            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                filterArticles();
                searchInput.focus();
            });

            // Clear search on escape key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    filterArticles();
                }
            });
        });
    </script>

    <style>
        .card {
            border-radius: 12px;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 1.5rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
        }

        .badge {
            font-size: 0.8rem;
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

        .input-group-text {
            border-right: none;
        }

        .form-control.border-start-0 {
            border-left: none;
        }

        #searchInput:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
    </style>
@endsection
