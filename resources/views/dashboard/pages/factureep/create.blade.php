@extends('dashboard/base')
@section('title')
    Ajouter Facture Epicerie
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Ajouter Facture Epicerie</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('factureep.store') }}" id="invoice-form">
                            @csrf
                            <div id="facture-group">
                                <div class="facture-item card mb-3">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h6 class="mb-0">Article #1</h6>
                                        <button type="button" class="btn btn-sm btn-danger remove-item d-none">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="nom_fournisseur_0" class="form-label">Nom de fournisseur</label>
                                                <input type="text" class="form-control" id="nom_fournisseur_0"
                                                    name="factures[0][nom_de_fournisseur]" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="date_0" class="form-label">Date</label>
                                                <input type="date" class="form-control" id="date_0"
                                                    name="factures[0][date]" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="designation_0" class="form-label">Désignation</label>
                                                <input type="text" class="form-control" id="designation_0"
                                                    name="factures[0][designation]" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="prix_unite_0" class="form-label">PRIX UNITÉ (€)</label>
                                                <input type="number" step="0.01" class="form-control" id="prix_unite_0"
                                                    name="factures[0][prix_unite]" required oninput="updateLine(0)">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="qte_0" class="form-label">Quantité</label>
                                                <input type="number" class="form-control" id="qte_0"
                                                    name="factures[0][qte]" required oninput="updateLine(0)">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="tva_0" class="form-label">TVA (%)</label>
                                                <input type="number" step="0.01" class="form-control" id="tva_0"
                                                    name="factures[0][tva]" required oninput="updateLine(0)">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="prix_ht_0" class="form-label">PRIX HT (€)</label>
                                                <input type="number" step="0.01" class="form-control bg-light"
                                                    id="prix_ht_0" name="factures[0][prix_ht]" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="prix_ttc_0" class="form-label">PRIX TTC (€)</label>
                                                <input type="number" step="0.01" class="form-control bg-light"
                                                    id="prix_ttc_0" name="factures[0][prix_ttc]" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="button" class="btn btn-success" onclick="addFacture()">
                                    <i class="fas fa-plus"></i> Ajouter une autre facture
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>

                        <div class="card mt-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Récapitulatif</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <div class="p-3 border rounded bg-light">
                                            <h4 class="text-primary" id="total-ht">0.00</h4>
                                            <strong>TOTAL HT (€)</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 border rounded bg-light">
                                            <h4 class="text-warning" id="total-tva">0.00</h4>
                                            <strong>TOTAL TVA (€)</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 border rounded bg-light">
                                            <h4 class="text-success" id="total-ttc">0.00</h4>
                                            <strong>TOTAL TTC (€)</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let i = 1;

        function addFacture() {
            // Get the value from the first fournisseur input
            let firstSupplierInput = document.getElementById('nom_fournisseur_0');
            let fournisseurValue = firstSupplierInput ? firstSupplierInput.value : '';

            let html = `<div class="facture-item card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h6 class="mb-0">Article #${i+1}</h6>
            <button type="button" class="btn btn-sm btn-danger remove-item" onclick="removeFacture(this)">
                <i class="fas fa-trash"></i> Supprimer
            </button>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Hidden input for fournisseur in added rows -->
                <input type="hidden" id="nom_fournisseur_${i}" name="factures[${i}][nom_de_fournisseur]" value="${fournisseurValue}">
                <div class="col-md-6 d-none">
                    <label for="nom_fournisseur_${i}" class="form-label">Nom de fournisseur</label>
                    <input type="text" class="form-control" id="nom_fournisseur_${i}_visible" name="factures[${i}][nom_de_fournisseur]_visible" value="${fournisseurValue}">
                </div>
                <div class="col-md-6">
                    <label for="date_${i}" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date_${i}" name="factures[${i}][date]" required>
                </div>
                <div class="col-12">
                    <label for="designation_${i}" class="form-label">Désignation</label>
                    <input type="text" class="form-control" id="designation_${i}" name="factures[${i}][designation]" required>
                </div>
                <div class="col-md-3">
                    <label for="prix_unite_${i}" class="form-label">PRIX UNITÉ (€)</label>
                    <input type="number" step="0.01" class="form-control" id="prix_unite_${i}" name="factures[${i}][prix_unite]" required oninput="updateLine(${i})">
                </div>
                <div class="col-md-2">
                    <label for="qte_${i}" class="form-label">Quantité</label>
                    <input type="number" class="form-control" id="qte_${i}" name="factures[${i}][qte]" required oninput="updateLine(${i})">
                </div>
                <div class="col-md-2">
                    <label for="tva_${i}" class="form-label">TVA (%)</label>
                    <input type="number" step="0.01" class="form-control" id="tva_${i}" name="factures[${i}][tva]" required oninput="updateLine(${i})">
                </div>
                <div class="col-md-2">
                    <label for="prix_ht_${i}" class="form-label">PRIX HT (€)</label>
                    <input type="number" step="0.01" class="form-control bg-light" id="prix_ht_${i}" name="factures[${i}][prix_ht]" readonly>
                </div>
                <div class="col-md-3">
                    <label for="prix_ttc_${i}" class="form-label">PRIX TTC (€)</label>
                    <input type="number" step="0.01" class="form-control bg-light" id="prix_ttc_${i}" name="factures[${i}][prix_ttc]" readonly>
                </div>
            </div>
        </div>
    </div>`;

            document.getElementById('facture-group').insertAdjacentHTML('beforeend', html);

            if (i === 1) {
                document.querySelector('.facture-item .remove-item').classList.remove('d-none');
            }
            i++;
        }



        function removeFacture(button) {
            const item = button.closest('.facture-item');
            item.remove();
            updateTotals();
            renumberItems();
        }

        function renumberItems() {
            const items = document.getElementsByClassName('facture-item');
            for (let idx = 0; idx < items.length; idx++) {
                const header = items[idx].querySelector('.card-header h6');
                header.textContent = `Article #${idx + 1}`;

                // Hide remove button if only one item remains
                if (items.length === 1) {
                    items[idx].querySelector('.remove-item').classList.add('d-none');
                } else {
                    items[idx].querySelector('.remove-item').classList.remove('d-none');
                }
            }
        }

        function updateLine(index) {
            const container = document.getElementsByClassName('facture-item')[index];
            if (!container) return;

            const prixUniteInput = container.querySelector(`input[name='factures[${index}][prix_unite]']`);
            const qteInput = container.querySelector(`input[name='factures[${index}][qte]']`);
            const tvaInput = container.querySelector(`input[name='factures[${index}][tva]']`);
            const prixHtInput = container.querySelector(`input[name='factures[${index}][prix_ht]']`);
            const prixTtcInput = container.querySelector(`input[name='factures[${index}][prix_ttc]']`);

            const prixUnite = parseFloat(prixUniteInput.value) || 0;
            const qte = parseInt(qteInput.value) || 0;
            const tva = parseFloat(tvaInput.value) || 0;

            const prixHt = prixUnite * qte;
            const prixTtc = prixHt * (1 + tva / 100);

            prixHtInput.value = prixHt.toFixed(2);
            prixTtcInput.value = prixTtc.toFixed(2);

            updateTotals();
        }

        function updateTotals() {
            let totalHt = 0;
            let totalTtc = 0;

            const items = document.getElementsByClassName('facture-item');
            for (let idx = 0; idx < items.length; idx++) {
                const container = items[idx];
                const prixHtInput = container.querySelector(`input[name='factures[${idx}][prix_ht]']`);
                const prixTtcInput = container.querySelector(`input[name='factures[${idx}][prix_ttc]']`);

                const prixHt = parseFloat(prixHtInput.value) || 0;
                const prixTtc = parseFloat(prixTtcInput.value) || 0;

                totalHt += prixHt;
                totalTtc += prixTtc;
            }

            const totalTva = totalTtc - totalHt;

            document.getElementById('total-ht').innerText = totalHt.toFixed(2) + ' €';
            document.getElementById('total-tva').innerText = totalTva.toFixed(2) + ' €';
            document.getElementById('total-ttc').innerText = totalTtc.toFixed(2) + ' €';
        }

        // Initialize date field with today's date
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date_0').value = today;
        });
    </script>

    <style>
        .facture-item {
            transition: all 0.3s ease;
        }

        .facture-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>

    <!-- Include Font Awesome for icons -->
@endsection
