@extends('layouts.app')
@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {!! Form::model($user, ['route'=>['users.update',$user]]) !!}
    @method('PUT')
    <div class="row justify-content-center">
        <div class="col-sm-8">

    <div class="table-wrapper">

            <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>EDITAR USUARIO</h2>
                        </div>
                        <div class="col-sm-6">
                            <button id="newEtiqueta" class="btn btn-primary">Crear etiqueta</button>
                        </div>
                    </div>
                </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        {!! Form::label('name', 'Nombre', ['class'=>'col-sm-3 col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('name', old('name'), ['class'=>'form-control']) !!}
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('username', 'Usuario', ['class'=>'col-sm-3 col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('username', old('username'), ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('email', 'Email', ['class'=>'col-sm-3 col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::email('email', old('email'), ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('password', 'Contraseña', ['class'=>'col-sm-3 col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::password('password', ['class'=>'form-control']) !!}
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        {!! Form::label('password_confirmation', 'Repita contraseña', ['class'=>'col-sm-3
                        col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::password('password_confirmation', ["class"=>"form-control"]) !!}
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
            <br>

            <div align="center">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Atrás</a>
                <button class="btn btn-success" type="submit">Actualizar</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}

</div>
@endsection