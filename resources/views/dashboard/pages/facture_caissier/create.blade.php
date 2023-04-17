@extends('dashboard/base') @section('title')
    Mise à jour stock
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold"> Mise à jour stock</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('factureCaissier.store') }}"
                        id="add_factureCaissier_form">
                        @csrf

                        <div class="mb-">
                            <label class="form-label" for=""><strong>Cochez les carburants
                                    achetées</strong></label>
                        </div>
                        <div class="row d-flex justify-content-between mb-3 p-3">

                            @foreach ($carburants as $carb)
                                <div class="form-check col mb-2">
                                    <input class="form-check-input" type="checkbox" name="{{ $carb->titre }}_checked"
                                        id="{{ $carb->titre }}_checked">
                                    <label class="form-check-label" for="{{ $carb->titre }}_checked">
                                        {{ $carb->titre }}
                                    </label>
                                </div>
                                <script>
                                    $('#{{ $carb->titre }}_checked').on("change", () => {
                                        if ($('#{{ $carb->titre }}_checked').is(":checked")) {

                                            $(".container-rows").append(`
                                        <div class="row" id="row{{ $carb->titre }}" >
                                <div class="col-md-6">
                                    <div class="mb-3">

                                        <input class="form-control bg-light text-dark" type="text" required
                                            id="" placeholder="" required name="titre" value="{{ $carb->titre }}"
                                            readonly />
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="mb-3 ">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="0" placeholder="" required name="qte_{{ $carb->titre }}" />
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
                            <div class="col-md-6">
                                <div class="mb-">
                                    <label class="form-label" for=""><strong>Carburant</strong></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class=" ">
                                    <label class="form-label" for=""><strong>Quantité achetée</strong></label>

                                </div>
                            </div>
                        </div>
                        <div class="container-rows">

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
        <script src="{{ asset('/js/facture_caissier.js') }}"></script>
    </div>
@endsection
