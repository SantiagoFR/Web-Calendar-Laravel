@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            
            <p>Bienvenido, {{ Auth::user()->name }}</p>
        </div>
    </div>
</div>
@endsection
