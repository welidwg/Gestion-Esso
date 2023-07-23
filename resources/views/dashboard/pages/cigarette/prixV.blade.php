@extends('dashboard/base') @section('title')
    Modifer prix de vente
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Modifier prix de vente</p>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('cigarette.editPrixV', $cigarette->id) }}"
                        id="edit_prixV_form">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6"><label class="form-label" for=""><strong>Type</strong></label>
                            </div>
                            <div class="col-6"><label class="form-label" for=""><strong>Prix de
                                        vente</strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">

                                    <input class="form-control bg-light text-dark" type="text" required id=""
                                        placeholder="" name="titre" value="{{ $cigarette->type }}" readonly />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3 d-flex">
                                    <input class="form-control text-dark" type="number" step="0.01" required
                                        id="" value="{{ $cigarette->prixV }}" placeholder="" name="prixV" />
                                </div>
                            </div>

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
        <script src="{{ asset('/js/cigarette.js') }}"></script>
    </div>
@endsection
