@extends('dashboard/base')

@section('title', 'Articles des Factures')

@section('content')
<div class="container py-4">
    <h2>Articles</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('articlefacture.create') }}" class="btn btn-primary mb-3">Ajouter un Article</a>

    @if($articles->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Designation</th>
                <th>Prix Unité (€)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td>{{ $article->designation }}</td>
                <td>{{ $article->prix_unite !== null ? number_format($article->prix_unite, 2) : '-' }}</td>
                <td>
                    <a href="{{ route('articlefacture.edit', $article->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('articlefacture.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $articles->links() }}

    @else
    <p>Aucun article enregistré.</p>
    @endif
</div>
@endsection
