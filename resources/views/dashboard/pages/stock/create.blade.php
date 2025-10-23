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
                                    <input type="datetime-local" class="form-control form-control-lg" id="date"
                                        name="date_stock" value="{{ date('Y-m-d') }}" required>
                                    <div class="form-text">Sélectionnez la date correspondante au stock</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary mb-0">
                                    <i class="fas fa-list me-2"></i>Sélection des carburants
                                </h5>
                            </div>

                            <!-- Checkbox list for carburants -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row" id="carburants-checkbox-group">
                                        @foreach ($carburants as $carburant)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input carburant-checkbox" type="checkbox"
                                                        value="{{ $carburant->titre }}" id="carburant-{{ $carburant->id }}"
                                                        onchange="toggleCarburantRow(this)">
                                                    <label class="form-check-label fw-medium"
                                                        for="carburant-{{ $carburant->id }}">
                                                        {{ $carburant->titre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic rows for selected carburants -->
                            <div class="mb-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-edit me-2"></i>Stocks à saisir
                                </h6>
                                <div id="stocks-group" class="mb-4">
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Cochez les carburants pour lesquels vous souhaitez saisir le
                                            stock.</p>
                                    </div>
                                </div>
                            </div>

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
        const activeRows = new Map(); // Map to track active rows by carburant name

        function toggleCarburantRow(checkbox) {
            const carburantName = checkbox.value;
            const isChecked = checkbox.checked;

            if (isChecked) {
                // Add row for this carburant
                addStockRow(carburantName);
            } else {
                // Remove row for this carburant
                removeStockRow(carburantName);
            }
            updateEmptyState();
        }

        function addStockRow(carburantName) {
            if (activeRows.has(carburantName)) {
                return; // Row already exists
            }

            const html = `
                <div class="card stock-item mb-3" data-carburant="${carburantName}" data-index="${stockIndex}">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Type de carburant</label>
                                <input type="text" class="form-control bg-light" value="${carburantName}" readonly>
                                <input type="hidden" name="stocks[${stockIndex}][carburant]" value="${carburantName}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Stock réel (L)</label>
                                <input type="number" step="0.01" min="0" class="form-control stock-input" 
                                       name="stocks[${stockIndex}][stock_reel]" required placeholder="0.00">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-danger w-100" 
                                        onclick="removeStockByButton('${carburantName}')"
                                        title="Retirer ce carburant">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('stocks-group').insertAdjacentHTML('beforeend', html);
            activeRows.set(carburantName, stockIndex);
            stockIndex++;
        }

        function removeStockRow(carburantName) {
            const row = document.querySelector(`.stock-item[data-carburant="${carburantName}"]`);
            if (row) {
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    activeRows.delete(carburantName);
                    // Uncheck the corresponding checkbox
                    const checkbox = document.querySelector(`.carburant-checkbox[value="${carburantName}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                }, 300);
            }
        }

        function removeStockByButton(carburantName) {
            removeStockRow(carburantName);
            updateEmptyState();
        }

        function updateEmptyState() {
            const stocksGroup = document.getElementById('stocks-group');
            const hasStocks = stocksGroup.querySelectorAll('.stock-item').length > 0;

            if (!hasStocks) {
                stocksGroup.innerHTML = `
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p class="mb-0">Cochez les carburants pour lesquels vous souhaitez saisir le stock.</p>
                    </div>
                `;
            }
        }

        function validateForm() {
            const hasStocks = document.querySelectorAll('.stock-item').length > 0;
            if (!hasStocks) {
                alert('Veuillez sélectionner au moins un carburant.');
                return false;
            }

            // Validate that all stock inputs have values
            const emptyInputs = document.querySelectorAll('.stock-input:invalid');
            if (emptyInputs.length > 0) {
                alert('Veuillez remplir tous les champs de stock.');
                return false;
            }

            return true;
        }

        // Set today's date as default
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('date').value = new Date().toISOString().split('T')[0];

            // Add form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <style>
        .stock-item {
            transition: all 0.3s ease;
            border-left: 4px solid #28a745;
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

        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .carburant-checkbox-group {
            max-height: 200px;
            overflow-y: auto;
        }

        .bg-light[readonly] {
            background-color: #f8f9fa !important;
            border-color: #e9ecef;
        }
    </style>
@endsection
