@extends('dashboard/base') @section('title')
    Ajouter Relevé
@endsection
@php
    use App\Models\Releve;
@endphp
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">A Remplir</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" id="add_releve_form">
                        @csrf
                        <div class="row">
                            @php
                                $min_h = '';
                                $releve = Releve::where('date_systeme', date('Y-m-d'))->orderBy('id', 'desc')->first();
                                if ($releve) {
                                    $min_h = date('H:i', strtotime($releve->heure_f));
                                }
                            @endphp
                            <div class="col-md-3 col-6">
                                <div class="mb-3"><label class="form-label" for=""><strong>Heure
                                            début</strong></label>
                                    <input class="form-control" type="time" min="{{ $min_h }}" required
                                        id="heure_d" value="{{ $min_h }}" placeholder="" name="heure_d">
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="mb-3"><label class="form-label" for=""><strong>Heure
                                            fin</strong></label><input class="form-control" type="time" required
                                        id="heure_f" placeholder="" name="heure_f"></div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="mb-3"><label class="form-label" for=""><strong>Date
                                        </strong></label><input class="form-control " type="date" required
                                        value="{{ date('Y-m-d') }}" id="date_systeme" placeholder="" name="date_systeme">
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="mb-3"><label class="form-label" for=""><strong>Nom du caissier
                                        </strong></label><input class="form-control bg-light" type="text" required
                                        value="{{ Auth::user()->nom }}" readonly id="nom" placeholder=""
                                        name="nom"></div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
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
                                <legend class="fw-bold text-dark"><i class="far fa-user text-success"></i> Les montants
                                    calculée
                                </legend>
                                <div class="row">
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Espèce</strong></label><input class="form-control inputMontantCalcule"
                                                type="number" required id="espece" placeholder="" name="espece"
                                                step="0.01" min="0" value="0"
                                                oninput="checkEcart('espece','especePdf','Espece')">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Bleue</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                step="0.01" id="carte_bleu" placeholder="" name="carte_bleu"
                                                min="0" value="0"
                                                oninput="checkEcart('carte_bleu','carte_bleuPdf','CB')">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Pro</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="carte_pro" placeholder="" name="carte_pro" step="0.01" min="0"
                                                value="0" oninput="checkEcart('carte_pro','carte_proPdf','CP')">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Chèque</strong></label><input class="form-control inputMontantCalcule"
                                                type="number" required id="cheque" placeholder="" name="cheque"
                                                step="0.01" min="0"
                                                oninput="checkEcart('cheque','chequePdf','cheque')" value="0">


                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Boutique</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="boutique" placeholder="" name="boutique" step="0.01"
                                                min="0" value="0"
                                                oninput="checkEcart('boutique','boutiquePdf','boutique')">


                                        </div>
                                    </div> --}}
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Client compte</strong></label><input
                                                class="form-control inputMontantCalcule" type="number" required
                                                id="client_compte" placeholder="" name="client_compte" step="0.01"
                                                min="0" value="0"
                                                oninput="checkEcart('client_compte','client_comptePdf','client compte')">


                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="mb-3"><label class="form-label text-dark fw-bold"
                                                for="first_name"><strong>
                                                    Total</strong> <a id="generateTotalSaisie" class="text-primary"
                                                    style="cursor: pointer;"><i
                                                        class="fas fa-calculator"></i></a></label><input
                                                class="form-control bg-light" type="number" required id="totalSaisie"
                                                placeholder="" name="totalSaisie" readonly step="0.01" min="0"
                                                value="0">


                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold text-dark"><i class="fal fa-file-alt text-primary"></i> Les
                                    montants calculée à
                                    partie du rapport </legend>
                                <div class="row">
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Espèce</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="especePdf" placeholder="" name="especePdf" step="0.01"
                                                min="0" value="0"
                                                oninput="checkEcart('espece','especePdf','Espece')">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Bleu</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                step="0.01" min="0" value="0" id="carte_bleuPdf"
                                                placeholder="" name="carte_bleuPdf"
                                                oninput="checkEcart('carte_bleu','carte_bleuPdf','CB')">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Pro</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="carte_proPdf" placeholder="" name="carte_proPdf" step="0.01"
                                                min="0" value="0"
                                                oninput="checkEcart('carte_pro','carte_proPdf','CP')">


                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Chèque</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="chequePdf" placeholder="" name="chequePdf" step="0.01"
                                                oninput="checkEcart('cheque','chequePdf','cheque')" value="0"
                                                min="0" value="0">


                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Boutique</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="boutiquePdf" placeholder="" name="boutiquePdf" step="0.01"
                                                min="0" value="0"
                                                oninput="checkEcart('boutique','boutiquePdf','boutique')">


                                        </div>
                                    </div> --}}
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Client compte</strong></label><input
                                                class="form-control inputMontantCalculePdf" type="number" required
                                                id="client_comptePdf" placeholder="" name="client_comptePdf"
                                                step="0.01" min="0" value="0"
                                                oninput="checkEcart('client_compte','client_comptePdf','client compte')">


                                        </div>
                                    </div>
                                    <div class="col-md-2  ">
                                        <div class="mb-3"><label class="form-label text-dark fw-bold"
                                                for="first_name"><strong>
                                                    Total</strong> <a style="cursor: pointer;" id="generateTotalSaisiePdf"
                                                    class="text-primary"><i
                                                        class="fas fa-calculator"></i></a></label><input
                                                class="form-control bg-light" type="number" required id="totalSaisiePdf"
                                                placeholder="" name="totalPdf" readonly step="0.01" min="0"
                                                value="0">


                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="first_name"><strong>
                                            Différence entre les Totaux</strong>


                                    </label><input class="form-control " type="number" required id="diff"
                                        placeholder="" name="diff" readonly step="0.01" value="0">


                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="first_name">
                                        <strong>
                                            S'il y a une différence , saisissez les causes
                                        </strong>
                                    </label>
                                    <textarea class="form-control " id="diffExp" placeholder="" name="explication" step="0.01" value="0"></textarea>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold ">-Les quantités du carburants Vendues (à
                                    partir de rapport PDF)
                                </legend>
                                <div class="row">
                                    <div class="d-flex justify-content-evenly align-items-center mb-3 ">
                                        <div class="col-3 text-size-md "><strong>Carburant</strong></div>
                                        <div class="col-3 form-label text-size-md "><strong>Quantite vendue</strong></div>
                                        <div class="col-3 form-label text-size-md "><strong>Montant</strong></div>
                                        <div class="col-3 form-label  text-size-md"><strong>Prix de vente</strong></div>
                                    </div>
                                    <hr>
                                    <script>
                                        let carbs = [];
                                        let carbs_ids = [];
                                    </script>
                                    @forelse ($carburants as $carburant)
                                        <script>
                                            carbs.push({
                                                id: "{{ $carburant->id }}",
                                                title: "{{ strtolower($carburant->titre) }}"
                                            });
                                            carbs_ids.push("{{ $carburant->id }}")
                                        </script>
                                        @php
                                            $title = strtolower($carburant->titre);
                                        @endphp
                                        <div class="d-flex justify-content-evenly align-items-center text-size-md">
                                            <div class="col-2 mb-3">
                                                <strong> {{ $carburant->titre }}</strong>
                                            </div>
                                            <div class="col-3 mb-3">
                                                <input class="form-control text-size-md" type="number" required
                                                    id="qte_{{ $carburant->id }}" name="{{ 'qte_' . $title }}"
                                                    step="0.01" value="0" />
                                            </div>
                                            <div class="col-3 mb-3">
                                                <input class="form-control text-size-md  " type="number" required
                                                    id="montant_{{ $carburant->id }}" name="{{ 'montant_' . $title }}"
                                                    step="0.01" value="0" min="0" />
                                            </div>
                                            <div class="col-3 mb-3">
                                                <input class="form-control bg-light text-size-md" type="number" required
                                                    id="prix_{{ $carburant->id }}" min="0"
                                                    name="{{ 'prix_' . $title }}" step="0.01" {{-- value="{{ $carburant->prixV }}" --}}
                                                    value="0" readonly />
                                            </div>
                                            <script>
                                                $("#montant_{{ $carburant->id }} , #qte_{{ $carburant->id }}").on("input", (e) => {
                                                    let qte = $("#qte_{{ $carburant->id }}").val();
                                                    let montant = $("#montant_{{ $carburant->id }}").val();
                                                    if (qte != 0 && montant != 0) {
                                                        $("#prix_{{ $carburant->id }}").val(parseFloat(montant / qte).toFixed(3))
                                                    }
                                                })
                                            </script>
                                            <input type="hidden" name="titles[]" value="{{ $carburant->titre }}">

                                        </div>

                                    @empty
                                    @endforelse


                                </div>
                            </fieldset>
                        </div>
                        {{-- <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold mb-3 ">-Les cigarettes Vendues
                                </legend>
                                <div class="row">

                            

                                    <div class="d-flex  align-items-center mb-3 ">
                                        <div class="col-6 form-label  m-2"><strong>Quantité vendue</strong></div>
                                        <div class="col-6 form-label  m-2"><strong>Montant</strong></div>
                                    </div>
                                    <hr>

                                    <div class="container-rows">
                                        <div class="row" id="">

                                            <div class="col-6">
                                                <div class="mb-3 ">

                                                    <input class="form-control text-dark " type="number" step="0.01"
                                                        required id="qteC" value="0" placeholder="" required
                                                        name="qteC" />

                                                </div>

                                            </div>
                                            <div class="col-md-3  visually-hidden">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark bg-light" type="number"
                                                        step="0.01" required id="prixVC" hidden placeholder=""
                                                        readonly required name="prixVC" />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3 d-flex align-items-center">
                                                    <input class="form-control  text-dark " type="number" step="0.01"
                                                        required id="montantC" value="0" placeholder="" required
                                                        name="montantC" />

                                                </div>

                                            </div>
                                        </div>
                                        <script>
                                            let prixVC = $("#prixVC").val();
                                            let montant = $("#montantC").val();
                                            $("#qteC").on("input", (e) => {

                                                $(`#prixVC`).val(parseFloat($("#montantC").val() / e.target.value)
                                                    .toFixed(3))

                                            })
                                            $("#montantC").on("input", (e) => {

                                                $(`#prixVC`).val(parseFloat(e.target.value / $("#qteC").val())
                                                    .toFixed(3))

                                            })
                                        </script>
                                    </div>
                                </div>
                            </fieldset>
                        </div> --}}
                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold mb-3 ">-Recette Boutique
                                </legend>
                                <div class="row">
                                    <div class="col-md-2 col-6">
                                        <div class=" form-label "><strong>Recette Cigarette</strong></div>
                                        <div class="row " id="">
                                            <div class="col-12">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark " type="number" step="0.01"
                                                        required id="recette_cigarettes" value="0" placeholder=""
                                                        required name="recette_cigarettes" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-2 col-6">
                                        <div class=" form-label "><strong>Quantité vendue</strong></div>
                                        <div class="row " id="">
                                            <div class="col-12">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark " type="number" step="0.01"
                                                        required id="qte_cigarettes" value="0" placeholder=""
                                                        required name="qte_cigarettes" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-2 col-6">
                                        <div class=" form-label   "><strong>Recette divers</strong></div>
                                        <div class="row " id="">
                                            <div class="col-12">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark " type="number" step="0.01"
                                                        required id="divers" value="0" placeholder="" required
                                                        name="divers" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Espèce</strong></label><input
                                                class="form-control inputMontantCalculeBoutique" type="number" required
                                                id="espece_boutique" placeholder="" name="espece_boutique"
                                                step="0.01" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Carte Bleue</strong></label><input
                                                class="form-control inputMontantCalculeBoutique" type="number" required
                                                id="carte_bleue_boutique" placeholder="" name="carte_bleue_boutique"
                                                step="0.01" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Chèque</strong></label><input
                                                class="form-control inputMontantCalculeBoutique" type="number" required
                                                id="cheque_boutique" placeholder="" name="cheque_boutique"
                                                step="0.01" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                                    Client compte</strong></label><input
                                                class="form-control inputMontantCalculeBoutique" type="number" required
                                                id="client_compte_boutique" placeholder="" name="client_compte_boutique"
                                                step="0.01" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2  ">
                                        <div class="mb-3"><label class="form-label text-dark fw-bold"
                                                for="first_name"><strong>
                                                    Total Boutique</strong> <a style="cursor: pointer;"
                                                    id="generateTotalBoutique" class="text-primary"><i
                                                        class="fas fa-calculator"></i></a></label><input
                                                class="form-control bg-light" type="number" required id="totalb"
                                                placeholder="" name="totalb" readonly step="0.01" min="0"
                                                value="0">


                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                        {{-- <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold mb-3 ">-Recette PMI
                                </legend>
                                <div class="row">
                                    <div class="container-rows">
                                        <div class="col-6 form-label p-2  "><strong>Montant</strong></div>

                                        <div class="row " id="">
                                            <div class="col-12">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark " type="number" step="0.01"
                                                        required id="pmi" value="0" placeholder="" required
                                                        name="pmi" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="row">
                            <fieldset class="border p-2 mx-auto mb-3">
                                <legend class="fw-bold mb-3 ">-Recette FDG
                                </legend>
                                <div class="row">
                                    <div class="container-rows">
                                        <div class="col-6 form-label p-2  "><strong>Montant</strong></div>

                                        <div class="row " id="">
                                            <div class="col-12">
                                                <div class="mb-3 ">
                                                    <input class="form-control text-dark " type="number" step="0.01"
                                                        required id="fdg" value="0" placeholder="" required
                                                        name="fdg" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div> --}}

                        <div class=" mx-auto text-center"><button class="btn btn-primary " type="submit"
                                id="submitBtnReleve">Terminer la
                                journée</button>

                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
    <script src="{{ asset('/js/releve.js') }}"></script>
@endsection
