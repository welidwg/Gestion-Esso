{{-- resources/views/heure_caissiers/index.blade.php --}}

@extends('dashboard/base')
@section('title')
    Heures des Caissiers
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        @if (Auth::user()->role == 0)
                            <h4>Heures Mensuelles des Caissiers</h4>
                        @else
                            <h4>Vos Heures Mensuelles</h4>
                        @endif
                        @if (Auth::user()->role == 1)
                            <a href="{{ route('heure-caissiers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajouter des Heures
                            </a>
                        @endif

                    </div>
                    <div class="card-body">
                        <!-- Month Filter -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <form method="GET" action="{{ route('heure-caissiers.index') }}">
                                    <div class="input-group">
                                        <input type="month" name="month" class="form-control"
                                            value="{{ $selectedMonth }}" onchange="this.form.submit()">
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        @if (Auth::user()->role == 0)
                                            <th>Utilisateur</th>
                                        @endif

                                        <th>Mois</th>
                                        <th>Total Heures</th>
                                        <th>Date d'ajout</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($heures as $heure)
                                        <tr>
                                            @if (Auth::user()->role == 0)
                                                <td>{{ $heure->user->login }}</td>
                                            @endif
                                            <td>{{ $heure->date_hours->format('F Y') }}</td>
                                            <td><strong>{{ number_format($heure->total_hours, 2) }}h</strong></td>
                                            <td>{{ $heure->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Aucune heure enregistrée pour ce mois.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($heures->isNotEmpty())
                                    <tfoot>
                                        <tr class="table-primary">
                                            <td><strong>Total</strong></td>
                                            <td></td>
                                            <td><strong>{{ number_format($heures->sum('total_hours'), 2) }}h</strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
