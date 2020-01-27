@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Eventos</h1>
    <div class="row justify-content-center">
        <eventos-component logged-user="{{Auth::user()->id}}" admin="{{Auth::user()->can('admin')}}"></eventos-component>
    </div>
</div>
<script>
    @cannot('administracion')
        $(document).ready(function(){
            $(".fc-etiquetasButton-button").remove();
        })
    @endcannot
</script>
@endsection
