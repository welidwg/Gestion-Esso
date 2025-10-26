@extends('dashboard/base')

@section('title', 'Détails de la Facture Epicerie')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-file-invoice me-2"></i>Facture #{{ $facture->id }}
                            </h4>
                            <div class="btn-group">
                                {{-- <a href="{{ route('factureepicerie.edit', $facture->id) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-edit me-1"></i>Modifier
                                </a> --}}
                                <a href="{{ route('factureepicerie.index') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Retour
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Facture Header -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3"><i class="fas fa-building me-2"></i>Fournisseur</h6>
                                        <h5 class="text-primary mb-0">{{ $facture->nom_de_fournisseur }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3"><i class="fas fa-calendar me-2"></i>Date de facturation
                                        </h6>
                                        <h5 class="text-primary mb-0">{{ $facture->date->format('d/m/Y') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Articles Section -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary mb-0">
                                <i class="fas fa-cubes me-2"></i>Articles ({{ count($facture->articles) }})
                            </h5>
                        </div>

                        @if (count($facture->articles))
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold text-dark">
                                                <i class="fas fa-tag me-2"></i>Désignation
                                            </th>
                                            <th class="fw-semibold text-dark text-center">
                                                <i class="fas fa-euro-sign me-2"></i>Prix Unité
                                            </th>
                                            <th class="fw-semibold text-dark text-center">
                                                <i class="fas fa-sort-amount-up me-2"></i>Quantité
                                            </th>
                                            <th class="fw-semibold text-dark text-center">
                                                <i class="fas fa-receipt me-2"></i>Prix HT
                                            </th>
                                            <th class="fw-semibold text-dark text-center">
                                                <i class="fas fa-percent me-2"></i>TVA
                                            </th>
                                            <th class="fw-semibold text-dark text-center">
                                                <i class="fas fa-file-invoice-dollar me-2"></i>Prix TTC
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalHt = 0;
                                            $totalTtc = 0;
                                            $totalTva = 0;
                                        @endphp

                                        @foreach ($facture->articles as $article)
                                            @php
                                                $totalHt += $article['prix_ht'];
                                                $totalTtc += $article['prix_ttc'];
                                                $totalTva += $article['prix_ttc'] - $article['prix_ht'];
                                            @endphp
                                            <tr class="border-bottom">
                                                <td class="fw-medium">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-cube text-muted me-2"></i>
                                                        {{ $article['designation'] }}
                                                    </div>
                                                </td>
                                                <td class="text-center fw-semibold">
                                                    {{ number_format($article['prix_unite'], 2) }} €
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary fs-6">
                                                        {{ $article['qte'] }}
                                                    </span>
                                                </td>
                                                <td class="text-center fw-semibold text-success">
                                                    {{ number_format($article['prix_ht'], 2) }} €
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info bg-opacity-10 text-info">
                                                        {{ number_format($article['tva'], 2) }} %
                                                    </span>
                                                </td>
                                                <td class="text-center fw-bold text-primary">
                                                    {{ number_format($article['prix_ttc'], 2) }} €
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-group-divider">
                                        <tr class="fw-bold">
                                            <td colspan="3" class="text-end text-dark">SOUS-TOTAL HT</td>
                                            <td class="text-center text-success">{{ number_format($totalHt, 2) }} €</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td colspan="3" class="text-end text-dark">TOTAL TVA</td>
                                            <td></td>
                                            <td class="text-center text-info">{{ number_format($totalTva, 2) }} €</td>
                                            <td></td>
                                        </tr>
                                        <tr class="fw-bold fs-5" style="background-color: rgba(0, 123, 255, 0.05);">
                                            <td colspan="3" class="text-end text-dark">TOTAL TTC</td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center text-primary">{{ number_format($totalTtc, 2) }} €</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Summary Cards -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card border-success border-2">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-muted mb-2">Total HT</h6>
                                            <h4 class="text-success mb-0">{{ number_format($totalHt, 2) }} €</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-info border-2">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-muted mb-2">Total TVA</h6>
                                            <h4 class="text-info mb-0">{{ number_format($totalTva, 2) }} €</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-primary border-2">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-muted mb-2">Total TTC</h6>
                                            <h4 class="text-primary mb-0">{{ number_format($totalTtc, 2) }} €</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun article dans cette facture</h5>
                                <p class="text-muted">Ajoutez des articles pour compléter cette facture.</p>
                                <a href="{{ route('factureepicerie.edit', $facture->id) }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Ajouter des articles
                                </a>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('factureepicerie.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                            </a>
                            {{-- <div class="btn-group">
                                <a href="{{ route('factureepicerie.edit', $facture->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Modifier
                                </a>
                                <button type="button" class="btn btn-success" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i>Imprimer
                                </button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }

        tfoot tr {
            border-top: 2px solid #dee2e6;
        }

        .border-2 {
            border-width: 2px !important;
        }

        @media print {

            .btn-group,
            .card-header .btn-group {
                display: none !important;
            }

            .border-top {
                border-top: none !important;
            }
        }
    </style>
@endsection
