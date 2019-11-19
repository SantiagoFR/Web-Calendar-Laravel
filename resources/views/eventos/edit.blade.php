@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar evento</h1>
    {!! Form::model($evento,['route'=>['eventos.update',$evento]]) !!}
    @method('PUT')
    <div class="row">
        <div class="col-sm">
            <p><strong>Título</strong></p>
            {!! Form::text('title', old('title'), ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <p><strong>Descripción</strong></p>            
            {!! Form::textarea('description', old('description'), ['id'=>'ckeditor']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <p><strong>Desde</strong></p>
            {!! Form::text('start', old('start'), ['class'=>'form-control','id'=>'from']) !!}

        </div>
        <div class="col-sm-6">
            <p><strong>Hasta</strong></p>
            {!! Form::text('end', old('end'), ['class'=>'form-control','id'=>'to']) !!}
        </div>
    </div>
    
    <br>
    <div align="center">
        {!! Form::submit('Aceptar', ['class'=>'btn btn-primary']) !!}
        <a href="{{ route('eventos.index') }}" class="btn btn-light">Atrás</a>
    </div>   

    {!! Form::close() !!}
</div>
@include('javascript.ckeditor')
@endsection