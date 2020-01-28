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
                    <div id="carouselExampleControls" class="carousel slide" data-interval="false">
                        <div class="carousel-inner">
                            @php
                                $first=1;
                            @endphp
                            @foreach ($eventos as $evento)
                                @if ($first)
                                    @php
                                        $first=0;
                                    @endphp
                                    <div class="carousel-item active">
                                        <p><strong>{{ $evento->title }}</strong></p>
                                        <p><strong>{!! $evento->description !!}</strong></p>
                                        <p><strong>Desde: </strong> {{ $evento->start }}
                                            <strong>Hasta: </strong>{{ $evento->end }}</p>
                                        @isset($evento->etiqueta)
                                            <p><strong>Etiqueta: </strong>{{ $evento->etiqueta->name }}</p>
                                        @endisset
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        <p><strong>{{ $evento->title }}</strong></p>
                                        <p><strong>{!! $evento->description !!}</strong></p>
                                        <p><strong>Desde: </strong> {{ $evento->start }}
                                            <strong>Hasta: </strong>{{ $evento->end }}</p>
                                        @isset($evento->etiqueta)
                                            <p><strong>Etiqueta: </strong>{{ $evento->etiqueta->name }}</p>
                                        @endisset
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <ol class="carousel-indicators">
                            @php
                                $first=1;
                            @endphp
                            @foreach ($eventos as $key=>$evento)
                                @if ($first)
                                    @php
                                        $first=0;
                                    @endphp
                                    <li data-target="#carouselExampleControls" data-slide-to="{{ $key }}"
                                        class="active"></li>
                                @else
                                    <li data-target="#carouselExampleControls" data-slide-to="{{ $key }}"></li>
                                @endif
                            @endforeach
                        </ol>
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
