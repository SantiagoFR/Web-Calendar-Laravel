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
        <h1>Editar evento</h1>
        {!! Form::model($evento,['route'=>['eventos.update',$evento]]) !!}
        @method('PUT')
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
                        @if($evento->etiqueta->approval)
                            <p style="font-size:13px;text-align:right">*</p>
                        @endif
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
                            <div class="col-sm-6">
                                <p><strong>Fecha de inicio</strong></p>
                                {!! Form::text('dtstart', old('dtstart'),
                                ['class'=>'form-control','id'=>'datetimepicker']) !!}

                                <p><strong>Frecuencia</strong></p>
                                {!! Form::select('freq',
                                ['day'=>'Diariamente','week'=>'Semanalmente','month'=>'Mensualmente'],
                                $evento->rrule['freq'],
                                ['class'=>'select2']) !!}
                            </div>
                            <div class="col-sm-6">
                                <p><strong>Hasta</strong></p>
                                {!! Form::text('until', old('until'),
                                ['class'=>'form-control','id'=>'datepicker']) !!}

                                <p><strong>Intervalo</strong></p>
                                {!! Form::number('interval', $evento->rrule['interval'], ['class'=>'form-control','min'=>0])
                                !!}
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
                <div class="row">
                    <div class="col-sm-4"><p><strong>Etiqueta</strong></p></div>
                    <div class="col-sm-8"><p style="font-size:13px;text-align:right">*Una vez creado el evento no se
                            puede cambiar la etiqueta</p></div>
                </div>
                {!! Form::select('etiqueta', $etiquetas, $evento->etiqueta_id, ['class'=>'select2','disabled','true']) !!}
                {!! Form::hidden('etiqueta', $evento->etiqueta_id,['id'=>'etiquetas'] ) !!}
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
        @if(old('recursivo') || $evento->rrule!=null)
        $("input[name=recursivo]").val(1);
        $("#click-recursivo").addClass('active');
        $("#click-unico").removeClass('active');
        $("#unico").css('display', 'none');
        $("#recursivo").css('display', '');
        @endif
        $(document).ready(function () {
            $('.select2').select2({
                minimumResultsForSearch: Infinity,
                theme: 'bootstrap4',
            });
            $("#click-recursivo").click(function (e) {
                e.preventDefault();
                $("input[name=recursivo]").val(1);
                $(this).addClass('active');
                $("#click-unico").removeClass('active');
                $("#unico").css('display', 'none');
                $("#recursivo").css('display', '');
            })
            $("#click-unico").click(function (e) {
                e.preventDefault();
                $("input[name=recursivo]").val(0);
                $(this).addClass('active');
                $("#click-recursivo").removeClass('active');
                $("#recursivo").css('display', 'none');
                $("#unico").css('display', '');
            })
            fetch("/etiquetas/" + $("#etiquetas").val() + "/needApproval", {
                method: 'get'
            })
                .then(response => response.json())
                .then(jsonData => {
                    console.log(jsonData)
                    if (jsonData) {
                        $('#from').attr('readonly', 'true');
                        $('#to').attr('readonly', 'true')
                        $("select[name=freq]").select2({
                            disabled: true,
                            theme: 'bootstrap4',
                        });
                        $('input[name=interval]').attr('readonly', 'true');
                        $('input[name=dtstart]').attr('readonly', 'true')
                        $('input[name=until]').attr('readonly', 'true');
                        $('#from').datetimepicker('destroy');
                        $('#to').datetimepicker('destroy');
                        $('input[name=dtstart]').datetimepicker('destroy');
                        $('input[name=until]').datetimepicker('destroy');
                    } else {
                    }
                });
        });


        window.onload = function () {
            CKEDITOR.replace('ckeditor');
        };
    </script>
@endsection
