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
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h1>Crear usuario</h1>
                </div>
                {!! Form::open(['route'=>'users.store']) !!}
                <div class="card-body">
                    <div class="form-group row">
                        {!! Form::label('name', 'Nombre', ['class'=>'col-sm-3 col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('name', old('name'), ['class'=>'form-control']) !!}                         
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('username', 'Nombre de usuario', ['class'=>'col-sm-3 col-form-label']) !!}
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
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('password_confirmation', 'Repita contraseña', ['class'=>'col-sm-3
                        col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::password('password_confirmation', ["class"=>"form-control"]) !!}                         
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('permiso', 'Permisos', ['class'=>'col-sm-3
                        col-form-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('permisos[]', $permisos, old('permisos'), ['class'=>'select2-multi','multiple'=>true]) !!}                     
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div align="center">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Atrás</a>
                        <button class="btn btn-success" type="submit">Crear</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</div>
@endsection