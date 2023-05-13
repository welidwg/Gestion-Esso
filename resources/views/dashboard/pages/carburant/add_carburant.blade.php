@extends('dashboard/base') @section('title')
    Ajouter Carburant
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Ajouter carburant</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('carburant.store') }}" id="add_carburant_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Titre</strong></label>
                                    <input class="form-control" type="text" required id="" placeholder=""
                                        name="titre" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Prix d'achat</strong></label><input
                                        class="form-control" type="number" step="0.01" required id="prixA"
                                        placeholder="" name="prixA" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Marge
                                            bénéficiere</strong></label><input class="form-control" type="number"
                                        step="0.01" id="marge_beneficiere" placeholder="" value="0"
                                        name="marge_beneficiere" />
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Prix du vente</strong></label><input
                                        class="form-control " type="number" step="0.01" required id="prixV"
                                        placeholder="" name="prixV" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Quantite stock</strong></label><input
                                        class="form-control" type="number" step="0.01" required id="qtiteStk"
                                        placeholder="" name="qtiteStk" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Quantite jauge</strong></label><input
                                        class="form-control" type="number" step="0.01" required id=""
                                        placeholder="" name="qtiteJg" />
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Seuil absolu</strong></label><input
                                        class="form-control" type="number" step="0.01" required id=""
                                        placeholder="" name="seuilA" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Valeur du stock</strong></label><input
                                        class="form-control bg-light shadow-none " type="number" step="0.01" required
                                        id="v_stock" placeholder="" name="valeur_stock" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 float-end">
                            <button class="btn btn-primary" type="submit">
                                Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('/js/carburant.js') }}"></script>
    @endsection
</div>
