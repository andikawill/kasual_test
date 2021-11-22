@if(Route::current()->getName() == 'spreadsheets.edit')
    {!! Form::hidden('range', (isset($data['spreadsheet']['id'])) ? $data['spreadsheet']['id']+1 : old('id'), ['class' => 'form-control']) !!}
@endif
<!-- First Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', (isset($data['spreadsheet']['first_name'])) ? $data['spreadsheet']['first_name'] : old('first_name'), ['class' => 'form-control']) !!}
</div>

<!-- Last Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', (isset($data['spreadsheet']['last_name'])) ? $data['spreadsheet']['last_name'] : old('last_name'), ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', (isset($data['spreadsheet']['email'])) ? $data['spreadsheet']['email'] : old('email'), ['class' => 'form-control']) !!}
</div>

<!-- Gender Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gender', 'Gender:') !!}
    {!! Form::select('gender', $data['gender'], (isset($data['spreadsheet']['gender'])) ? $data['spreadsheet']['gender'] : old('gender'), ['class' => 'form-control select2']) !!}

</div>

<!-- IP Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip_address', 'IP Address:') !!}
    {!! Form::text('ip_address', (isset($data['spreadsheet']['ip_address'])) ? $data['spreadsheet']['ip_address'] : old('ip_address'), ['class' => 'form-control']) !!}
</div>
