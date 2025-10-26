@extends('dashboard/base')

@section('title', 'Ajouter Facture Epicerie')

@section('content')
    <div class="container py-4">
        <h2>Ajouter Facture Epicerie</h2>

        <form method="POST" action="{{ route('factureepicerie.store') }}" id="facture-form">
            @csrf
            <div class="mb-3">
                <label for="nom_de_fournisseur" class="form-label">Nom de fournisseur</label>
                <input type="text" class="form-control" id="nom_de_fournisseur" name="nom_de_fournisseur" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required
                    value="{{ date('Y-m-d') }}">
            </div>

            <h4>Articles</h4>
            <div id="articles-group">
                <div class="article-item border p-3 mb-3">
                    <div class="mb-3">
                        <label for="designation_0" class="form-label">Désignation</label>
                        <select class="form-select" id="designation_0" name="articles[0][designation]" required
                            onchange="onDesignationChange(0)">
                            <option value="" disabled selected>Choisir un article</option>
                            @foreach ($articles as $article)
                                <option value="{{ $article->designation }}">{{ $article->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="prix_unite_0" class="form-label">Prix Unité (€)</label>
                            <input type="number" step="0.01" class="form-control bg-light" id="prix_unite_0"
                                name="articles[0][prix_unite]" required oninput="updateArticleLine(0)" placeholder="0.00"
                                readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="qte_0" class="form-label">Quantité</label>
                            <input type="number" class="form-control " id="qte_0" name="articles[0][qte]" required
                                oninput="updateArticleLine(0)" placeholder="0" min="1">
                        </div>
                        <div class="col-md-2">
                            <label for="prix_ht_0" class="form-label">Prix HT (€)</label>
                            <input type="number" step="0.01" class="form-control bg-light" id="prix_ht_0"
                                name="articles[0][prix_ht]" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="tva_0" class="form-label">TVA (%)</label>
                            <input type="number" step="0.01" class="form-control bg-light" id="tva_0" readonly
                                name="articles[0][tva]" required oninput="updateArticleLine(0)" value="20">
                        </div>
                        <div class="col-md-2">
                            <label for="prix_ttc_0" class="form-label">Prix TTC (€)</label>
                            <input type="number" step="0.01" class="form-control bg-light" id="prix_ttc_0"
                                name="articles[0][prix_ttc]" readonly>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger w-100"
                                onclick="removeArticle(this)">Supprimer</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-3" onclick="addArticle()">
                <i class="fas fa-plus"></i> Ajouter un article
            </button>

            <div class="border p-3">
                <h5>Récapitulatif</h5>
                <div class="row text-center">
                    <div class="col-md-4">
                        <h4 id="total-ht">0.00 €</h4>
                        <strong>TOTAL HT (€)</strong>
                    </div>
                    <div class="col-md-4">
                        <h4 id="total-tva">0.00 €</h4>
                        <strong>TOTAL TVA (€)</strong>
                    </div>
                    <div class="col-md-4">
                        <h4 id="total-ttc">0.00 €</h4>
                        <strong>TOTAL TTC (€)</strong>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
        </form>
    </div>

    <script>
        const articlePrices = @json($articles->mapWithKeys(fn($a) => [$a->designation => (float) $a->prix_unite]));
        const articleTva = @json($articles->mapWithKeys(fn($a) => [$a->designation => (float) $a->tva]));

        let articleIndex = 1;

        function addArticle() {
            let designationOptions = '<option value="" disabled selected>Choisir un article</option>';
            Object.keys(articlePrices).forEach(designation => {
                designationOptions += `<option value="${designation}">${designation}</option>`;
            });

            let html = `
            <div class="article-item border p-3 mb-3">
                <div class="mb-3">
                    <label for="designation_${articleIndex}" class="form-label">Désignation</label>
                    <select class="form-select" id="designation_${articleIndex}" name="articles[${articleIndex}][designation]" required onchange="onDesignationChange(${articleIndex})">
                        ${designationOptions}
                    </select>
                </div>
                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="prix_unite_${articleIndex}" class="form-label">Prix Unité (€)</label>
                        <input type="number" step="0.01" class="form-control bg-light" id="prix_unite_${articleIndex}" name="articles[${articleIndex}][prix_unite]" required oninput="updateArticleLine(${articleIndex})" placeholder="0.00" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="qte_${articleIndex}" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="qte_${articleIndex}" name="articles[${articleIndex}][qte]" required oninput="updateArticleLine(${articleIndex})" placeholder="0" min="1">
                    </div>
                    <div class="col-md-2">
                        <label for="prix_ht_${articleIndex}" class="form-label">Prix HT (€)</label>
                        <input type="number" step="0.01" class="form-control bg-light" id="prix_ht_${articleIndex}" name="articles[${articleIndex}][prix_ht]" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="tva_${articleIndex}" class="form-label">TVA (%)</label>
                        <input type="number" step="0.01" class="form-control bg-light " readonly id="tva_${articleIndex}" name="articles[${articleIndex}][tva]" required oninput="updateArticleLine(${articleIndex})" value="20">
                    </div>
                    <div class="col-md-2">
                        <label for="prix_ttc_${articleIndex}" class="form-label">Prix TTC (€)</label>
                        <input type="number" step="0.01" class="form-control bg-light" id="prix_ttc_${articleIndex}" name="articles[${articleIndex}][prix_ttc]" >
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger w-100" onclick="removeArticle(this)">Supprimer</button>
                    </div>
                </div>
            </div>`;

            document.getElementById('articles-group').insertAdjacentHTML('beforeend', html);
            $(`#designation_${articleIndex}`).select2({
                placeholder: 'Choisir un article',
                width: '100%'
            });
            articleIndex++;
        }

        function onDesignationChange(index) {
            const select = document.getElementById(`designation_${index}`);
            const prixUniteInput = document.getElementById(`prix_unite_${index}`);
            const tvaInput = document.getElementById(`tva_${index}`);
            const selectedDesignation = select.value;

            const price = articlePrices[selectedDesignation] ?? 0;
            const tva = articleTva[selectedDesignation] ?? 0;
            prixUniteInput.value = price.toFixed(2);
            tvaInput.value = tva.toFixed(1);
            updateArticleLine(index);
        }

        function removeArticle(button) {
            button.closest('.article-item').remove();
            updateTotals();
        }

        function updateArticleLine(index) {
            const prixUnite = parseFloat(document.getElementById(`prix_unite_${index}`).value) || 0;
            const qte = parseInt(document.getElementById(`qte_${index}`).value) || 0;
            const tva = parseFloat(document.getElementById(`tva_${index}`).value) || 0;

            const prixHt = prixUnite * qte;
            const prixTtc = prixHt * (1 + tva / 100);

            document.getElementById(`prix_ht_${index}`).value = prixHt.toFixed(2);
            document.getElementById(`prix_ttc_${index}`).value = prixTtc.toFixed(2);

            updateTotals();
        }

        function updateTotals() {
            let totalHt = 0;
            let totalTtc = 0;

            document.querySelectorAll('.article-item').forEach(item => {
                const prixHt = parseFloat(item.querySelector('input[name$="[prix_ht]"]').value) || 0;
                const prixTtc = parseFloat(item.querySelector('input[name$="[prix_ttc]"]').value) || 0;
                totalHt += prixHt;
                totalTtc += prixTtc;
            });

            const totalTva = totalTtc - totalHt;

            document.getElementById('total-ht').innerText = totalHt.toFixed(2) + ' €';
            document.getElementById('total-tva').innerText = totalTva.toFixed(2) + ' €';
            document.getElementById('total-ttc').innerText = totalTtc.toFixed(2) + ' €';
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#designation_0').select2({
                placeholder: 'Choisir un article',
                width: '100%'
            });
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
