@extends('dashboard/base')

@section('title', 'Stock Carburant')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-primary">
                <i class="fas fa-gas-pump me-2"></i>Stock Carburant
            </h2>
            <a href="{{ route('stockcarburant.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Ajouter Stock
            </a>
        </div>

        @if ($stocks->count())
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list me-2"></i>Historique des stocks
                            </h5>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="badge bg-primary fs-6">Total: {{ $stocks->total() }} enregistrements</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-dark border-0">
                                        <i class="fas fa-calendar me-2"></i>Date
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-dark border-0">
                                        <i class="fas fa-gas-pump me-2"></i>Carburant
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-dark border-0">
                                        <i class="fas fa-database me-2"></i>Stock Réel
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentDate = null;
                                @endphp
                                @foreach ($stocks as $stock)
                                    @php
                                        $stockDate = \Carbon\Carbon::parse($stock->date_stock)->format('d/m/Y');
                                        $isNewDate = $currentDate !== $stockDate;
                                        $currentDate = $stockDate;
                                    @endphp

                                    @if ($isNewDate)
                                        {{-- Date Header --}}
                                        <tr class="date-header bg-light">
                                            <td colspan="3" class="px-4 py-3 border-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-alt text-primary me-2 fs-5"></i>
                                                        <h6 class="mb-0 fw-bold text-primary">{{ $stockDate }}</h6>
                                                    </div>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                                        {{ $stocks->where('date_stock', $stock->date_stock)->count() }}
                                                        carburants
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif

                                    {{-- Stock Row --}}
                                    <tr class="border-bottom">
                                        <td class="px-4 py-3 fw-medium text-muted border-0">
                                            <div class="d-flex align-items-center ps-4">
                                                <i class="fas fa-clock text-muted me-2"></i>
                                                {{ \Carbon\Carbon::parse($stock->date_stock)->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <span
                                                class="badge bg-info bg-opacity-10 text-info fs-6 border border-info border-opacity-25">
                                                <i class="fas fa-fire me-1"></i>{{ $stock->carburant }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-chart-bar me-2 text-success"></i>
                                                {{ number_format($stock->stock_reel, 2) }} L
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Affichage de <strong>{{ $stocks->firstItem() }}</strong> à
                                <strong>{{ $stocks->lastItem() }}</strong>
                                sur <strong>{{ $stocks->total() }}</strong> résultats
                            </div>
                            <div>
                                {{ $stocks->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-gas-pump fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">Aucun stock enregistré</h4>
                        <p class="text-muted mb-4">Vous n'avez pas encore de stocks de carburant enregistrés.</p>
                        <a href="{{ route('stockcarburant.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Ajouter votre premier stock
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .table> :not(caption)>*>* {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .badge.bg-info {
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .empty-state {
            max-width: 400px;
            margin: 0 auto;
        }

        .card {
            border-radius: 12px;
        }

        .table {
            margin-bottom: 0;
        }

        .card-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .date-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #007bff;
        }

        .date-header td {
            border-top: 2px solid #dee2e6 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .date-header+tr {
            border-top: none !important;
        }

        .ps-4 {
            padding-left: 2rem !important;
        }

        .date-header h6 {
            font-size: 1.1rem;
        }
    </style>
@endsection
