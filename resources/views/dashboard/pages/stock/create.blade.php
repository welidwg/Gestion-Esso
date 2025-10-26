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
                        <form method="POST" action="{{ route('stockcarburant.store') }}" id="stockForm">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="date" class="form-label fw-semibold">Date du stock</label>
                                    <input type="date" class="form-control form-control-lg" id="date"
                                        name="date_stock" value="{{ date('Y-m-d') }}" required>
                                    <div class="form-text">Sélectionnez la date correspondante au stock</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-list me-2"></i>Saisie des stocks
                                </h5>
                                @php

                                    $lists = [
                                        0 => 'Petrole',
                                        1 => 'EnergyDiesel',
                                        2 => 'Gas-Oil',
                                        3 => 'Super SP 95',
                                        4 => 'Euro SP 98',
                                        5 => 'GPL',
                                        6 => 'GNR',
                                    ];
                                @endphp

                                <!-- All carburants shown by default -->
                                <div id="stocks-group">
                                    @foreach ($lists as $index => $carburant)
                                        <div class="card stock-item mb-3" data-carburant="{{ $carburant }}">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-md-5">
                                                        <label class="form-label fw-semibold">Type de carburant</label>
                                                        <input type="text" class="form-control bg-light"
                                                            value="{{ $carburant }}" readonly>
                                                        <input type="hidden" name="stocks[{{ $index }}][carburant]"
                                                            value="{{ $carburant }}">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="form-label fw-semibold">Stock réel (L)</label>
                                                        <input type="number" step="0.01" min="0"
                                                            class="form-control stock-input"
                                                            name="stocks[{{ $index }}][stock_reel]" value="0"
                                                            required placeholder="0.00">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="text-muted text-center small">
                                                            <i class="fas fa-edit"></i><br>
                                                            Saisie requise
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Enregistrer tous les stocks
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            const stockInputs = document.querySelectorAll('.stock-input');
            let hasValidInput = false;

            // Check if at least one stock has a value > 0
            for (let input of stockInputs) {
                if (parseFloat(input.value) > 0) {
                    hasValidInput = true;
                    break;
                }
            }

            if (!hasValidInput) {
                alert('Veuillez saisir au moins un stock avec une valeur supérieure à 0.');
                return false;
            }

            return true;
        }

        // Highlight inputs when they have values
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('date').value = new Date().toISOString().split('T')[0];

            // Add form validation
            const form = document.getElementById('stockForm');
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });

            // Add visual feedback for inputs with values
            const stockInputs = document.querySelectorAll('.stock-input');
            stockInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const card = this.closest('.stock-item');
                    if (parseFloat(this.value) > 0) {
                        card.style.borderLeftColor = '#28a745';
                        card.classList.add('has-value');
                    } else {
                        card.style.borderLeftColor = '#6c757d';
                        card.classList.remove('has-value');
                    }
                });

                // Trigger initial state
                input.dispatchEvent(new Event('input'));
            });
        });
    </script>

    <style>
        .stock-item {
            transition: all 0.3s ease;
            border-left: 4px solid #6c757d;
        }

        .stock-item.has-value {
            border-left-color: #28a745;
            background-color: rgba(40, 167, 69, 0.02);
        }

        .stock-item:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .bg-light[readonly] {
            background-color: #f8f9fa !important;
            border-color: #e9ecef;
        }

        .stock-input:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .text-muted small {
            font-size: 0.75rem;
        }
    </style>
@endsection
