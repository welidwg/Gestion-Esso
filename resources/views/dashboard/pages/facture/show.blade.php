@extends('dashboard/base') @section('title')
    Facture
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Détails de facture</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" id="">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="mb-3"><label class="form-label"
                                        for=""><strong>Reference</strong></label><input class="form-control"
                                        type="text" required id="" placeholder="" value='{{ $facture->ref }}'
                                        name=""></div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3"><label class="form-label" for=""><strong>Montant
                                            total</strong></label><input class="form-control" type="number" required
                                        id="" placeholder="" value='{{ $facture->montant }}' name=""></div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3"><label class="form-label" for=""><strong>Date de facture
                                        </strong></label><input class="form-control" type="date" required id=""
                                        placeholder="" value='{{ $facture->date_facture }}' name=""></div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="">
                                    <label class="form-label" for=""><strong>Carburant</strong></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="">
                                    <label class="form-label" for=""><strong>Prix d'achat (HT)</strong></label>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="">
                                    <label class="form-label" for=""><strong>Prix d'achat (TTC)</strong></label>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=" ">
                                    <label class="form-label" for=""><strong>Quantité achetée</strong></label>

                                </div>
                            </div>
                        </div>
                        @foreach ($carburants as $carb)
                            @php
                                $title = $carb->titre;
                                
                            @endphp
                            @if ($facture->$title != null)
                                @php
                                    $data = json_decode($facture->$title);
                                @endphp
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">

                                            <input class="form-control bg-light text-dark" type="text" required
                                                id="" placeholder="" name="titre" value="{{ $carb->titre }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 ">
                                            <input class="form-control text-dark " type="number" step="0.01" required
                                                id="" value="{{ $data[0]->prixAHT }}" placeholder=""
                                                name="prixA_{{ $carb->id }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 ">
                                            <input class="form-control text-dark " type="number" step="0.01" required
                                                id="" value="{{ $data[0]->prixATTC }}" placeholder=""
                                                name="prixA_{{ $carb->id }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 ">
                                            <input class="form-control text-dark " type="number" step="0.01" required
                                                id="" value="{{ $data[0]->qte }}" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        $('input').attr('readonly', true);
        $('input').addClass("bg-light shadow-none text-dark");
    </script>
@endsection
