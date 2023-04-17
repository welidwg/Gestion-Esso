@extends('dashboard/base') @section('title')
    Ajouter facture
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Ajouter facture</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('facture.store') }}" id="add_facture_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Référence</strong></label>
                                    <input class="form-control" type="text" required id="" placeholder=""
                                        name="ref" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Montant total</strong> <a
                                            id="calculetotal"><i class="fas fa-calculator text-primary"
                                                style="cursor: pointer"></i></a></label><input class="form-control bg-light"
                                        type="number" step="0.01" value="0"
                                        max="{{ $montant != null ? $montant : 0 }}" min="1" required
                                        id="montant_facture" readonly placeholder="" name="montant" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Date du facture</strong></label><input
                                        class="form-control" type="date" required id="date_facture" placeholder=""
                                        name="date_facture" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label text-primary fw-bold" for=""><strong>Date d'arrivage du
                                            camion</strong>
                                        <a class="text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-html="true"
                                            title="<div className=''>Date à laquelle le caissier a entré les quantités achetées.</div>">
                                            <i class="far fa-info-circle"></i>
                                        </a>
                                    </label><input class="form-control" type="date" required id="date_arrivage"
                                        placeholder="" name="date_arrivage" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-">
                            <label class="form-label" for=""><strong>Cochez les carburants
                                    achetées</strong></label>
                        </div>
                        <div class="row d-flex justify-content-between mb-3 p-3">

                            @foreach ($carburants as $carb)
                                <div class="form-check col mb-2">
                                    <input class="form-check-input" type="checkbox" disabled
                                        name="{{ $carb->titre }}_checked" id="{{ $carb->titre }}_checked">
                                    <label class="form-check-label" for="{{ $carb->titre }}_checked">
                                        {{ $carb->titre }}
                                    </label>
                                </div>
                                <script>
                                    $('#{{ $carb->titre }}_checked').on("change", () => {
                                        if ($('#{{ $carb->titre }}_checked').is(":checked")) {

                                            $(".container-rows").append(`
                                        <div class="row" id="row{{ $carb->titre }}" required >
                                <div class="col-md-2">
                                    <div class="mb-3">

                                        <input class="form-control bg-light text-dark" type="text" required
                                            id="" placeholder="" name="titre" value="{{ $carb->titre }}"
                                            readonly required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3 ">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="0" placeholder="" required
                                            name="prixA_{{ $carb->id }}" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3 ">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="0" placeholder="" name="qte_{{ $carb->titre }}" />
                                    </div>
                                </div>
                            </div>
                                        `)
                                        } else {
                                            $("#row{{ $carb->titre }}").remove()

                                        }
                                    })
                                </script>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-">
                                    <label class="form-label" for=""><strong>Carburant</strong></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb- ">
                                    <label class="form-label" for=""><strong>Prix d'achat (HT) / 1000
                                            L</strong></label>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class=" ">
                                    <label class="form-label" for=""><strong>Quantité achetée</strong></label>

                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class=" ">
                                    <label class="form-label" for=""><strong>Prix unitaire H.T</strong></label>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class=" ">
                                    <label class="form-label" for=""><strong>Prix unitaire TTC</strong></label>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class=" ">
                                    <label class="form-label" for=""><strong>Montant TTC</strong></label>

                                </div>
                            </div>
                        </div>
                        <div class="container-rows">

                        </div>

                        <div class="caissier">

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
        <script src="{{ asset('/js/facture.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            });
        </script>
    </div>
@endsection
