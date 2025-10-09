@extends('dashboard/base')
@section('title')
    Détails Paiement Fournisseur - {{ $paiement->fournisseur }}
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
                                <li class="breadcrumb-item"><a href="{{ route('paiementfournisseur.index') }}"
                                        class="text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i>Liste des Paiements
                                    </a></li>
                                <li class="breadcrumb-item active">Détails Paiement</li>
                            </ol>
                        </nav>
                        <h1 class="h3 mb-0">
                            <i class="fas fa-money-bill-wave text-primary me-2"></i>Détails Paiement Fournisseur
                        </h1>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('paiementfournisseur.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-1"></i>Retour à la liste
                        </a>

                        <form method="POST" action="{{ route('paiementfournisseur.destroy', $paiement->id) }}"
                            class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-1"></i>Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <!-- Main Payment Details -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informations du Paiement
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-2">Date du Paiement</label>
                                            <div class="detail-value">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded p-2 me-3">
                                                        <i class="fas fa-calendar-day fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium fs-5">
                                                            {{ \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ \Carbon\Carbon::parse($paiement->date)->translatedFormat('l j F Y') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-2">Fournisseur</label>
                                            <div class="detail-value">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-lg bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        {{ substr($paiement->fournisseur, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium fs-5">{{ $paiement->fournisseur }}</div>
                                                        <small class="text-muted">Fournisseur</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-2">Montant TTC</label>
                                            <div class="detail-value">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success text-white rounded p-2 me-3">
                                                        <i class="fas fa-euro-sign fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold fs-3 text-success">
                                                            {{ number_format($paiement->montant_ttc, 2, ',', ' ') }} €</div>
                                                        <small class="text-muted">Montant toutes taxes comprises</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <label class="form-label fw-semibold text-muted mb-2">Mode de Paiement</label>
                                            <div class="detail-value">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-warning text-dark rounded p-2 me-3">
                                                        <i class="fas fa-credit-card fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        @php
                                                            $methodIcons = [
                                                                'Carte bancaire' => 'credit-card',
                                                                'Espèce' => 'money-bill',
                                                                'Virement' => 'university',
                                                                'Chèque' => 'file-invoice-dollar',
                                                                'Prélèvement' => 'calendar-alt',
                                                            ];
                                                            $icon =
                                                                $methodIcons[$paiement->mode_de_paiement] ??
                                                                'credit-card';
                                                        @endphp
                                                        <div class="fw-medium fs-5">{{ $paiement->mode_de_paiement }}</div>
                                                        <small class="text-muted">
                                                            <i class="fas fa-{{ $icon }} me-1"></i>
                                                            Mode de règlement
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-receipt me-2"></i>Informations Supplémentaires
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <span class="text-muted">ID du paiement:</span>
                                            <strong
                                                class="d-block">#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <span class="text-muted">Date de création:</span>
                                            <strong
                                                class="d-block">{{ $paiement->created_at->format('d/m/Y à H:i') }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <span class="text-muted">Dernière modification:</span>
                                            <strong
                                                class="d-block">{{ $paiement->updated_at->format('d/m/Y à H:i') }}</strong>
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
                                <!-- Quick Stats -->
                                <div class="text-center mb-4">
                                    <div class="bg-light rounded p-3 mb-3">
                                        <div class="fs-2 fw-bold text-success">
                                            {{ number_format($paiement->montant_ttc, 2, ',', ' ') }} €</div>
                                        <small class="text-muted">Montant Total</small>
                                    </div>
                                </div>

                                <!-- Payment Details -->
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Fournisseur</span>
                                        <strong>{{ $paiement->fournisseur }}</strong>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Date</span>
                                        <strong>{{ \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') }}</strong>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Mode</span>
                                        <span class="badge bg-primary">{{ $paiement->mode_de_paiement }}</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Référence</span>
                                        <code>#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</code>
                                    </div>
                                </div>

                                {{-- <!-- Action Buttons -->
                                <div class="d-grid gap-2 mt-4">
                                    <button onclick="printPayment()" class="btn btn-primary">
                                        <i class="fas fa-print me-1"></i>Imprimer
                                    </button>
                                    <button onclick="downloadPDF({{ $paiement->id }})" class="btn btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>Télécharger PDF
                                    </button>
                                 
                                </div> --}}

                                <!-- Quick Links -->
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="text-muted mb-3">Actions Rapides</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('paiementfournisseur.create') }}"
                                            class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-plus me-1"></i>Nouveau Paiement
                                        </a>
                                        <a href="{{ route('paiementfournisseur.index') }}"
                                            class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-history me-1"></i>Voir l'historique
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Print Template (Hidden) -->
    <div id="printTemplate" style="display: none;">
        <div style="padding: 20mm; font-family: Arial, sans-serif;">
            <div style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px;">
                <h1 style="color: #2c5aa0; margin: 0;">DÉTAILS DE PAIEMENT</h1>
                <p style="color: #666; margin: 5px 0;">SAR Stable Coin</p>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                <div>
                    <h3>Fournisseur</h3>
                    <p><strong>{{ $paiement->fournisseur }}</strong></p>
                </div>
                <div style="text-align: right;">
                    <h3>Paiement</h3>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') }}</p>
                    <p><strong>Référence:</strong> #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <tr style="background-color: #f8f9fa;">
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Description</th>
                    <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Détails</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 12px;"><strong>Montant TTC</strong></td>
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        {{ number_format($paiement->montant_ttc, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 12px;"><strong>Mode de Paiement</strong></td>
                    <td style="border: 1px solid #ddd; padding: 12px;">{{ $paiement->mode_de_paiement }}</td>
                </tr>
            </table>

            <div style="margin-top: 50px; text-align: center; color: #666; border-top: 1px solid #ddd; padding-top: 20px;">
                <p>Document généré le {{ now()->format('d/m/Y à H:i') }} - SAR Stable Coin</p>
            </div>
        </div>
    </div>

    <script>
        function printPayment() {
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            const printContent = document.getElementById('printTemplate').innerHTML;

            printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Paiement {{ $paiement->fournisseur }}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
                @media print { body { margin: 0; } @page { margin: 20mm; } }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 12px; }
                th { background-color: #f8f9fa; }
            </style>
        </head>
        <body>${printContent}</body>
        </html>
    `);

            printWindow.document.close();
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
            };
        }

        function downloadPDF(paymentId) {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Génération...';
            btn.disabled = true;

            // Simulate PDF download (replace with actual implementation)
            setTimeout(() => {
                alert('Fonctionnalité PDF à implémenter');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 1000);
        }
    </script>

    <style>
        .detail-item {
            margin-bottom: 1.5rem;
        }

        .detail-value {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            border-left: 4px solid #0d6efd;
        }

        .avatar-lg {
            width: 60px;
            height: 60px;
            font-size: 24px;
            font-weight: 600;
        }

        .info-item {
            padding: 0.75rem;
            border-bottom: 1px solid #e9ecef;
        }

        .hover-effect {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
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

        .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn,
            .btn-group form {
                margin-bottom: 0.5rem;
                width: 100%;
            }

            .avatar-lg {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }

        @media print {

            .btn-group,
            .breadcrumb,
            .sticky-top,
            .card-header .btn {
                display: none !important;
            }
        }
    </style>

    <!-- Include Font Awesome -->
@endsection
