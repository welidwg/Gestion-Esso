@extends('dashboard/base')

@section('title', 'Ajouter Stock Carburant')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-gas-pump me-2"></i>Ajouter Stock Carburant</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('stockcarburant.store') }}">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="date" class="form-label fw-semibold">Date du stock</label>
                                    <input type="date" class="form-control form-control-lg" id="date"
                                        name="date_stock" value="{{ date('Y-m-d') }}" required>
                                    <div class="form-text">Sélectionnez la date correspondante au stock</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary mb-0">
                                    <i class="fas fa-list me-2"></i>Stocks
                                </h5>
                                <button type="button" class="btn btn-success btn-sm" onclick="addStock()">
                                    <i class="fas fa-plus me-1"></i>Ajouter un carburant
                                </button>
                            </div>

                            <div id="stocks-group" class="mb-4"></div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const carburants = @json(
            $carburants->map(function ($c) {
                return ['id' => $c->id, 'titre' => $c->titre];
            }));

        let stockIndex = 0;
        let selectedCarburantIds = [];

        function getAvailableOptions() {
            return carburants
                .filter(c => !selectedCarburantIds.includes(c.titre))
                .map(c => `<option value="${c.titre}">${c.titre}</option>`)
                .join('');
        }

        function addStock() {
            if (carburants.length === selectedCarburantIds.length) {
                showAlert("Tous les carburants disponibles ont déjà été ajoutés.", "warning");
                return;
            }

            let availableOptions = getAvailableOptions();
            let html = `
        <div class="card stock-item mb-3" data-index="${stockIndex}">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Type de carburant</label>
                        <select name="stocks[${stockIndex}][carburant]" class="form-select select-carburant" required>
                            <option value="">Choisir un carburant...</option>
                            ${availableOptions}
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Stock réel (L)</label>
                        <input type="number" step="0.01" min="0" class="form-control" 
                               name="stocks[${stockIndex}][stock_reel]" required placeholder="0.00">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger w-100" onclick="removeStock(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;

            document.getElementById('stocks-group').insertAdjacentHTML('beforeend', html);
            stockIndex++;
            refreshSelectListeners();
            updateEmptyState();
        }

        function removeStock(button) {
            let card = button.closest('.stock-item');
            let select = card.querySelector('.select-carburant');
            let oldValue = select.value;

            card.style.opacity = '0';
            setTimeout(() => {
                card.remove();
                if (oldValue) {
                    selectedCarburantIds = selectedCarburantIds.filter(titre => titre != oldValue);
                    updateAllSelectOptions();
                }
                updateEmptyState();
            }, 300);
        }

        function refreshSelectListeners() {
            document.querySelectorAll('.select-carburant').forEach(select => {
                select.removeEventListener('change', onCarburantChange);
                select.addEventListener('change', onCarburantChange);
            });
        }

        function onCarburantChange(e) {
            let select = e.target;
            let newValue = select.value;
            let row = select.closest('.stock-item');

            // Remove old selection from list
            let oldValue = select.oldValue;
            if (oldValue) {
                selectedCarburantIds = selectedCarburantIds.filter(titre => titre != oldValue);
            }
            if (newValue) {
                selectedCarburantIds.push(newValue);
            }
            select.oldValue = newValue;

            updateAllSelectOptions();
        }

        function updateAllSelectOptions() {
            let allSelects = document.querySelectorAll('.select-carburant');
            allSelects.forEach(select => {
                let selected = select.value;
                let options = carburants
                    .filter(c => selectedCarburantIds.includes(c.titre) ? c.titre === selected : true)
                    .map(c =>
                        `<option value="${c.titre}"${selected === c.titre ? ' selected' : ''}>${c.titre}</option>`)
                    .join('');
                select.innerHTML = `<option value="">Choisir un carburant...</option>${options}`;
            });
        }

        function updateEmptyState() {
            const stocksGroup = document.getElementById('stocks-group');
            if (stocksGroup.children.length === 0) {
                stocksGroup.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mb-0">Aucun carburant ajouté. Cliquez sur "Ajouter un carburant" pour commencer.</p>
                </div>
            `;
            }
        }

        function showAlert(message, type = 'info') {
            // Simple alert implementation - you can replace with a toast library
            alert(message);
        }

        // On page load, add one initial input row
        document.addEventListener('DOMContentLoaded', function() {
            addStock();
            // Set today's date as default
            document.getElementById('date').value = new Date().toISOString().split('T')[0];
        });
    </script>

    <style>
        .stock-item {
            transition: all 0.3s ease;
            border-left: 4px solid #007bff;
        }

        .stock-item:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-danger:hover {
            transform: scale(1.05);
        }

        .card-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }
    </style>
@endsection
