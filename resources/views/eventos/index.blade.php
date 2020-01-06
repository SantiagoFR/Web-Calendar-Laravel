@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Eventos</h1>
    <div class="row justify-content-center">
        <eventos-component logged-user="{{Auth::user()->id}}"></eventos-component>
    </div>
</div>
@endsection