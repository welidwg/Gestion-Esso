<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('montant') }}
            {{ Form::text('montant', $compte->montant, ['class' => 'form-control' . ($errors->has('montant') ? ' is-invalid' : ''), 'placeholder' => 'Montant']) }}
            {!! $errors->first('montant', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>