@extends('dashboard/base') @section('title')
    Modifer jauge
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Modifier jauge</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('carburant.editJauge') }}"id="edit_jauge_form">
                        @csrf
                        <div class="row">
                            <div class="col-6"><label class="form-label" for=""><strong>Titre</strong></label>
                            </div>
                            <div class="col-6"><label class="form-label" for=""><strong>Quantite de
                                        jauge</strong></label>
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
                                    <div class="mb-3 d-flex flex-column">
                                        <input class="form-control text-dark " type="number" step="0.01" required
                                            id="" value="{{ $carb->qtiteJg }}" placeholder=""
                                            name="qtiteJg{{ $carb->id }}" />
                                        <span class="small mx-2"><span class="fw-bold">Valeur calculé:</span>
                                            {{ $carb->qtiteStk }} Litres </span>
                                    </div>
                                </div>


                            </div>
                        @endforeach


                        <div class="form-check mb-2 ">
                            <input class="form-check-input" type="checkbox" value="" name="ecraser"
                                id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Ecraser les valeur calculés ?
                            </label>
                        </div>


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
