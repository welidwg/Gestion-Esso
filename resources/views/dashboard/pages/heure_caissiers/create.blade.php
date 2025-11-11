{{-- resources/views/heure_caissiers/create.blade.php --}}

@extends('dashboard/base')
@section('Ajouter des Heures')
    Heures des Caissiers
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Ajouter des Heures Mensuelles</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('heure-caissiers.store') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="form-group mb-3">
                                <label for="month_year" class="form-label">Mois et Année</label>
                                <input type="month" name="month_year" id="month_year"
                                    class="form-control @error('month_year') is-invalid @enderror"
                                    value="{{ old('month_year', now()->format('Y-m')) }}" required>
                                @error('month_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="total_hours" class="form-label">Total Heures</label>
                                <input type="number" name="total_hours" id="total_hours" step="0.01" min="0"
                                    max="744" class="form-control @error('total_hours') is-invalid @enderror"
                                    value="{{ old('total_hours') }}" placeholder="Ex: 160.00" required>
                                @error('total_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Entrez le nombre total d'heures travaillées pour le mois (max: 744h).
                                </small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('heure-caissiers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
