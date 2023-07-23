@extends('dashboard/base')
@section('title')
    Moyenne
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Moyenne consommation par jour (En litres)</p>
                </div>
                <div class="card-body">
                    <form id="get_moyenne_form">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Date debut</strong></label>
                                    <input class="form-control  text-dark" type="date" required id="date_debut"
                                        placeholder="" name="date1" />
                                </div>
                            </div>
                            <div class="col-md-6"><label class="form-label" for=""><strong>Date fin</strong></label>
                                <input class="form-control  text-dark" type="date" required id="date_fin" placeholder=""
                                    name="date2" />
                            </div>
                        </div>

                        <div class="mb-3 text-center ">
                            <button class="btn btn-primary" type="submit">
                                Calculer
                            </button>
                        </div>
                    </form>
                    <div class="row ">
                        <div class="col-6 "><label class="form-label" for=""><strong>Carburant</strong></label>
                        </div>
                        <div class="col-6"><label class="form-label" for=""><strong>Moyenne</strong></label>
                        </div>
                    </div>
                    @foreach ($carburants as $carb)
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">

                                    <input class="form-control bg-light text-dark" type="text" required id=""
                                        placeholder="" name="titre" value="{{ $carb->titre }}" readonly />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3 d-flex">
                                    <input class="form-control bg-light text-dark inputMoyenne" type="number"
                                        step="0.01" required id="{{ $carb->titre }}" value="0" placeholder=""
                                        name="moyenne{{ $carb->id }}" />
                                </div>
                            </div>

                        </div>
                    @endforeach
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('/js/stats.js') }}"></script>
    @endsection
</div>
