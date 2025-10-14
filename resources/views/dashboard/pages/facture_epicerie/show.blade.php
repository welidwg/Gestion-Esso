@extends('dashboard/base')

@section('title', 'Détails de la Facture Epicerie')

@section('content')
    <div class="container py-4">
        <h2>Détails de la Facture #{{ $facture->id }}</h2>

        <div class="mb-3">
            <strong>Nom de fournisseur:</strong> {{ $facture->nom_de_fournisseur }}
        </div>
        <div class="mb-3">
            <strong>Date:</strong> {{ $facture->date->format('d/m/Y') }}
        </div>

        <h4>Articles</h4>
        @if (count($facture->articles))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Prix Unité (€)</th>
                        <th>Quantité</th>
                        <th>Prix HT (€)</th>
                        <th>TVA (%)</th>
                        <th>Prix TTC (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalHt = 0;
                        $totalTtc = 0;
                    @endphp

                    @foreach ($facture->articles as $article)
                        @php
                            $totalHt += $article['prix_ht'];
                            $totalTtc += $article['prix_ttc'];
                        @endphp
                        <tr>
                            <td>{{ $article['designation'] }}</td>
                            <td>{{ number_format($article['prix_unite'], 2) }}</td>
                            <td>{{ $article['qte'] }}</td>
                            <td>{{ number_format($article['prix_ht'], 2) }}</td>
                            <td>{{ number_format($article['tva'], 2) }}</td>
                            <td>{{ number_format($article['prix_ttc'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">TOTAL</th>
                        <th>{{ number_format($totalHt, 2) }} €</th>
                        <th>{{ number_format($totalTtc - $totalHt, 2) }} €</th>
                        <th>{{ number_format($totalTtc, 2) }} €</th>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>Aucun article présent dans cette facture.</p>
        @endif

        <a href="{{ route('factureepicerie.index') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
@endsection
