@extends('dashboard/base') @section('title')
    Modifer seuil
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Modifier seuil</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('carburant.editSeuil') }}" id="edit_seuil_form">
                        @csrf
                        <div class="row">
                            <div class="col-6"><label class="form-label" for=""><strong>Titre</strong></label>
                            </div>
                            <div class="col-6"><label class="form-label" for=""><strong>Quantite de
                                        seuil</strong></label>
                            </div>
                        </div>
                        @foreach ($carburants as $carb)
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">

                                        <input class="form-control bg-light text-dark" type="text" required
                                            id="" placeholder="" name="titre" value="{{ $carb->titre }}"
                                            readonly />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3 d-flex">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="{{ $carb->seuilA }}" placeholder=""
                                            name="seuil{{ $carb->id }}" />
                                    </div>
                                </div>

                            </div>
                        @endforeach





                        <div class="mb-3 text-center">
                            <button class="btn btn-primary" type="submit">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('/js/carburant.js') }}"></script>
    @endsection
</div>
