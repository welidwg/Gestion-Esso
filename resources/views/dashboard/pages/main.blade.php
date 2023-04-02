@extends('dashboard/base')
@section('title')
    Accueil
@endsection
@php
    use App\models\Compte;
    use App\Models\Releve;
    use App\Models\Carburant;
    
@endphp
@section('content')
    @if (Auth::user()->role == 0)
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Tableau de bord</h3>
            {{-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block"
                role="button" href="#"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>
        @php
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
        @endforeach
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Montant en compte
                                    </span>
                                </div>
                                @php
                                    
                                    $cp = Compte::first();
                                @endphp
                                <div class="text-dark fw-bold h5 mb-0"><span>{{ $cp ? $cp->montant : '0' }} € </span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-euro-sign fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
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
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Earnings Overview</h6>
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
                        <div class="chart-area"><canvas height="320" style="display: block; width: 572px; height: 320px;"
                                width="572"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-xl-4">
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
