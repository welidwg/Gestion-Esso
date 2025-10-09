@extends('dashboard/base')
@section('title')
    Ajouter Paiement Fournisseur
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-money-bill-wave me-2"></i>Ajouter Paiement Fournisseur
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('paiementfournisseur.store') }}" id="paiement-form">
                            @csrf

                            <div id="paiement-group">
                                <div class="paiement-item card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h6 class="mb-0">Paiement #1</h6>
                                        <button type="button" class="btn btn-sm btn-danger remove-item d-none">
                                            <i class="fas fa-trash me-1"></i>Supprimer
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="date_0" class="form-label">
                                                    <i class="fas fa-calendar text-primary me-1"></i>Date
                                                </label>
                                                <input type="date" class="form-control" id="date_0"
                                                    name="paiements[0][date]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="fournisseur_0" class="form-label">
                                                    <i class="fas fa-building text-primary me-1"></i>Fournisseur
                                                </label>
                                                <input type="text" class="form-control" id="fournisseur_0"
                                                    name="paiements[0][fournisseur]" required
                                                    placeholder="Nom du fournisseur">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="montant_ttc_0" class="form-label">
                                                    <i class="fas fa-euro-sign text-success me-1"></i>Montant de paiement
                                                    TTC (€)
                                                </label>
                                                <input type="number" step="0.01" class="form-control montant-input"
                                                    id="montant_ttc_0" name="paiements[0][montant_ttc]" required
                                                    oninput="updateTotals()" placeholder="0.00">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mode_paiement_0" class="form-label">
                                                    <i class="fas fa-credit-card text-info me-1"></i>Mode de Paiement
                                                </label>
                                                <select class="form-select" id="mode_paiement_0"
                                                    name="paiements[0][mode_de_paiement]" required>
                                                    <option value="">Sélectionner un mode de paiement</option>
                                                    <option value="Carte bancaire">Carte bancaire</option>
                                                    <option value="Espèce">Espèce</option>
                                                    <option value="Virement">Virement bancaire</option>
                                                    <option value="Chèque">Chèque</option>
                                                    <option value="Prélèvement">Prélèvement automatique</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                                <button type="button" class="btn btn-success" onclick="addPaiement()">
                                    <i class="fas fa-plus-circle me-1"></i>Ajouter un autre paiement
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Enregistrer les paiements
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-1"></i>Réinitialiser
                                </button>
                            </div>
                        </form>

                        <!-- Summary Card -->
                        <div class="card mt-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Récapitulatif des Paiements
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <h4 class="text-success mb-1" id="total-montant">0.00</h4>
                                            <strong class="text-muted">TOTAL PAIEMENT TTC (€)</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <h4 class="text-primary mb-1" id="total-paiements">0</h4>
                                            <strong class="text-muted">NOMBRE DE PAIEMENTS</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Method Breakdown -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let paiementCount = 1;

        function addPaiement() {
            const html = `
            <div class="paiement-item card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h6 class="mb-0">Paiement #${paiementCount + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-item" onclick="removePaiement(this)">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="date_${paiementCount}" class="form-label">
                                <i class="fas fa-calendar text-primary me-1"></i>Date
                            </label>
                            <input type="date" class="form-control" id="date_${paiementCount}" 
                                   name="paiements[${paiementCount}][date]" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fournisseur_${paiementCount}" class="form-label">
                                <i class="fas fa-building text-primary me-1"></i>Fournisseur
                            </label>
                            <input type="text" class="form-control" id="fournisseur_${paiementCount}" 
                                   name="paiements[${paiementCount}][fournisseur]" required 
                                   placeholder="Nom du fournisseur">
                        </div>
                        <div class="col-md-6">
                            <label for="montant_ttc_${paiementCount}" class="form-label">
                                <i class="fas fa-euro-sign text-success me-1"></i>Montant de paiement TTC (€)
                            </label>
                            <input type="number" step="0.01" class="form-control montant-input" 
                                   id="montant_ttc_${paiementCount}" name="paiements[${paiementCount}][montant_ttc]" required 
                                   oninput="updateTotals()" placeholder="0.00">
                        </div>
                        <div class="col-md-6">
                            <label for="mode_paiement_${paiementCount}" class="form-label">
                                <i class="fas fa-credit-card text-info me-1"></i>Mode de Paiement
                            </label>
                            <select class="form-select" id="mode_paiement_${paiementCount}" 
                                    name="paiements[${paiementCount}][mode_de_paiement]" required>
                                <option value="">Sélectionner un mode de paiement</option>
                                <option value="Carte bancaire">Carte bancaire</option>
                                <option value="Espèce">Espèce</option>
                                <option value="Virement">Virement bancaire</option>
                                <option value="Chèque">Chèque</option>
                                <option value="Prélèvement">Prélèvement automatique</option>
                            </select>
                        </div>
                     
                    </div>
                </div>
            </div>`;

            document.getElementById('paiement-group').insertAdjacentHTML('beforeend', html);

            // Show remove button on first item if there are multiple items
            if (paiementCount === 1) {
                document.querySelector('.paiement-item .remove-item').classList.remove('d-none');
            }

            paiementCount++;
            updateTotals();
        }

        function removePaiement(button) {
            const item = button.closest('.paiement-item');
            item.remove();
            updateTotals();
            renumberItems();
        }

        function renumberItems() {
            const items = document.getElementsByClassName('paiement-item');
            for (let idx = 0; idx < items.length; idx++) {
                const header = items[idx].querySelector('.card-header h6');
                header.textContent = `Paiement #${idx + 1}`;

                // Hide remove button if only one item remains
                if (items.length === 1) {
                    items[idx].querySelector('.remove-item').classList.add('d-none');
                } else {
                    items[idx].querySelector('.remove-item').classList.remove('d-none');
                }
            }
        }

        function updateTotals() {
            let totalMontant = 0;
            const paymentMethods = {};

            const items = document.getElementsByClassName('paiement-item');

            for (let idx = 0; idx < items.length; idx++) {
                const montantInput = items[idx].querySelector(`input[name='paiements[${idx}][montant_ttc]']`);
                const methodSelect = items[idx].querySelector(`select[name='paiements[${idx}][mode_de_paiement]']`);

                const montant = parseFloat(montantInput.value) || 0;
                const method = methodSelect.value || 'Non spécifié';

                totalMontant += montant;

                // Track payment methods
                if (paymentMethods[method]) {
                    paymentMethods[method] += montant;
                } else {
                    paymentMethods[method] = montant;
                }
            }

            // Update total amount
            document.getElementById('total-montant').innerText = totalMontant.toFixed(2) + ' €';
            document.getElementById('total-paiements').innerText = items.length;

            // Update payment method breakdown
            updateMethodBreakdown(paymentMethods, totalMontant);
        }

        function updateMethodBreakdown(paymentMethods, totalMontant) {
            const breakdownContainer = document.getElementById('method-breakdown');
            let html = '';

            for (const [method, amount] of Object.entries(paymentMethods)) {
                if (method && method !== 'Non spécifié') {
                    const percentage = totalMontant > 0 ? ((amount / totalMontant) * 100).toFixed(1) : 0;
                    html += `
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                            <span class="small">${method}:</span>
                            <div class="text-end">
                                <div class="fw-bold">${amount.toFixed(2)} €</div>
                                <small class="text-muted">${percentage}%</small>
                            </div>
                        </div>
                    </div>`;
                }
            }

            breakdownContainer.innerHTML = html ||
                '<div class="col-12 text-muted text-center">Aucun mode de paiement sélectionné</div>';
        }

        // Initialize with today's date
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date_0').value = today;

            // Add input formatting for better UX
            document.querySelectorAll('.montant-input').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            });
        });

        // Form validation
        document.getElementById('paiement-form').addEventListener('submit', function(e) {
            const items = document.getElementsByClassName('paiement-item');
            let isValid = true;

            for (let idx = 0; idx < items.length; idx++) {
                const montantInput = items[idx].querySelector(`input[name='paiements[${idx}][montant_ttc]']`);
                const methodSelect = items[idx].querySelector(`select[name='paiements[${idx}][mode_de_paiement]']`);

                if (!montantInput.value || parseFloat(montantInput.value) <= 0) {
                    montantInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    montantInput.classList.remove('is-invalid');
                }

                if (!methodSelect.value) {
                    methodSelect.classList.add('is-invalid');
                    isValid = false;
                } else {
                    methodSelect.classList.remove('is-invalid');
                }
            }

            if (!isValid) {
                e.preventDefault();
                alert('Veuillez corriger les erreurs dans le formulaire.');
            }
        });
    </script>

    <style>
        .paiement-item {
            transition: all 0.3s ease;
        }

        .paiement-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .montant-input:invalid {
            border-color: #dc3545;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        @media (max-width: 768px) {
            .d-flex.flex-md-row {
                flex-direction: column !important;
            }

            .btn {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <!-- Include Font Awesome -->
@endsection
