@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h4>Bienvenido, {{ Auth::user()->name }}</h4>
                @if($eventos->count()!=0)
                    <p>Estos son los eventos más próximos a los que estás convocado</p>
                @else
                    <p>No tienes eventos pendientes</p>
                @endif
            </div>
        </div>
        <br>
        @if($eventos->count()!=0)
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div id="carouselExampleControls" class="carousel vert slide" data-ride="carousel" data-interval="2700">
                    <ol class="carousel-indicators">
                        @foreach ($eventos as $evento)
                            @if ($evento->id == $eventos->first()->id)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $evento->id }}"
                                    class="active"></li>
                            @else
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $evento->id }}"></li>
                            @endif
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach ($eventos as $evento)
                            @if ($evento->id == $eventos->first()->id)
                                <div class="carousel-item active">
                                    @if ($evento->rrule_data==null)
                                        <p><strong>{{ $evento->title }}</strong></p>
                                        <p><strong>{!! $evento->description !!}</strong></p>
                                        <p><strong>Desde: </strong> {{ $evento->start }}
                                            <strong>Hasta: </strong>{{ $evento->end }}</p>
                                        @isset($evento->etiqueta)
                                            <p><strong>Etiqueta: </strong>{{ $evento->etiqueta->name }}</p>
                                        @endisset
                                    @else
                                        <p><strong>{{ $evento->title }}</strong></p>
                                        <p><strong>{!! $evento->description !!}</strong></p>
                                        <p><strong>Desde: </strong> {{ $evento->dtstart }}
                                            <strong>Hasta: </strong>{{ $evento->end }}
                                        </p>
                                        @isset($evento->etiqueta)
                                            <p><strong>Etiqueta: </strong>{{ $evento->etiqueta->name }}</p>
                                        @endisset
                                    @endif
                                </div>
                            @else
                                <div class="carousel-item">
                                    @if ($evento->rrule_data==null)
                                        <p><strong>{{ $evento->title }}</strong></p>
                                        <p><strong>{!! $evento->description !!}</strong></p>
                                        @isset($evento->etiqueta)
                                            <p><strong>Etiqueta: </strong>{{ $evento->etiqueta->name }}</p>
                                        @endisset
                                    @else
                                        <p><strong>{{ $evento->title }}</strong></p>
                                        <p><strong>{!! $evento->description !!}</strong></p>
                                        <p><strong>Desde: </strong> {{ $evento->dtstart }}
                                            <strong>Hasta: </strong>{{ $evento->end }}
                                        </p>
                                        @isset($evento->etiqueta)
                                            <p><strong>Etiqueta: </strong>{{ $evento->etiqueta->name }}</p>
                                        @endisset
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        @endif
    </div>
@endsection
