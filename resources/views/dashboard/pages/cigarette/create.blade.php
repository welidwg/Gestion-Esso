@extends('dashboard/base') @section('title')
    Ajouter cigarette
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Ajouter cigarette</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('cigarette.store') }}" id="add_cigarette_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Type</strong></label>
                                    <input class="form-control" type="text" required id="" placeholder=""
                                        name="type" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Quantité</strong></label>
                                    <input class="form-control" type="number" min="1" required id=""
                                        placeholder="" name="qte" />
                                </div>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Prix d'achat
                                            unitaire</strong></label><input class="form-control" type="number"
                                        step="0.01" required min="0.1" id="prixA" placeholder=""
                                        name="prixA" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for=""><strong>Prix du vente unitaire
                                        </strong></label><input class="form-control" type="number" step="0.01" required
                                        id="prixV" placeholder="" min="0.1" name="prixV" />
                                </div>
                            </div>
                        </div>



                        <div class="mb-3 float-end">
                            <button class="btn btn-primary" type="submit">
                                Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('/js/cigarette.js') }}"></script>
    @endsection
</div>
