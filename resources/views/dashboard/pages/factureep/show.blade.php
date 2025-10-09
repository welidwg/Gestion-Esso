@extends('dashboard/base')
@section('title')
    Détails Facture Epicerie - {{ $facture->nom_de_fournisseur }}
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('factureep.index') }}"
                                        class="text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i>Liste des Factures
                                    </a></li>
                                <li class="breadcrumb-item active">Détails Facture</li>
                            </ol>
                        </nav>
                        <h1 class="h3 mb-0">
                            <i class="fas fa-receipt text-primary me-2"></i>Détails Facture Epicerie
                        </h1>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('factureep.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-1"></i>Retour à la liste
                        </a>

                        <button class="btn btn-outline-danger" onclick="confirmDelete({{ $facture->id }})">
                            <i class="fas fa-trash me-1"></i>Supprimer
                        </button>
                    </div>
                </div>

                <div class="row">
                    <!-- Main Invoice Details -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informations de la Facture
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-1">Nom du Fournisseur</label>
                                            <div class="detail-value">
                                                <i class="fas fa-building me-2 text-primary"></i>
                                                {{ $facture->nom_de_fournisseur }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-1">Date de la Facture</label>
                                            <div class="detail-value">
                                                <i class="fas fa-calendar me-2 text-primary"></i>
                                                {{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-1">Désignation</label>
                                            <div class="detail-value">
                                                <i class="fas fa-tag me-2 text-primary"></i>
                                                {{ $facture->designation }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Details -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calculator me-2"></i>Détails du Calcul
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-1">Prix Unitaire</label>
                                            <div class="detail-value h5 text-primary">
                                                {{ number_format($facture->prix_unite, 2, ',', ' ') }} €
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-1">Quantité</label>
                                            <div class="detail-value">
                                                <span class="badge bg-primary fs-6">{{ $facture->qte }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-1">Taux de TVA</label>
                                            <div class="detail-value">
                                                <span
                                                    class="badge bg-warning text-dark fs-6">{{ number_format($facture->tva, 2, ',', ' ') }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-1">Prix Hors Taxe</label>
                                            <div class="detail-value h5">
                                                {{ number_format($facture->prix_ht, 2, ',', ' ') }} €
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                        <div class="detail-item text-center">
                                            <label class="form-label fw-semibold text-muted mb-1">Prix Toutes Taxes
                                                Comprises</label>
                                            <div class="detail-value h3 text-success">
                                                {{ number_format($facture->prix_ttc, 2, ',', ' ') }} €
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm sticky-top" style="top: 20px;">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Récapitulatif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="summary-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Total HT:</span>
                                        <span class="fw-bold fs-5 text-primary">
                                            {{ number_format($facture->prix_ht, 2, ',', ' ') }} €
                                        </span>
                                    </div>
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ ($facture->prix_ht / $facture->prix_ttc) * 100 }}%"></div>
                                    </div>
                                </div>

                                <div class="summary-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Montant TVA:</span>
                                        <span class="fw-bold fs-5 text-warning">
                                            {{ number_format($facture->prix_ttc - $facture->prix_ht, 2, ',', ' ') }} €
                                        </span>
                                    </div>
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-warning"
                                            style="width: {{ (($facture->prix_ttc - $facture->prix_ht) / $facture->prix_ttc) * 100 }}%">
                                        </div>
                                    </div>
                                </div>

                                <div class="summary-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Total TTC:</span>
                                        <span class="fw-bold fs-4 text-success">
                                            {{ number_format($facture->prix_ttc, 2, ',', ' ') }} €
                                        </span>
                                    </div>
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Quick Stats -->
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="stat-item">
                                            <div class="stat-value text-primary">{{ $facture->qte }}</div>
                                            <div class="stat-label text-muted small">Quantité</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-item">
                                            <div class="stat-value text-warning">{{ number_format($facture->tva, 1) }}%
                                            </div>
                                            <div class="stat-label text-muted small">TVA</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-history me-2"></i>Informations Supplémentaires
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted">Date de création:</small>
                                        <p class="mb-2">{{ $facture->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Dernière modification:</small>
                                        <p class="mb-2">{{ $facture->updated_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">ID de la facture:</small>
                                        <p class="mb-2"><code>#{{ str_pad($facture->id, 6, '0', STR_PAD_LEFT) }}</code>
                                        </p>
                                    </div>
                                </div>
                            </div>
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
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cette facture ?</p>
                    <div class="alert alert-warning">
                        <strong>Fournisseur:</strong> {{ $facture->nom_de_fournisseur }}<br>
                        <strong>Montant:</strong> {{ number_format($facture->prix_ttc, 2, ',', ' ') }} €<br>
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($facture->date)->format('d/m/Y') }}
                    </div>
                    <p class="text-danger"><small>Cette action est irréversible.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Annuler
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(factureId) {
            const form = document.getElementById('deleteForm');
            form.action = `/factureep/${factureId}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        // Print functionality
        function printInvoice() {
            window.print();
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        .detail-item {
            padding: 0.5rem 0;
        }

        .detail-value {
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            border-left: 4px solid #0d6efd;
        }

        .summary-item {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .sticky-top {
            z-index: 1020;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        @media print {

            .btn-group,
            .breadcrumb,
            .card-header .btn {
                display: none !important;
            }

            .card {
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
            }
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <!-- Include Bootstrap Icons -->
@endsection
