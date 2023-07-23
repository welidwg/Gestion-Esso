@extends('dashboard/base')
@section('title')
    Heures
@endsection
@php
    use App\Models\Releve;
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Heures du travail des caissiers</p>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-md-6 d-flex align-items-center">
                            <label for="" class=" w-50">Choisissez le mois : </label>
                            <input type="month" name="" class="form-control " id="mois"
                                value="{{ date('Y-m') }}">
                            <div id="spinner" class="spinner-border mx-2 spinner-border-sm text-success" role="status"
                                style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-1 mt-3">
                        <div class="col-6"><label class="form-label text-size-md"
                                for=""><strong>Caissier</strong></label>
                        </div>
                        <div class="col-6"><label class="form-label text-size-md" for=""><strong>Heures du
                                    travail</strong></label>
                        </div>
                    </div>
                    <div id="container-rows">


                        @foreach ($users as $user)
                            @php
                                $duration = 0;
                                $hours = 0;
                                $minutes = 0;
                                $rels = Releve::where('user_id', $user->id)
                                    ->whereMonth('date_systeme', date('m'))
                                    ->get();
                                foreach ($rels as $r) {
                                    $start = Carbon::parse($r->heure_d);
                                    $end = Carbon::parse($r->heure_f);
                                    $duration += $end->diffInMinutes($start);
                                    $hours = floor($duration / 60);
                                    $minutes = $duration - $hours * 60;
                                }
                            @endphp
                            <div class="row ">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <input class="form-control bg-light text-dark text-size-md" type="text" required
                                            id="" placeholder="" name="nom" value="{{ $user->nom }}"
                                            readonly />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3 d-flex">
                                        <input class="form-control bg-light text-dark inputMoyenne text-size-md"
                                            type="text" step="0.01" required id="user_{{ $user->id }}"
                                            value="{{ $hours . ' heures et ' . $minutes . ' minutes' }}" placeholder=""
                                            name="user_{{ $user->id }}" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <script>
                        $('#mois').on("change", (e) => {
                            $("#spinner").fadeIn();
                            $("#container-rows").html("")
                            axios.get(`/caissier/${e.target.value}/hours`)
                                .then(res => {
                                    $("#spinner").fadeOut();

                                    console.log(res.data)
                                    res.data.map((item, i) => {
                                        $("#container-rows").append(`
                                        <div class="row ">
                                          <div class="col-6">
                                <div class="mb-3">
                                    <input class="form-control bg-light text-size-md text-dark" type="text" required id=""
                                        placeholder="" name="nom" value="${item.nom}" readonly />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3 d-flex">
                                    <input class="form-control bg-light text-size-md text-dark inputMoyenne" type="text"
                                        step="0.01" required id="user_{{ $user->id }}"
                                        value="${item.heures}" placeholder=""
                                        />
                                </div>
                            </div>
                                </div>

                                         `)

                                    })
                                })
                                .catch(err => {
                                    $("#spinner").fadeOut();

                                    console.error(err);
                                })
                        })
                    </script>

                </div>
            </div>
        </div>
        {{-- <script src="{{ asset('/js/user.js') }}"></script> --}}
    </div>
@endsection
