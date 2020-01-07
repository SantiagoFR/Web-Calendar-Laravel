@extends('layouts.app')
@section('content')

    <div class="container">
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
                    <th>Titulo de la petición</th>
                    <th>Fecha inicio/fin</th>
                    <th>Etiqueta</th>
                    <th style="width: 300px"></th>
                </tr>
                @foreach($peticiones as $peticion)
                    <tr class="{{$peticion->color}}">
                        <td class="align-middle">{{ $peticion->evento->title }}</td>
                        <td class="align-middle">{{ $peticion->title }}</td>
                        <td class="align-middle">{{ $peticion->evento->start }} <br> {{ $peticion->evento->end }}</td>
                        <td class="align-middle">{{ $peticion->evento->etiqueta->name }}</td>
                        <td class="align-middle">
                            <button class="btn btn-secondary btn-sm"
                                    data-toggle="collapse" data-target="#peticion{{$peticion->id}}">Mostrar más
                            </button>
                            @if(!$peticion->confirmed)
                                <a href="{{route('peticions.update',$peticion)}}"
                                   class="btn btn-success btn-sm">Aceptar</a>
                                <a href="{{route('peticions.destroy',$peticion)}}" class="btn btn-danger btn-sm">Rechazar</a>
                            @endif
                        </td>
                    </tr>
                    <tr class="collapse {{$peticion->color}}" id="peticion{{$peticion->id}}">
                        <td colspan="5">
                            <div class="card card-body">
                                <div class="row justify-content-center">
                                    <div class="col-sm">
                                        <p><strong>Descripción del evento</strong></p>
                                        <p>{!! $peticion->evento->description !!}</p>
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

        </div>

@endsection
