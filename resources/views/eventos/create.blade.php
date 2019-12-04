@extends('layouts.app')
@section('content')

<div class="container">

    @if ($errors->any())
    <div class="alert alert-danger">
        <h3>Existen los siguientes errores en el formulario:</h3>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h1>Nuevo evento</h1>
    {!! Form::open(['route'=>'eventos.store']) !!}
    <br>
    <div class="row">
        <div class="col-sm">
            <p><strong>Título</strong></p>
            {!! Form::text('title', old('title'), ['class'=>'form-control']) !!}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm">
            <p><strong>Descripción</strong></p>
            {!! Form::textarea('description', old('description'), ['id'=>'ckeditor']) !!}
        </div>
    </div>
    <br>
    {!! Form::hidden('recursivo', 0) !!}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link active" id="click-unico" href="#" role="button">Evento único</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#" id="click-recursivo" role="button">Evento recursivo</a>

                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="row" id="unico">
                        <div class="col-sm-6">
                            <p><strong>Desde</strong></p>
                            {!! Form::text('start', old('start'), ['class'=>'form-control','id'=>'from']) !!}
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Hasta</strong></p>
                            {!! Form::text('end', old('end'), ['class'=>'form-control','id'=>'to']) !!}
                        </div>
                    </div>
                    <div class="row" id="recursivo" style="display:none">
                        <div class="col-sm-12">
                            <p><strong>Días de la semana</strong></p>
                            {!! Form::select("byweekday[]",
                            ['mo'=>'Lunes','tu'=>'Martes','we'=>'Miércoles','th'=>'Jueves','fr'=>'Viernes','sa'=>'Sábado','su'=>'Domingo'],
                            old('usuarios'), ["class"=>"select2","multiple"=>"multiple"])
                            !!}
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Fecha de inicio</strong></p>
                            {!! Form::text('dtstart', old('dtstart'),
                            ['class'=>'form-control','id'=>'datetimepicker']) !!}

                            <p><strong>Frecuencia</strong></p>
                            {!! Form::select('freq',
                            ['daily'=>'Diariamente','weekly'=>'Semanalmente','monthly'=>'Mensualmente'], old('freq'),
                            ['class'=>'select2']) !!}
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Hasta</strong></p>
                            {!! Form::text('until', old('until'), ['class'=>'form-control','id'=>'datepicker']) !!}

                            <p><strong>Intervalo</strong></p>
                            {!! Form::number('interval', old('interval'), ['class'=>'form-control','min'=>0]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <br>
    <div class="row">
        <div class="col-sm-6">
            <p><strong>Etiqueta</strong></p>
            {!! Form::select('etiqueta', $etiquetas, old('etiqueta'), ['class'=>'select2']) !!}
        </div>
        <div class="col-sm-6">
            <p><strong>Usuarios</strong></p>
            {!! Form::select("users[]", $users, old('users'), ["class"=>"select2","multiple"=>"multiple"])
            !!}

        </div>
    </div>
    <br>
    <div align="center">
        {!! Form::submit('Aceptar', ['class'=>'btn btn-primary']) !!}
        <a href="{{ route('eventos.index') }}" class="btn btn-light">Atrás</a>
    </div>

    {!! Form::close() !!}
</div>
<script type="text/javascript">
    @if(old('recursivo')) 
        $("input[name=recursivo]").val(1);
        $("#click-recursivo").addClass('active');
        $("#click-unico").removeClass('active');
        $("#unico").css('display','none');
        $("#recursivo").css('display',''); 
    @endif
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch:Infinity,
            theme: 'bootstrap4',
        });
    $("#click-recursivo").click(function(e){
        e.preventDefault();
        $("input[name=recursivo]").val(1);
        $(this).addClass('active');
        $("#click-unico").removeClass('active');
        $("#unico").css('display','none');
        $("#recursivo").css('display','');
    })
    $("#click-unico").click(function(e){
        e.preventDefault();
        $("input[name=recursivo]").val(0);
        $(this).addClass('active');
        $("#click-recursivo").removeClass('active');
        $("#recursivo").css('display','none');
        $("#unico").css('display','');
    })
    });

</script>
@include('javascript.ckeditor')
@endsection