@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Eventos</h1>
    <div class="row justify-content-center">
        <div class="col-sm-3">
            <p><strong>Búsqueda por usuario</strong></p>
            {!! Form::select('usuario', $usuarios, Auth::user()->id, ['class'=>'select2']) !!}
            <p><strong>Búsqueda por etiqueta</strong></p>
            {!! Form::select('etiqueta', $etiquetas, "", ['class'=>'select2']) !!}
        </div>
        <div class="col-sm-9">
            <eventos-component logged-user = "{{Auth::user()->id}}"></eventos-component>
        </div>
    </div>
</div>
@endsection