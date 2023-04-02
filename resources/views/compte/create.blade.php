@extends('dashboard.base')

@section('title')
    {{ __('Create') }} Compte
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Compte</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('comptes.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('compte.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
