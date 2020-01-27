@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                {!! Form::open() !!}
                <div class="card">
                    <div class="card-header">Buscador de peticiones</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><strong>Título de la petición</strong></p>
                                {!! Form::text('title', $request->title, ['class' => 'form-control']) !!}

                                <p><strong>Título del evento</strong></p>
                                {!! Form::text('event_title', $request->event_title, ['class' => 'form-control']) !!}

                                <p><strong>Desde</strong></p>
                                {!! Form::text('desde', $request->desde, ['class' => 'form-control','id'=>'from']) !!}
                            </div>
                            <div class="col-sm-6">
                                <p><strong>Comentario de la petición</strong></p>
                                {!! Form::text('description', $request->description, ['class' => 'form-control']) !!}

                                <p><strong>Descripción del evento</strong></p>
                                {!! Form::text('event_description', $request->event_description, ['class' => 'form-control']) !!}

                                <p><strong>Hasta</strong></p>
                                {!! Form::text('hasta', $request->hasta, ['class' => 'form-control','id'=>'to']) !!}
                            </div>
                        </div>
                    </div>
                    <div align="center">
                        <button type="submit" class="btn btn-light">Buscar</button>
                    </div>
                    <br>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Peticiones</h2>
                    </div>
                </div>
            </div>

            <table class="table table-borderless table-bordered">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción del evento</th>
                    <th>Fecha inicio/fin evento</th>
                    <th>Fecha solicitud</th>
                    <th>Etiqueta</th>
                    <th style="width: 300px"></th>
                </tr>
                @foreach($peticiones as $peticion)
                    <tr class="{{$peticion->color}}">
                        <td class="align-middle">{{ $peticion->evento->title }}</td>
                        <td class="align-middle">{!! $peticion->evento->description !!}</td>
                        <td class="align-middle">{{ $peticion->evento->start }} <br> {{ $peticion->evento->end }}</td>
                        <td class="align-middle">{{ $peticion->created_at }}</td>
                        <td class="align-middle">{{ $peticion->evento->etiqueta->name }}</td>
                        <td class="align-middle">
                            <button class="btn btn-secondary btn-sm"
                                    data-toggle="collapse" data-target="#peticion{{$peticion->id}}">Mostrar más
                            </button>
                            @if(!$peticion->confirmed)
                                <a href="{{route('peticions.update',$peticion)}}"
                                   class="btn btn-success btn-sm">Aceptar</a>
                                <a href="{{route('peticions.destroy',$peticion)}}" class="btn btn-danger btn-sm">Rechazar</a>
                            @else
                                @isset($peticion->responsable)
                                <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Confirmado por {{$peticion->responsable->name}}">Conf. por {{$peticion->responsable->name}}</button>
                                @endisset
                            @endif
                        </td>
                    </tr>
                    <tr class="collapse {{$peticion->color}}" id="peticion{{$peticion->id}}">
                        <td colspan="6">
                            <div class="card card-body">
                                <div class="row justify-content-center">
                                    <div class="col-sm">
                                        <p><strong>Petición</strong></p>
                                        <p>{!! $peticion->title !!}</p>
                                        <br>
                                        <p><strong>Comentario de la petición</strong></p>
                                        <p>{!! $peticion->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="text-xs-center">
                {{ $peticiones->appends(request()->input())->links() }}
            </div>


        </div>
    </div>

@endsection
