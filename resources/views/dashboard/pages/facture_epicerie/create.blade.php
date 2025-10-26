@extends('dashboard/base')

@section('title', 'Ajouter Facture Epicerie')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">
                            <i class="fas fa-file-invoice me-2"></i>Nouvelle Facture Epicerie
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('factureepicerie.store') }}" id="facture-form">
                            @csrf

                            <!-- Fournisseur et Date -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nom_de_fournisseur" class="form-label fw-semibold">
                                        <i class="fas fa-building me-2"></i>Nom du fournisseur
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="nom_de_fournisseur"
                                        name="nom_de_fournisseur" required placeholder="Entrez le nom du fournisseur">
                                </div>
                                <div class="col-md-6">
                                    <label for="date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar me-2"></i>Date de facturation
                                    </label>
                                    <input type="date" class="form-control form-control-lg" id="date" name="date"
                                        required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <!-- Articles Section -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary mb-0">
                                    <i class="fas fa-cubes me-2"></i>Articles
                                </h5>
                                <button type="button" class="btn btn-success btn-sm" onclick="addArticle()">
                                    <i class="fas fa-plus me-1"></i>Ajouter un article
                                </button>
                            </div>

                            <div id="articles-group">
                                <div class="card article-item mb-3 border-primary">
                                    <div class="card-header bg-light py-2">
                                        <small class="text-muted">Article #1</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Désignation</label>
                                                <select class="form-select article-designation" id="designation_0"
                                                    name="articles[0][designation]" required
                                                    onchange="onDesignationChange(0)">
                                                    <option value="" disabled selected>Choisir un article</option>
                                                    @foreach ($articles as $article)
                                                        <option value="{{ $article->designation }}"
                                                            data-prix="{{ $article->prix_unite }}"
                                                            data-tva="{{ $article->tva }}">
                                                            {{ $article->designation }} -
                                                            {{ number_format($article->prix_unite, 2) }}€
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold">Prix Unité (€)</label>
                                                <input type="number" step="0.01" class="form-control bg-light"
                                                    id="prix_unite_0" name="articles[0][prix_unite]" required
                                                    oninput="updateArticleLine(0)" placeholder="0.00" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold">Quantité</label>
                                                <input type="number" class="form-control" id="qte_0"
                                                    name="articles[0][qte]" required oninput="updateArticleLine(0)"
                                                    placeholder="0" min="1" value="1">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold">TVA (%)</label>
                                                <input type="number" step="0.01" class="form-control bg-light" readonly
                                                    id="tva_0" name="articles[0][tva]" required
                                                    oninput="updateArticleLine(0)">
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-outline-danger w-100"
                                                    onclick="removeArticle(this)" title="Supprimer cet article">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Prix HT (€)</label>
                                                <input type="number" step="0.01"
                                                    class="form-control bg-success bg-opacity-10 border-success"
                                                    id="prix_ht_0" name="articles[0][prix_ht]" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Prix TTC (€)</label>
                                                <input type="number" step="0.01"
                                                    class="form-control bg-primary bg-opacity-10 border-primary"
                                                    id="prix_ttc_0" name="articles[0][prix_ttc]" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary Cards -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card border-success border-2">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-muted mb-2">TOTAL HT</h6>
                                            <h3 class="text-success mb-0" id="total-ht">0.00 €</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-info border-2">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-muted mb-2">TOTAL TVA</h6>
                                            <h3 class="text-info mb-0" id="total-tva">0.00 €</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-primary border-2">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-muted mb-2">TOTAL TTC</h6>
                                            <h3 class="text-primary mb-0" id="total-ttc">0.00 €</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <a href="{{ route('factureepicerie.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Enregistrer la facture
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const articlePrices = @json($articles->mapWithKeys(fn($a) => [$a->designation => (float) $a->prix_unite]));
        const articleTva = @json($articles->mapWithKeys(fn($a) => [$a->designation => (float) $a->tva]));

        let articleIndex = 1;

        function addArticle() {
            let designationOptions = '<option value="" disabled selected>Choisir un article</option>';
            Object.keys(articlePrices).forEach(designation => {
                designationOptions +=
                    `<option value="${designation}" data-prix="${articlePrices[designation]}" data-tva="${articleTva[designation]}">${designation} - ${articlePrices[designation].toFixed(2)}€</option>`;
            });

            let html = `
            <div class="card article-item mb-3 border-primary">
                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Article #${articleIndex + 1}</small>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeArticle(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Désignation</label>
                            <select class="form-select article-designation" id="designation_${articleIndex}" 
                                    name="articles[${articleIndex}][designation]" required onchange="onDesignationChange(${articleIndex})">
                                ${designationOptions}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Prix Unité (€)</label>
                            <input type="number" step="0.01" class="form-control bg-light" 
                                   id="prix_unite_${articleIndex}" name="articles[${articleIndex}][prix_unite]" required 
                                   oninput="updateArticleLine(${articleIndex})" placeholder="0.00" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Quantité</label>
                            <input type="number" class="form-control" id="qte_${articleIndex}" 
                                   name="articles[${articleIndex}][qte]" required oninput="updateArticleLine(${articleIndex})" 
                                   placeholder="0" min="1" value="1">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">TVA (%)</label>
                            <input type="number" step="0.01" class="form-control bg-light" readonly 
                                   id="tva_${articleIndex}" name="articles[${articleIndex}][tva]" required 
                                   oninput="updateArticleLine(${articleIndex})">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger w-100" 
                                    onclick="removeArticle(this)" title="Supprimer cet article">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Prix HT (€)</label>
                            <input type="number" step="0.01" class="form-control bg-success bg-opacity-10 border-success" 
                                   id="prix_ht_${articleIndex}" name="articles[${articleIndex}][prix_ht]" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Prix TTC (€)</label>
                            <input type="number" step="0.01" class="form-control bg-primary bg-opacity-10 border-primary" 
                                   id="prix_ttc_${articleIndex}" name="articles[${articleIndex}][prix_ttc]" readonly>
                        </div>
                    </div>
                </div>
            </div>`;

            document.getElementById('articles-group').insertAdjacentHTML('beforeend', html);

            // Initialize Select2 for new select
            $(`#designation_${articleIndex}`).select2({
                placeholder: 'Choisir un article',
                width: '100%',
                theme: 'bootstrap-5'
            });

            articleIndex++;
        }

        function onDesignationChange(index) {
            const select = $(`#designation_${index}`);
            const selectedOption = select.find('option:selected');
            const prixUniteInput = document.getElementById(`prix_unite_${index}`);
            const tvaInput = document.getElementById(`tva_${index}`);

            const price = parseFloat(selectedOption.data('prix')) || 0;
            const tva = parseFloat(selectedOption.data('tva')) || 0;

            prixUniteInput.value = price.toFixed(2);
            tvaInput.value = tva.toFixed(1);
            updateArticleLine(index);
        }

        function removeArticle(button) {
            const articleItem = button.closest('.article-item');
            articleItem.style.opacity = '0';
            setTimeout(() => {
                articleItem.remove();
                updateTotals();
                updateArticleNumbers();
            }, 300);
        }

        function updateArticleNumbers() {
            document.querySelectorAll('.article-item').forEach((item, index) => {
                const header = item.querySelector('.card-header small');
                if (header) {
                    header.textContent = `Article #${index + 1}`;
                }
            });
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

        // Initialize Select2 for first element
        $(document).ready(function() {
            $('.article-designation').select2({
                placeholder: 'Choisir un article',
                width: '100%',
                theme: 'bootstrap-5'
            });
        });
    </script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .card {
            border-radius: 12px;
        }

        .article-item {
            transition: all 0.3s ease;
            border-left: 4px solid #0d6efd;
        }

        .article-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .select2-container--bootstrap-5 .select2-selection {
            min-height: 48px;
            display: flex;
            align-items: center;
        }

        .bg-opacity-10 {
            background-color: rgba(var(--bs-success-rgb), 0.1) !important;
        }

        .border-2 {
            border-width: 2px !important;
        }
    </style>
@endsection
