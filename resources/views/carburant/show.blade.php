@extends('layouts.app')

@section('template_title')
    {{ $carburant->name ?? "{{ __('Show') Carburant" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Carburant</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('carburants.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Titre:</strong>
                            {{ $carburant->titre }}
                        </div>
                        <div class="form-group">
                            <strong>Prixa:</strong>
                            {{ $carburant->prixA }}
                        </div>
                        <div class="form-group">
                            <strong>Prixv:</strong>
                            {{ $carburant->prixV }}
                        </div>
                        <div class="form-group">
                            <strong>Qtitestk:</strong>
                            {{ $carburant->qtiteStk }}
                        </div>
                        <div class="form-group">
                            <strong>Qtitejg:</strong>
                            {{ $carburant->qtiteJg }}
                        </div>
                        <div class="form-group">
                            <strong>Seuil:</strong>
                            {{ $carburant->seuil }}
                        </div>
                        <div class="form-group">
                            <strong>Valeur Stock:</strong>
                            {{ $carburant->valeur_stock }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
