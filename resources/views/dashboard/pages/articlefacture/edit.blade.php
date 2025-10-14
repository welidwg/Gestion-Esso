@extends('dashboard/base')

@section('title', 'Modifier Article')

@section('content')
    <div class="container py-4">
        <h2>Modifier l'article</h2>

        <form method="POST" action="{{ route('articlefacture.update', $articlefacture->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="designation" class="form-label">Désignation</label>
                <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation"
                    name="designation" value="{{ old('designation', $articlefacture->designation) }}" required>
                @error('designation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="prix_unite" class="form-label">Prix Unité (€)</label>
                <input type="number" step="0.01" class="form-control @error('prix_unite') is-invalid @enderror"
                    id="prix_unite" name="prix_unite" value="{{ old('prix_unite', $articlefacture->prix_unite) }}">
                @error('prix_unite')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('articlefacture.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
