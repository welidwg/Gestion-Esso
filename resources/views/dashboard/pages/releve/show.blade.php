@extends('dashboard/base') @section('title')
    Journal caisse
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Journal caisse</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" id="add_releve_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Heure
                                            début</strong></label><input class="form-control" type="time" required
                                        id="heure_d" placeholder="" value='{{ $releve->heure_d }}' name="heure_d"></div>

                            </div>
                            <div class="col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Heure
                                            fin</strong></label><input class="form-control" type="time" required
                                        value="{{ $releve->heure_f }}" id="heure_f" placeholder="" name="heure_f"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Date
                                        </strong></label><input readonly class="form-control bg-light" type="text"
                                        required value="{{ date('d/m/Y', strtotime($releve->date_systeme)) }}"
                                        @if (Auth::user()->role == 0) readonly @endif id="date_systeme" placeholder=""
                                        name="date_systeme"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3"><label class="form-label" for=""><strong>Code caissier
                                        </strong></label><input readonly class="form-control bg-light" type="text"
                                        required value="{{ $releve->caissier->code }}"
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
                                <legend class="fw-bold text-dark">-Les montants calculée </legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Espèce</strong></label><input class="form-control inputMontantCalcule"
                                                type="number" required id="espece" placeholder="" name="espece"
                                                step="0.01" min="0" value="{{ $releve->espece }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Bleu</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                step="0.01" id="carte_bleu" placeholder="" name="carte_bleu"
                                                min="0" value="{{ $releve->carte_bleu }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Pro</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="carte_pro" placeholder="" name="carte_pro" step="0.01" min="0"
                                                value="{{ $releve->carte_pro }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Chèque</strong></label><input class="form-control inputMontantCalcule"
                                                type="number" required id="cheque" placeholder="" name="cheque"
                                                step="0.01" min="0" value="{{ $releve->cheque }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Boutique</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="boutique" placeholder="" name="boutique" step="0.01"
                                                min="0" value="{{ $releve->boutique }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Client compte</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="client_compte" placeholder="" name="client_compte" step="0.01"
                                                min="0" value="{{ $releve->client_compte }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Total</strong> </label><a href="#!" id="generateTotalSaisie"
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
                                <legend class="fw-bold text-dark">-Les montants calculée à partie du rapport </legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Espèce</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="especePdf" placeholder="" name="especePdf" step="0.01"
                                                min="0" value="{{ $releve->especePdf }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Bleu</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                step="0.01" min="0" id="carte_bleuPdf"
                                                value="{{ $releve->carte_bleuPdf }}" placeholder=""
                                                name="carte_bleuPdf">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Pro</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="carte_bleuPdf" placeholder="" name="carte_bleuPdf" step="0.01"
                                                min="0" value="{{ $releve->carte_bleuPdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Chèque</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="chequePdf" placeholder="" name="chequePdf" step="0.01"
                                                min="0" value="{{ $releve->chequePdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Boutique</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="boutiquePdf" placeholder="" name="boutiquePdf" step="0.01"
                                                min="0" value="{{ $releve->boutiquePdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Client compte</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="client_comptePdf" placeholder="" name="client_comptePdf"
                                                step="0.01" min="0" value="{{ $releve->client_comptePdf }}">


                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Total</strong> </label><input class="form-control bg-light"
                                                type="number" required id="totalSaisiePdf" placeholder=""
                                                name="totalPdf" readonly step="0.01" min="0"
                                                value="{{ $releve->totalPdf }}">


                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold ">-Les quantités Vendues (à
                                    partir de rapport PDF)
                                </legend>
                                <div class="row">
                                    @php
                                        
                                    @endphp
                                    @forelse ($carburants as $carburant)
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="">
                                                    <strong>
                                                        {{ $carburant->titre }}</strong>
                                                </label>
                                                @php
                                                    $title = strtolower($carburant->titre);
                                                    $titleF = 'qte_' . $title;
                                                @endphp
                                                <input class="form-control" type="number" required
                                                    id="{{ $carburant->titre }}" placeholder=""
                                                    name="{{ $title == 'd-energie' ? 'qte_denergie' : 'qte_' . $title }}"
                                                    step="0.01"
                                                    value="{{ $title == 'd-energie' ? $releve->qte_denergie : $releve->$titleF }}"
                                                    max="{{ $carburant->qtiteStk }}" />
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse


                                </div>
                            </fieldset>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                            Différence entre les Totaux</strong> <i class="fas fa-check text-success"
                                            style="display: none" id="check-done"></i>
                                        <i class="fas fa-times text-danger" id="check-error"
                                            style="display: none"></i></label><input class="form-control " type="number"
                                        required id="diff" placeholder="" name="diff" readonly
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
                        {{-- <div class=" mx-auto text-center"><button class="btn btn-primary " type="submit">Terminer la
                                journée</button>

                        </div> --}}
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
        // $('input').addClass("bg-light");
        // $('input').addClass("shadow-none text-dark");

        // $('textarea').addClass("bg-light");
        // $('textarea').addClass("shadow-none");
        // $('textarea').attr(' @if (Auth::user()->role == 0)
        //     readonly
        // @endif
        // ', true);
    </script>
    <script src="{{ asset('/js/releve.js') }}"></script>
@endsection
