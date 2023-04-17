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
    @if (Auth::user()->role == 0)
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Tableau de bord</h3>
            {{-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block"
                role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>
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
        <div class="">
            <div class="row ">
                <div class="col-md-6 col-xl-3 mb-4 ">
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
                </div>
                <div class="col-md-6 col-xl-3 mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Recette
                                            d'aujourd'hui
                                        </span>
                                    </div>
                                    @php
                                        $recette = 0;
                                        
                                        $releves = Releve::where('date_systeme', date('Y-m-d'))->get();
                                        foreach ($releves as $rel) {
                                            $recette += $rel->totalPdf;
                                            # code...
                                        }
                                    @endphp
                                    <div class="text-dark fw-bold h5 mb-2"><span>{{ $recette }} € </span></div>
                                    <div class="text-dark  mb-0"></div>

                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-danger fw-bold text-xs mb-1"><span>Total TVA achat
                                            (mois {{ date('m') }})
                                        </span>
                                    </div>
                                    @php
                                        $tva_achat = 0;
                                        $facts = Facture::whereMonth('date_facture', date('m'))->get();
                                        $achats = AchatCigarette::whereMonth('date_achat', date('m'))->get();
                                        foreach ($facts as $facture) {
                                            # code...
                                            $tva_achat += $facture->montant * 0.2;
                                        }
                                        foreach ($achats as $achat) {
                                            # code...
                                            $tva_achat += $achat->total * 0.2;
                                        }
                                    @endphp

                                    <div class="text-dark fw-bold h5 mb-2 "><span>{{ $tva_achat }} € </span></div>
                                    <div class="text-dark  mb-0"></div>

                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4 ">
                    <div class="card shadow border-start-primary py-2 h-100">
                        <div class="card-body h-100">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Total TVA encaissé
                                            (mois {{ date('m') }})
                                        </span>
                                    </div>
                                    @php
                                        $tva = 0;
                                        $relTva = Releve::whereMonth('date_systeme', date('m'))->get();
                                        foreach ($relTva as $r) {
                                            $tva += $r->tva;
                                        }
                                    @endphp

                                    <div class="text-dark fw-bold h5 mb-2"><span>{{ $tva }} € </span></div>
                                    <div class="text-dark  mb-0"></div>

                                </div>
                                <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
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
        <div class="row">
            <div class="col-lg-6 col-xl-6 mb-3">
                <div class="card shadow mb-4 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Recette par carburant (en € ) </h6>
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
                                $releves1 = Releve::all();
                                foreach ($releves1 as $r) {
                                    $ventes = json_decode($r->vente);
                                    if ($ventes != null) {
                                        foreach ($ventes as $vente) {
                                            foreach ($vente as $k => $v) {
                                                if ($k == $carb->titre) {
                                                    if ($v->montant != 0) {
                                                        $total += $v->qte * $carb->prixV;
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
                            console.log(users);

                            const data = {
                                labels: labels,
                                datasets: [{
                                    label: 'recette ',
                                    // backgroundColor: 'rgb(255, 99, 132)',
                                    // borderColor: 'rgb(255, 99, 132)',
                                    data: users,
                                }]
                            };

                            const config = {
                                type: 'bar',
                                data: data,
                                options: {}
                            };

                            const myChart = new Chart(
                                document.getElementById('myChart'),
                                config
                            );
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6 mb-3">
                <div class="card shadow mb-4 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Recette par caissier (en € )</h6>
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
                            <canvas height="auto" id="myChart2"></canvas>
                        </div>
                        @php
                            $users = [];
                            $recettes = [];
                            $usrs = User::where('role', 1)->get();
                            $total = 0;
                            foreach ($usrs as $user) {
                                array_push($users, $user->nom);
                                $rel1 = Releve::where('user_id', $user->id)->get();
                                foreach ($rel1 as $r1) {
                                    # code...
                                    $total += $r1->totalPdf;
                                }
                                array_push($recettes, $total);
                                $total = 0;
                            
                                # code...
                            }
                            
                        @endphp
                        <script type="text/javascript">
                            var labelss = {!! json_encode($users) !!};
                            var userss = {!! json_encode($recettes) !!};
                            console.log(users);

                            const dataa = {
                                labels: labelss,
                                datasets: [{
                                    label: 'recette ',
                                    // backgroundColor: 'rgb(255, 99, 132)',
                                    // borderColor: 'rgb(255, 99, 132)',
                                    data: userss,
                                }]
                            };

                            const configg = {
                                type: 'bar',
                                data: dataa,
                                options: {}
                            };

                            const myChartt = new Chart(
                                document.getElementById('myChart2'),
                                configg
                            );
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-12 mb-3">
                <div class="card shadow mb-4" style="display: block;position: relative;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Recette par cigarettes (TOP 5 en € )</h6>
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
                        <div class="" style="display: block;position: relative;">
                            <canvas id="myChart3" height="100px"></canvas>
                        </div>
                        @php
                            $cigarettes = [];
                            $recettes = [];
                            $cigars = Cigarette::all();
                            $title = '';
                            $total = 0;
                            $finalLabels = [];
                            $finalRecettes = [];
                            $labels = [];
                            $f = [];
                            // $releves1 = Releve::all();
                            
                            foreach ($cigars as $cigar) {
                                $releves1 = Releve::all();
                                array_push($cigarettes, $cigar->type);
                                if ($releves1->count() != 0) {
                                    foreach ($releves1 as $r) {
                                        $ventes = json_decode($r->vente_cigarette);
                                        if ($ventes != null) {
                                            foreach ($ventes as $vente) {
                                                foreach ($vente as $k => $v) {
                                                    if ($k == $cigar->type) {
                                                        if ($v->qte != 0) {
                                                            $total += $v->qte * $cigar->prixV;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    array_push($f, [$cigar->type => $total]);
                            
                                    array_push($recettes, $total);
                                    $total = 0;
                                }
                            }
                            if (count($f) != 0) {
                                foreach ($f as $key => $row) {
                                    $values[$key] = current($row);
                                }
                                array_multisort($values, SORT_DESC, $f);
                                foreach ($f as $ff) {
                                    foreach ($ff as $key => $value) {
                                        array_push($labels, $key);
                                    }
                                    # code...
                                }
                            }
                            
                            rsort($recettes);
                            for ($i = 0; $i < 5; $i++) {
                                if (isset($f[$i])) {
                                    array_push($finalRecettes, $f[$i]);
                                }
                                if (isset($labels[$i])) {
                                    array_push($finalLabels, $labels[$i]);
                                }
                            }
                            
                        @endphp
                        <script type="text/javascript">
                            var labelsCigars = {!! json_encode($finalLabels) !!};
                            var dataCigars = {!! json_encode($recettes) !!};

                            const dataa1 = {
                                labels: labelsCigars,
                                datasets: [{
                                    label: 'recette ',
                                    // backgroundColor: 'rgb(255, 99, 132)',
                                    // borderColor: 'rgb(255, 99, 132)',
                                    data: dataCigars,
                                }]
                            };

                            const configg1 = {
                                type: 'bar',
                                data: dataa1,
                                options: {
                                    // scales: {
                                    //     x: {
                                    //         display: false
                                    //     }
                                    // }
                                }
                            };

                            const myChartt1 = new Chart(
                                document.getElementById('myChart3'),
                                configg1
                            );
                        </script>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-5 col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Consommation moyenne par jour ( {{ date('m/Y') }})</h6>
                        <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle"
                                aria-expanded="false" data-bs-toggle="dropdown" type="button"><i
                                    class="fas fa-ellipsis-v text-gray-400"></i></button>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item"
                                    href="#"> Action</a><a class="dropdown-item" href="#"> Another action</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"> Something else
                                    here</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row d-flex justify-content-center ">
                            @foreach ($carbs as $carb)
                                <div class="col-md-6 m-2">{{ $carb->titre }}</div>
                                <div class="col-md-3 text-center">
                                    <div class="badge bg-success w-100 ">
                                        {{ count($moyennes) > 0 ? $moyennes[$carb->titre] / $dates->count() : 0 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div> --}}
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
