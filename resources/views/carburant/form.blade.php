<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('titre') }}
            {{ Form::text('titre', $carburant->titre, ['class' => 'form-control' . ($errors->has('titre') ? ' is-invalid' : ''), 'placeholder' => 'Titre']) }}
            {!! $errors->first('titre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('prixA') }}
            {{ Form::text('prixA', $carburant->prixA, ['class' => 'form-control' . ($errors->has('prixA') ? ' is-invalid' : ''), 'placeholder' => 'Prixa']) }}
            {!! $errors->first('prixA', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('prixV') }}
            {{ Form::text('prixV', $carburant->prixV, ['class' => 'form-control' . ($errors->has('prixV') ? ' is-invalid' : ''), 'placeholder' => 'Prixv']) }}
            {!! $errors->first('prixV', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('qtiteStk') }}
            {{ Form::text('qtiteStk', $carburant->qtiteStk, ['class' => 'form-control' . ($errors->has('qtiteStk') ? ' is-invalid' : ''), 'placeholder' => 'Qtitestk']) }}
            {!! $errors->first('qtiteStk', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('qtiteJg') }}
            {{ Form::text('qtiteJg', $carburant->qtiteJg, ['class' => 'form-control' . ($errors->has('qtiteJg') ? ' is-invalid' : ''), 'placeholder' => 'Qtitejg']) }}
            {!! $errors->first('qtiteJg', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('seuil') }}
            {{ Form::text('seuil', $carburant->seuil, ['class' => 'form-control' . ($errors->has('seuil') ? ' is-invalid' : ''), 'placeholder' => 'Seuil']) }}
            {!! $errors->first('seuil', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('valeur_stock') }}
            {{ Form::number('valeur_stock', $carburant->valeur_stock, ['class' => 'form-control' . ($errors->has('valeur_stock') ? ' is-invalid' : ''), 'placeholder' => 'Valeur Stock']) }}
            {!! $errors->first('valeur_stock', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('crud.Submit') }}</button>
    </div>
</div>
