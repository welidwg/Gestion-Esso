@extends('dashboard/base')
@section('title')
    Accueil
@endsection
@php
    use App\Models\Compte;
    use App\Models\Releve;
    use App\Models\Carburant;
    use App\Models\User;
    use App\Models\Facture;
    use App\Models\Cigarette;
    use App\Models\AchatCigarette;
    use Carbon\Carbon;
@endphp

@section('content')
    <script>
        function getRandomColor(alpha) {
            var r = Math.floor(Math.random() * 256);
            var g = Math.floor(Math.random() * 256);
            var b = Math.floor(Math.random() * 256);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        function conditionColor(value) {
            if (value < 0) {
                return 'red';
            } else if (value == 0) {
                return 'blue';
            } else {
                return 'limegreen';
            }
        }
    </script>
    @if (Auth::user()->role == 0)
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Tableau de bord</h3>
            {{-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block"
                role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>
        @php
            $carbs = Carburant::all();
        @endphp
        {{-- @php
            $moyennes = [];
            $carbs = Carburant::all();
        @endphp

        @foreach ($dates as $date)
            @php
                $rels = Releve::where('date_systeme', '=', $date->date_systeme)->get();
                if ($rels) {
                    foreach ($rels as $rel) {
                        foreach ($carbs as $carburant) {
                            $total = 0;
                            $title = 'qte_' . strtolower($carburant->titre);
                            if ($carburant->titre == 'D-ENERGIE') {
                                $title = 'qte_denergie';
                            }
                
                            if ($rel->$title != 0.0) {
                                $total += $rel->$title;
                                // echo $rel->$title . ' ';
                                if (isset($moyennes[$carburant->titre])) {
                                    $moyennes[$carburant->titre] += $total;
                                    // array_merge($moyennes, [$carburant->titre => $total]);
                                } else {
                                    $moyennes["$carburant->titre"] = $total;
                                }
                            }
                        }
                
                        $total = 0;
                    }
                }
                
            @endphp
        @endforeach --}}
        <div class="text-size-md">
            <div class="row d-flex justify-content-start text-size-md">
                {{-- <div class="col-md-6 col-xl-3 mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Votre solde
                                        </span>
                                    </div>
                                    @php
                                        
                                        $cp = Compte::first();
                                    @endphp
                                    <div class="text-dark fw-bold h5 mb-2"><span>{{ $cp ? $cp->montant : '0' }} € </span>
                                    </div>
                                    <div class="text-dark  mb-0"><a class="btn shadow-sm rounded-2"
                                            id="reinitCompte">Réinitialiser </a></div>
                                    <script>
                                        $("#reinitCompte").on("click", () => {
                                            Swal.fire({
                                                title: "Réinitialiser votre solde",
                                                input: "text",
                                                inputAttributes: {
                                                    autocapitalize: "off",
                                                },
                                                showCancelButton: true,
                                                confirmButtonText: "Réinitialiser",
                                                cancelButtonText: "Annuler",
                                                showLoaderOnConfirm: true,
                                                preConfirm: async (inputData) => {
                                                    console.log(inputData);
                                                    return axios.post("/comptes/init", {
                                                            solde: inputData
                                                        })
                                                        .then(res => {
                                                            console.log(res)
                                                            Swal.fire({
                                                                title: `Opération réussite`,
                                                                text: "Votre solde est bien réinitialisé. ",
                                                                icon: "success",
                                                            });
                                                            setTimeout(() => {
                                                                window.location.reload()

                                                            }, 1200);
                                                        })
                                                        .catch(err => {
                                                            console.log(err);
                                                            Swal.showValidationMessage(`Opération échouée: ${err.message}`);

                                                        })
                                                    // fetch(`//api.github.com/users/${login}`)
                                                    //     .then((response) => {
                                                    //         if (!response.ok) {
                                                    //             throw new Error(response.statusText);
                                                    //         }
                                                    //         return response.json();
                                                    //     })
                                                    //     .catch((error) => {
                                                    //         Swal.showValidationMessage(`Request failed: ${error}`);
                                                    //     });
                                                },
                                                allowOutsideClick: () => !Swal.isLoading(),
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal({
                                                        title: `Opération réussite`,
                                                        text: "Votre solde est bien réinitialisé. ",
                                                        icon: "success",
                                                    });
                                                }
                                                console.log(result);
                                            });
                                        })
                                    </script>
                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-4  mb-4  ">
                    <div class="card shadow border-start-primary  py-2 h-100">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters ">
                                <div class="col me-2 d-flex flex-column justify-content-between h-100 text-size-md">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-3"><span>Client en compte
                                            (mois {{ date('m/Y') }})
                                        </span>
                                    </div>
                                    @php

                                        $cp = Compte::whereMonth('created_at', Carbon::now()->month)
                                            ->whereYear('created_at', Carbon::now()->year)
                                            ->first();
                                    @endphp
                                    <div class="text-dark text-size-md fw-bold h5 mb-2">
                                        <span>{{ $cp ? $cp->compte_client : '0' }} €
                                        </span>
                                    </div>


                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-danger fw-bold text-xs mb-3"><span>Total TVA achat
                                            (mois {{ date('m') }})
                                        </span>
                                    </div>
                                    @php
                                        $tva_achat = 0;
                                        $facts = Facture::whereMonth('date_facture', date('m'))->get();
                                        foreach ($facts as $facture) {
                                            # code...
                                            $tva_achat += $facture->montant * 0.2;
                                        }

                                    @endphp

                                    <div class="text-dark fw-bold text-size-md mb-2 "><span>{{ $tva_achat }} € </span>
                                    </div>
                                    <div class="text-dark  mb-0"></div>

                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-3"><span>Total TVA encaissé
                                            (mois {{ date('m') }})
                                        </span>
                                    </div>
                                    @php
                                        $tva = 0;
                                        $relTva = Releve::whereMonth('date_systeme', Carbon::now()->month)
                                            ->whereYear('date_systeme', Carbon::now()->year)
                                            ->get();
                                        foreach ($relTva as $r) {
                                            $tva += $r->tva;
                                        }
                                    @endphp

                                    <div class="text-dark fw-bold text-size-md mb-2"><span>{{ $tva }} € </span>
                                    </div>
                                    <div class="text-dark  mb-0"></div>

                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-3"><span>Total TVA à payer
                                            (mois {{ date('m') }})
                                        </span>
                                    </div>
                                    @php

                                    @endphp

                                    <div
                                        class="fw-bold text-size-md mb-2 {{ $tva_achat - $tva > 0 ? 'text-success' : 'text-danger' }}">
                                        <span>{{ $tva_achat - $tva }} € </span>
                                    </div>
                                    <div class="text-dark  mb-0"></div>

                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-3"><span>Recette
                                            d'aujourd'hui
                                        </span>
                                    </div>
                                    @php
                                        $recette = 0;
                                        $rec_carburants = 0;
                                        $rec_carburants_mois = 0;
                                        $rec_pmi_mois = 0;
                                        $rec_fdg_mois = 0;
                                        $rec_boutique = 0;
                                        $releves = Releve::where('date_systeme', date('Y-m-d'))->get();
                                        $relevesMois = Releve::whereMonth('date_systeme', Carbon::now()->month)
                                            ->whereYear('date_systeme', Carbon::now()->year)
                                            ->get();
                                        foreach ($releves as $rel) {
                                            $rec_boutique += $rel->divers;
                                            $ventes = json_decode($rel->vente);
                                            $ventes_cigarettes = json_decode($rel->vente_cigarette);
                                            foreach ($ventes as $vente) {
                                                foreach ($vente as $key => $value) {
                                                    $rec_carburants += $value->montant;
                                                }
                                                # code...
                                            }
                                            foreach ($ventes_cigarettes as $vente1) {
                                                foreach ($vente1 as $key => $value) {
                                                    $rec_boutique += $value->montant;
                                                }
                                                # code...
                                            }
                                            # code...
                                        }
                                        $recette = $rec_boutique + $rec_carburants;

                                        foreach ($relevesMois as $rel) {
                                            $ventes = json_decode($rel->vente);
                                            $rec_pmi_mois += $rel->pmi;
                                            $rec_fdg_mois += $rel->fdg;
                                            foreach ($ventes as $vente) {
                                                foreach ($vente as $key => $value) {
                                                    $rec_carburants_mois += $value->montant;
                                                }
                                                # code...
                                            }
                                        }

                                    @endphp
                                    <div class="text-dark fw-bold   mb-2"><span> {{ $recette }} € </span></div>
                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-3"><span>Recette
                                            carburant (mois {{ date('m') }})
                                        </span>
                                    </div>

                                    <div class="text-dark  fw-bold   mb-2"><span> {{ $rec_carburants_mois }} € </span>
                                    </div>


                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-3"><span>Recette
                                            boutique
                                        </span>
                                    </div>
                                    <div class="text-dark   fw-bold   mb-2"><span> {{ $rec_boutique }} € </span>
                                    </div>
                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-3"><span>Recette
                                            PMI (mois {{ date('m/Y') }})
                                        </span>
                                    </div>
                                    <div class="text-dark   fw-bold   mb-2"><span> {{ $rec_pmi_mois }} € </span>
                                    </div>
                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-md-4  mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-3"><span>Recette
                                            FDG (mois {{ date('m/Y') }})
                                        </span>
                                    </div>
                                    <div class="text-dark   fw-bold   mb-2"><span> {{ $rec_fdg_mois }} € </span>
                                    </div>
                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                @php
                    // $start = Carbon::parse('10:30:00');

                    // $end = Carbon::parse('12:45:00');
                    // $duration = $end->diffInMinutes($start);
                    // echo 'Duration: ' . $duration . ' minutes';
                    // echo 'hours : ' . $duration / 60;
                @endphp
                {{-- <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Earnings (annual)</span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0"><span>$215,000</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Tasks</span></div>
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark fw-bold h5 mb-0 me-3"><span>50%</span></div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100" style="width: 50%;"><span
                                                    class="visually-hidden">50%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Pending Requests</span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0"><span>18</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div> 
        </div> --}}
            </div>
        </div>
        <div class="row d-flex justify-content-start text-size-md mb-2">
            <h4 class="text-dark mb-2">Marges de carburants</h4>
            @foreach ($carbs as $carb)
                <div class="col-md-2  mb-2  ">
                    <div class="card shadow border-start-primary  py-2 h-100">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters ">
                                <div class="col me-2 d-flex flex-column justify-content-between h-100 text-size-md">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-3"><span>{{ $carb->titre }}
                                        </span>
                                    </div>

                                    <div class="text-dark text-size-md fw-bold h5 mb-2">
                                        <span>{{ $carb->prixV - $carb->prixA }} €
                                        </span>
                                    </div>


                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row text-size-md">
            <div class="col-lg-6 col-xl-6 mb-3">
                <div class="card shadow mb-4 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0 text-size-md">Statistiques carburants (mois
                            {{ date('m/Y') }})

                        </h6>
                        <a class="btn  bg-gradient-light border-0 rounded-4  text-size-md fw-bold shadow-sm text-primary "
                            href="/carburant/stats?date={{ date('Y-m') }}">Plus</a>
                        {{-- <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle"
                                aria-expanded="false" data-bs-toggle="dropdown" type="button"><i
                                    class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item"
                                    href="#"> Action</a><a class="dropdown-item" href="#"> Another action</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"> Something else
                                    here</a>
                            </div>
                        </div> --}}
                    </div>

                    <div class="card-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Carburant</th>
                                    <th scope="col">Vente</th>
                                    <th scope="col">Achat</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($carbs as $carb)
                                    @php
                                        $total_vente_euro = 0;
                                        $total_vente_qte = 0;
                                        $total_achat_euro = 0;
                                        $total_achat_qte = 0;
                                        $test = [];
                                        $title = $carb->titre;

                                        $relevesStat1 = Releve::whereMonth('date_systeme', date('m'))
                                            ->whereYear('date_systeme', date('Y'))
                                            ->get();

                                        $factureStat = Facture::whereMonth('date_facture', date('m'))
                                            ->whereYear('date_facture', date('Y'))
                                            ->get();
                                        foreach ($relevesStat1 as $r) {
                                            $ventes = json_decode($r->vente);
                                            if ($ventes != null) {
                                                foreach ($ventes as $vente) {
                                                    foreach ($vente as $k => $v) {
                                                        if ($k == $carb->titre) {
                                                            if ($v->montant != 0) {
                                                                $total_vente_euro += $v->montant;
                                                                $total_vente_qte += $v->qte;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        foreach ($factureStat as $fact) {
                                            if ($fact->$title != null) {
                                                $achats = json_decode($fact->$title);
                                                foreach ($achats as $achat) {
                                                    foreach ($achat as $k => $v) {
                                                        if ($k == 'qte') {
                                                            $total_achat_qte += $v;
                                                        }
                                                        if ($k == 'montant') {
                                                            $total_achat_euro += $v;
                                                        }
                                                    }
                                                    # code...
                                                }
                                            }

                                            # code...
                                        }

                                    @endphp
                                    <tr>
                                        <td scope="row">{{ $title }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark">
                                                    <span class="">
                                                        {{ $total_vente_qte }} Litres
                                                    </span>
                                                    /
                                                    <span class="text-primary">
                                                        {{ $total_vente_euro }} €
                                                    </span>
                                                </span>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark">
                                                    <span class="">
                                                        {{ $total_achat_qte }} Litres
                                                    </span>
                                                    /
                                                    <span class="text-primary">
                                                        {{ $total_achat_euro }} €
                                                    </span>
                                                </span>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6 mb-3">
                <div class="card shadow mb-4 h-100 text-size-md">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0 text-size-md">Marges bénéficières du carburant en € (mois
                            {{ date('m/Y') }})

                        </h6>
                        {{-- <a class="btn  bg-gradient-light border-0 rounded-4 text-size-md  fw-bold shadow-sm text-primary "
                            href="/carburant/stats?date={{ date('Y-m') }}">Plus</a> --}}
                        {{-- <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle"
                                aria-expanded="false" data-bs-toggle="dropdown" type="button"><i
                                    class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item"
                                    href="#"> Action</a><a class="dropdown-item" href="#"> Another action</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"> Something else
                                    here</a>
                            </div>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        @php
                            $carbs = Carburant::all();
                            $titles = [];
                            $marges = [];
                            foreach ($carbs as $carb) {
                                $total_vente_euro = 0;
                                $total_vente_qte = 0;
                                $total_achat_euro = 0;
                                $total_achat_qte = 0;
                                $test = [];
                                $title = $carb->titre;
                                array_push($titles, $title);
                                $test = 0;

                                $relevesStat1 = Releve::whereMonth('date_systeme', date('m'))
                                    ->whereYear('date_systeme', date('Y'))
                                    ->get();

                                $factureStat = Facture::whereMonth('date_facture', date('m'))
                                    ->whereYear('date_facture', date('Y'))
                                    ->get();
                                foreach ($relevesStat1 as $r) {
                                    $ventes = json_decode($r->vente);
                                    if ($ventes != null) {
                                        foreach ($ventes as $vente) {
                                            foreach ($vente as $k => $v) {
                                                if ($k == $carb->titre) {
                                                    if ($v->montant != 0) {
                                                        $total_vente_euro += $v->montant;
                                                        $total_vente_qte += $v->qte;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                foreach ($factureStat as $fact) {
                                    if ($fact->$title != null) {
                                        $achats = json_decode($fact->$title);
                                        foreach ($achats as $achat) {
                                            foreach ($achat as $k => $v) {
                                                if ($k == 'qte') {
                                                    $total_achat_qte += $v;
                                                }
                                                if ($k == 'montant') {
                                                    $total_achat_euro += $v;
                                                }
                                            }
                                            # code...
                                        }
                                    }

                                    # code...
                                }
                                $mrg = $total_vente_euro - $total_achat_euro;
                                array_push($marges, $mrg);
                            }

                        @endphp

                        <div class="chart-area text-size-md">
                            <canvas height="auto" id="chart_marge_carb"></canvas>
                        </div>
                        <script type="text/javascript">
                            var labels = {!! json_encode($titles) !!};
                            var marges = {!! json_encode($marges) !!};
                            var backgroundColors = marges.map(marge => conditionColor(marge));

                            const data = {
                                labels: labels,
                                datasets: [{
                                    label: 'marge ',
                                    backgroundColor: backgroundColors,
                                    data: marges,
                                }]
                            };

                            const config = {
                                type: 'bar',
                                data: data,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                    },
                                    // scales: {
                                    //     x: {
                                    //         ticks: {
                                    //             font: {
                                    //                 size: 11,
                                    //             }
                                    //         }
                                    //     }
                                    // }


                                }
                            };

                            new Chart(
                                document.getElementById('chart_marge_carb'),
                                config
                            );
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6 mb-3">
                <div class="card shadow mb-4 h-100 text-size-md">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0  text-size-md">Statistiques cigarettes en € (mois
                            {{ date('m/Y') }}) </h6>
                        <a class="btn  bg-gradient-light border-0 rounded-4 text-size-md  fw-bold shadow-sm text-primary "
                            href="/cigarette/stats?date={{ date('Y-m') }}">Plus</a>
                        {{-- <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle"
                                aria-expanded="false" data-bs-toggle="dropdown" type="button"><i
                                    class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item"
                                    href="#"> Action</a><a class="dropdown-item" href="#"> Another action</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"> Something else
                                    here</a>
                            </div>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Vente</th>
                                    <th scope="col">Achat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cigars = Cigarette::all();

                                @endphp
                                @foreach ($cigars as $cigarette)
                                    @php
                                        $total_vente_euro = 0;
                                        $total_vente_qte = 0;
                                        $total_achat_euro = 0;
                                        $total_achat_qte = 0;
                                        $test = [];
                                        $title = $cigarette->type;

                                        $relevesStat2 = Releve::whereMonth('date_systeme', date('m'))
                                            ->whereYear('date_systeme', date('Y'))
                                            ->get();

                                        $achatStat = AchatCigarette::whereMonth('date_achat', date('m'))
                                            ->whereYear('date_achat', date('Y'))
                                            ->get();
                                        foreach ($relevesStat2 as $r) {
                                            $ventes = json_decode($r->vente_cigarette);
                                            if ($ventes != null) {
                                                foreach ($ventes as $vente) {
                                                    foreach ($vente as $k => $v) {
                                                        if ($k == $title) {
                                                            $total_vente_euro += $v->montant;
                                                            $total_vente_qte += $v->qte;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        foreach ($achatStat as $achat) {
                                            $achats = json_decode($achat->achat);
                                            foreach ($achats as $ach) {
                                                foreach ($ach as $key => $value) {
                                                    if ($key == $title) {
                                                        $total_achat_euro += $achat->total;
                                                        $total_achat_qte += $value->qte;
                                                    }
                                                }
                                            }

                                            # code...
                                        }

                                    @endphp
                                    <tr>
                                        <td scope="row">{{ 'Cigarette' }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark">
                                                    <span class="">
                                                        {{ $total_vente_qte }} Packets
                                                    </span>
                                                    /
                                                    <span class="text-primary">
                                                        {{ $total_vente_euro }} €
                                                    </span>
                                                </span>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark">
                                                    <span class="">
                                                        {{ $total_achat_qte }} Packets
                                                    </span>
                                                    /
                                                    <span class="text-primary">
                                                        {{ $total_achat_euro }} €
                                                    </span>
                                                </span>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6 mb-3">
                <div class="card shadow mb-4 h-100 text-size-md">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0 text-size-md">Recette par carburant en € (mois
                            {{ date('m/Y') }}) </h6>
                        {{-- <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle"
                                aria-expanded="false" data-bs-toggle="dropdown" type="button"><i
                                    class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item"
                                    href="#"> Action</a><a class="dropdown-item" href="#"> Another action</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"> Something else
                                    here</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas height="auto" id="myChart"></canvas>
                        </div>
                        @php
                            $carburants = [];
                            $recettes = [];
                            $carbs = Carburant::all();
                            $title = '';
                            $total = 0;
                            foreach ($carbs as $carb) {
                                array_push($carburants, $carb->titre);
                                // $title = 'qte_' . strtolower($carb->titre);
                                // if ($carb->titre == 'D-ENERGIE') {
                                //     $title = 'qte_denergie';
                                // }
                                $releves1 = Releve::whereMonth('date_systeme', date('m'))
                                    ->whereYear('date_systeme', date('Y'))
                                    ->get();
                                foreach ($releves1 as $r) {
                                    $ventes = json_decode($r->vente);
                                    if ($ventes != null) {
                                        foreach ($ventes as $vente) {
                                            foreach ($vente as $k => $v) {
                                                if ($k == $carb->titre) {
                                                    if ($v->montant != 0) {
                                                        $total += $v->montant;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                array_push($recettes, $total);
                                $total = 0;
                            }
                        @endphp
                        <script type="text/javascript">
                            var labels = {!! json_encode($carburants) !!};
                            var users = {!! json_encode($recettes) !!};
                            const backs = labels.map(label => getRandomColor(0.8))

                            const data_carb = {
                                labels: labels,
                                datasets: [{
                                    label: 'recette ',
                                    backgroundColor: backs,
                                    // borderColor: 'rgb(255, 99, 132)',
                                    data: users,
                                }]
                            };

                            const config_carb = {
                                type: 'bar',
                                data: data_carb,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                    }
                                }
                            };

                            new Chart(
                                document.getElementById('myChart'),
                                config_carb
                            );
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6 mb-3">
                <div class="card shadow mb-4 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0 text-size-md">Recette d'aujourd'hui (en € )</h6>
                        {{-- <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle"
                                aria-expanded="false" data-bs-toggle="dropdown" type="button"><i
                                    class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item"
                                    href="#"> Action</a><a class="dropdown-item" href="#"> Another action</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"> Something else
                                    here</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="chart-area text-size-md">
                            <canvas height="auto" id="myChart2"></canvas>
                        </div>
                        @php
                            $recettes = [];
                            $rels = Releve::whereDate('created_at', date('Y-m-d'))->get();

                            $total = 0;
                            $i = 0;

                            foreach ($rels as $r1) {
                                # code...
                                $total = $r1->totalPdf;
                                array_push($recettes, $total);
                            }

                            # code...

                        @endphp
                        <script type="text/javascript">
                            var labelss = ["1ère période", "2ème période", "3ème période"];
                            var userss = {!! json_encode($recettes) !!};
                            var backgroundColors = labels.map(label => getRandomColor(0.8));

                            const dataa = {
                                labels: labelss,
                                datasets: [{
                                    label: 'recette ',
                                    backgroundColor: backgroundColors,
                                    // borderColor: 'rgb(255, 99, 132)',
                                    data: userss,
                                }]
                            };

                            const configg = {
                                type: 'bar',
                                data: dataa,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                    }
                                }
                            };

                            new Chart(
                                document.getElementById('myChart2'),
                                configg
                            );
                        </script>
                    </div>
                </div>
            </div>


        </div>
    @else
        {{-- <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Caisse</h3>
            <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div> --}}
        <script>
            window.location.href = "/releve/create"
        </script>
    @endif
@endsection
