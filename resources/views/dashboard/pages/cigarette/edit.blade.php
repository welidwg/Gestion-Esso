@extends('dashboard/base')
@section('title')
    Modifier type de cigarette
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Modifier cigarette</p>
                </div>
                <div class="card-body">
                    <form class="" action="{{ route('cigarette.update', $cigarette->id) }}" method="POST"
                        id="edit_cigars_form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3"><label class="form-label" for="username"><strong>Type du
                                            cigarette</strong></label><input class="form-control" type="text" required
                                        id="type" value="{{ $cigarette->type }}" placeholder="" name="type">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="email"><strong>Prix du vente unitaire</strong>
                                    </label>
                                    <input class="form-control" type="password" id="password" placeholder=""
                                        name="password">

                                </div>
                                <div class="text-danger errors" id="password_error"></div>

                            </div>
                            {{-- <div class="col-md-6">
                                <div class="mb-3"><label class="form-label" for="username"><strong>Code
                                        </strong></label><input class="form-control" type="text"
                                        value="{{ $user->code }}" required id="code" placeholder="" readonly
                                        name="code">
                                </div>
                                <div class="text-danger errors" id="code_error"></div>
                            </div> --}}

                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3"><label class="form-label"
                                        for="username"><strong>Login</strong></label><input class="form-control"
                                        type="text" required id="login" readonly placeholder=""
                                        value="{{ $user->login }}" name="login"></div>
                                <div class="text-danger errors" id="username_error"></div>

                            </div>


                        </div> --}}

                        <div class="mb-3 float-end "><button class="btn btn-primary " type="submit">Modifier</button>

                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
    <script src="{{ asset('/js/user.js') }}"></script>
@endsection
