@extends('dashboard/base')
@section('title')
    Ajouter caissier
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Ajouter un utilisteur</p>
                </div>
                <div class="card-body">
                    <form class="">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3"><label class="form-label" for="username"><strong>Nom
                                            d'utilisateur</strong></label><input class="form-control" type="text"
                                        id="username" placeholder="" name="username"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3"><label class="form-label" for="email"><strong> Mot de
                                            passe</strong></label><input class="form-control" type="text" id="email"
                                        placeholder="" name="email"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3"><label class="form-label" for="first_name"><strong>
                                            Type
                                            d'utilisateur</strong></label>
                                    <select class="form-select">
                                        <option value="0">Administrateur</option>
                                        <option value="1">Caissier</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3 float-end "><button class="btn btn-primary " type="submit">Ajouter</button>

                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
</div @endsection
