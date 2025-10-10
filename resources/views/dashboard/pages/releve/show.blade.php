@extends('dashboard/base') @section('title')
    Journal caisse
@endsection
@section('content')
    @php
        $qte_cigars = 0;
    @endphp
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Journal caisse</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" id="edit_releve_form"
                        action="{{ route('releve.update', $releve->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-6 col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Heure
                                            début</strong></label><input class="form-control bg-light" type="time"
                                        required id="heure_d" placeholder="" value='{{ $releve->heure_d }}' readonly
                                        name="heure_d"></div>

                            </div>
                            <div class=" col-6 col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Heure
                                            fin</strong></label><input class="form-control bg-light" type="time" required
                                        value="{{ $releve->heure_f }}" id="heure_f" readonly placeholder=""
                                        name="heure_f"></div>
                            </div>
                            <div class=" col-6 col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Date
                                        </strong></label><input readonly class="form-control bg-light" type="text"
                                        required value="{{ date('d/m/Y', strtotime($releve->date_systeme)) }}"
                                        @if (Auth::user()->role == 0) readonly @endif id="date_systeme" placeholder=""
                                        name="date_systeme"></div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Caissier
                                        </strong></label><input readonly class="form-control bg-light" type="text"
                                        required value="{{ $releve->caissier->nom }}"
                                        @if (Auth::user()->role == 0) readonly @endif id="code" placeholder=""
                                        name="code"></div>
                            </div>
                            {{-- <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"> --}}
                        </div>

                        {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                Montants</strong></label>

                                    </div>
                                </div>

                            </div> --}}
                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold text-dark"><i class="fal fa-user text-success"></i> Les montants
                                    calculée </legend>
                                <div class="row">
                                    <div class=" col-6 col-md-2">
                                        <div class="mb-3"><label class="form-label" for=""><strong>
                                                    Espèce</strong></label><input class="form-control inputMontantCalcule"
                                                type="number" onload="F()" required id="espece" placeholder=""
                                                name="espece" step="0.01" min="0" value="{{ $releve->espece }}">
                                        </div>

                                    </div>
                                    <div class=" col-6 col-md-2">
                                        <div class="mb-3"><label class="form-label" for=""><strong>
                                                    Carte Bleu</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                step="0.01" id="carte_bleu" placeholder="" name="carte_bleu"
                                                min="0" value="{{ $releve->carte_bleu }}">


                                        </div>
                                    </div>
                                    <div class=" col-6 col-md-2">
                                        <div class="mb-3"><label class="form-label" for=""><strong>
                                                    Carte Pro</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="carte_pro" placeholder="" name="carte_pro" step="0.01" min="0"
                                                value="{{ $releve->carte_pro }}">
                                        </div>
                                    </div>
                                    <div class=" col-6 col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Chèque</strong></label><input class="form-control inputMontantCalcule"
                                                type="number" required id="cheque" placeholder="" name="cheque"
                                                step="0.01" min="0" value="{{ $releve->cheque }}">


                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Boutique</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="boutique" placeholder="" name="boutique" step="0.01"
                                                min="0" value="{{ $releve->boutique }}">


                                        </div>
                                    </div>
                                    <div class=" col-6 col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Client compte</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="client_compte" placeholder="" name="client_compte" step="0.01"
                                                min="0" value="{{ $releve->client_compte }}">


                                        </div>
                                    </div>
                                    <div class=" col-6 col-md-2 ">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Total</strong> </label> <a href="#!" id="generateTotalSaisie"
                                                class="text-dark"><i class="fas fa-calculator"></i></a><input
                                                class="form-control bg-light" type="number" required id="totalSaisie"
                                                placeholder="" name="totalSaisie" readonly step="0.01" min="0"
                                                value="{{ $releve->totalSaisie }}">


                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold text-dark"><i class="fal fa-file-alt text-primary"></i> Les
                                    montants calculée à partie du rapport </legend>
                                <div class="row">
                                    <div class="col-6 col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Espèce</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="especePdf" placeholder="" name="especePdf" step="0.01"
                                                min="0" value="{{ $releve->especePdf }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Bleu</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                step="0.01" min="0" id="carte_bleuPdf"
                                                value="{{ $releve->carte_bleuPdf }}" placeholder=""
                                                name="carte_bleuPdf">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Pro</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="carte_proPdf" placeholder="" name="carte_proPdf" step="0.01"
                                                min="0" value="{{ $releve->carte_proPdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Chèque</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="chequePdf" placeholder="" name="chequePdf" step="0.01"
                                                min="0" value="{{ $releve->chequePdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Boutique</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="boutiquePdf" placeholder="" name="boutiquePdf" step="0.01"
                                                min="0" value="{{ $releve->boutiquePdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Client compte</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="client_comptePdf" placeholder="" name="client_comptePdf"
                                                step="0.01" min="0" value="{{ $releve->client_comptePdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Total</strong> <a href="#!" id="generateTotalSaisiePdf"
                                                    class="text-dark"><i class="fas fa-calculator"></i></a> </label><input
                                                class="form-control bg-light" type="number" required id="totalSaisiePdf"
                                                placeholder="" name="totalPdf" readonly step="0.01" min="0"
                                                value="{{ $releve->totalPdf }}">


                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="first_name">
                                        <strong>
                                            Différence entre les Totaux
                                        </strong>
                                    </label>
                                    @php
                                        $class = '';
                                        if (Auth::user()->role == 0) {
                                            # code...
                                            $class = $releve->diff == 0 ? 'bg-success' : 'bg-danger';
                                        }
                                    @endphp
                                    <input
                                        class="
                                     form-control text-white {{ $class }}"
                                        type="number" required id="diff" placeholder="" name="diff" readonly
                                        value="{{ $releve->diff }}">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="first_name">
                                        <strong>
                                            Explication
                                        </strong>
                                    </label>
                                    <textarea class="form-control " id="diff" placeholder="" name="explication" step="0.01" value="0">{{ $releve->explication }}</textarea>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold text-dark"><i class="fal fa-file-alt text-primary"></i> Recette du
                                    boutique </legend>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3"><label class="form-label" for=""><strong>
                                                    Recette cigarettes</strong></label><input
                                                class="form-control bg-light " type="number" readonly required
                                                id="recette_cigarette" placeholder="" name="recette_cigarette"
                                                step="0.01" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3"><label class="form-label" for=""><strong>
                                                    Quantié vendue</strong></label><input class="form-control bg-light "
                                                type="number" readonly required id="qte_vendue_cigarette" placeholder=""
                                                name="qte_vendue_cigarette" step="0.01" min="0"
                                                value="0">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3"><label class="form-label" for=""><strong>
                                                    Recette divers</strong></label><input class="form-control bg-light "
                                                type="number" required readonly id="recette_divers" placeholder=""
                                                name="recette_divers" step="0.01" min="0"
                                                value="{{ $releve->divers }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3"><label class="form-label" for=""><strong>
                                                    Mode d'encaissement</strong></label><input
                                                class="form-control bg-light " type="text" required readonly
                                                id="mode_paiement" placeholder="" name="mode_paiement" step="0.01"
                                                min="0" value="{{ $releve->mode_paiement }}">
                                        </div>
                                    </div>




                                </div>
                            </fieldset>
                        </div>

                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold text-dark">-Les quantités des carburants vendues (à
                                    partir de rapport PDF)
                                </legend>
                                <div class="row">
                                    <div class="d-flex justify-content-evenly align-items-center mb-3 ">
                                        <div class="col-3 "><strong></strong></div>
                                        <div class="col-3 form-label   "><strong>Quantité vendue</strong></div>
                                        <div class="col-3 form-label  "><strong>Montant</strong></div>
                                        <div class="col-3 form-label   "><strong>Prix de vente</strong></div>
                                    </div>
                                    <hr>
                                    @php
                                        $ventes = json_decode($releve->vente);
                                        // // print_r($vente[0][0]);
                                        // foreach ($vente as $v) {
                                        //     # code...
                                        //     foreach ($v as $k => $v) {
                                        //         # code...
                                        //         echo $k . ' ' . $v->qte . ' ';
                                        //     }
                                        // }
                                    @endphp
                                    @forelse ($carburants as $carburant)
                                        @foreach ($ventes as $vente)
                                            @php
                                                $title = strtolower($carburant->titre);
                                            @endphp
                                            @foreach ($vente as $k => $v)
                                                @if ($k == $carburant->titre)
                                                    <div class="d-flex justify-content-evenly align-items-center">
                                                        <div class="col-2 mb-2 text-size-md">
                                                            <strong> {{ $k }}</strong>
                                                        </div>
                                                        <div class="col-3 mb-2">
                                                            <input class="form-control bg-light text-size-md"
                                                                type="number" required readonly
                                                                id="qte_{{ $carburant->id }}" placeholder=""
                                                                name="{{ 'qte_' . $title }}" min="0"
                                                                step="0.01" value="{{ $v->qte }}"
                                                                max="{{ $carburant->qtiteStk }}" />
                                                        </div>
                                                        <div class="col-3 mb-2">
                                                            <input class="form-control bg-light text-size-md"
                                                                type="number" required id="montant_{{ $carburant->id }}"
                                                                placeholder="" name="{{ 'montant_' . $title }}"
                                                                step="0.01" readonly value="{{ $v->montant }}"
                                                                min="0" />
                                                        </div>
                                                        <div class="col-3 mb-2">
                                                            <input class="form-control bg-light text-size-md"
                                                                type="number" required id="prix_{{ $carburant->id }}"
                                                                placeholder="" readonly name="{{ 'prix_' . $title }}"
                                                                step="0.01" min="0"
                                                                value="{{ $v->prix }}" />
                                                        </div>
                                                        <input type="hidden" name="titles[]"
                                                            value="{{ $carburant->titre }}">

                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @empty
                                    @endforelse


                                </div>
                            </fieldset>
                        </div>
                        <div class="row">
                            <fieldset class="border  mx-auto mb-3">
                                <legend class="fw-bold text-dark">-Les cigarettes Vendues
                                </legend>
                                @php

                                    $total = 0;
                                    $total_cigars = 0;
                                @endphp

                                @if (count(json_decode($releve->vente_cigarette)) > 0)


                                    <div class="row p-2">
                                        <div class="d-flex justify-content-center align-items-center mb-3 ">
                                            {{-- <div class="col-2 "><strong>Type</strong></div> --}}
                                            <div class="col-4 form-label  "><strong>Quantité vendue</strong></div>
                                            <div class="col-4 form-label  "><strong>Montant</strong></div>
                                            <div class="col-4 form-label  "><strong>Prix de vente</strong></div>
                                        </div>
                                        <hr>
                                        @php
                                            $ventes_cigars = json_decode($releve->vente_cigarette);

                                        @endphp
                                        <div class="p-3">


                                            @if ($ventes_cigars)
                                                @forelse ($cigarettes as $cigarette)
                                                    @forelse ($ventes_cigars as $vente)
                                                        @php
                                                            $title = $cigarette->type;
                                                            $id = $cigarette->id;
                                                        @endphp
                                                        @foreach ($vente as $k => $v)
                                                            @if (strtolower($k) == strtolower($title))
                                                                @php
                                                                    $total_cigars += $v->montant;
                                                                    $qte_cigars += $v->qte;
                                                                @endphp
                                                                <script>
                                                                    $("#qte_vendue_cigarette").val("{{ $qte_cigars }}")
                                                                </script>
                                                                <div
                                                                    class="d-flex justify-content-center align-items-center">

                                                                    <div class="col-4 m-2 text-size-md">
                                                                        <input class="form-control bg-light text-size-md"
                                                                            readonly type="number" required
                                                                            id="qteC_{{ $cigarette->id }}" placeholder=""
                                                                            name="{{ 'qteC_' . $id }}" min="0"
                                                                            step="0.01" value="{{ $v->qte }}"
                                                                            max="{{ $cigarette->qte }}" />
                                                                    </div>

                                                                    <div class="col-4 ">
                                                                        <input
                                                                            class="form-control bg-light m-2 text-size-md"
                                                                            type="number" required
                                                                            id="montantC_{{ $cigarette->id }}"
                                                                            placeholder="" name="{{ 'montantC_' . $id }}"
                                                                            step="0.01" value="{{ $v->montant }}"
                                                                            readonly min="0" />
                                                                    </div>
                                                                    <div class="col-4 m-2">
                                                                        <input
                                                                            class="form-control bg-light m-2 text-size-md"
                                                                            type="number" required
                                                                            id="prixC_{{ $cigarette->id }}" readonly
                                                                            placeholder="" name="{{ 'prixC_' . $id }}"
                                                                            step="0.01" min="0"
                                                                            value="{{ $v->prix }}" />
                                                                    </div>
                                                                    <input type="hidden" name="types[]"
                                                                        value="{{ $cigarette->type }}">
                                                                    <script>
                                                                        $("#qteC_{{ $cigarette->id }}").on("input", (e) => {

                                                                            if (!isNaN(e.target.value)) {
                                                                                let pv = $("#prixC_{{ $cigarette->id }}").val();
                                                                                $("#montantC_{{ $cigarette->id }}").val(parseFloat(pv * e.target.value).toFixed(2))
                                                                            }
                                                                        })
                                                                    </script>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                    @empty
                                                    @endforelse


                                                    {{-- <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="">
                                                    <strong>
                                                        {{ $carburant->titre }}</strong>
                                                </label>
                                              
                                                <input class="form-control" type="number" required
                                                    id="{{ $carburant->titre }}" placeholder=""
                                                    name="{{ $title == 'd-energie' ? 'qte_denergie' : 'qte_' . $title }}"
                                                    step="0.01" value="0" max="{{ $carburant->qtiteStk }}" />
                                                <input type="hidden" name="titles[]" value="{{ $carburant->titre }}">
                                            </div>
                                        </div> --}}
                                                @empty
                                                @endforelse
                                                {{-- {{ $total }} --}}
                                                <script></script>
                                            @endif
                                        </div>

                                    </div>
                                @endif
                                @php
                                    $rec_divers = $releve->boutiquePdf == 0 ? 0 : $releve->boutiquePdf - $total_cigars;
                                @endphp
                                <script>
                                    $("#recette_cigarette").val("{{ $total_cigars }}")
                                    // $("#recette_divers").val("{{ $rec_divers }}")
                                </script>
                            </fieldset>
                        </div>


                        @if (Auth::user()->role == 1)
                            <div class=" mx-auto text-center"><button class="btn btn-primary "
                                    type="submit">Enregistrer</button>

                            </div>
                        @endif
                </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        // $('input').attr(' @if (Auth::user()->role == 0)
        //     readonly
        // @endif
        // ', true);
        $('input').addClass("shadow-none text-dark");
        $('textarea').addClass("shadow-none");
        @if (Auth::user()->role == 0)
            $('input:not("#diff")').addClass("bg-light");
            $('input').attr('readonly', true);
            $('textarea').attr('readonly', true);
            $('textarea').addClass("bg-light");
        @endif
        // $('textarea').addClass("bg-light");
        // $('textarea').attr(' @if (Auth::user()->role == 0)
        //     readonly
        // @endif
        // ', true);
    </script>
    @if (Auth::user()->role == 1)
        <script src="{{ asset('/js/releve.js') }}"></script>
    @endif
@endsection
