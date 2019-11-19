@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Etiquetas</h1>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Administracion de etiquetas</h2>
                </div>
                <div class="col-sm-6">
                    <button id="newEtiqueta" class="btn btn-primary">Crear etiqueta</button>
                </div>
            </div>
        </div>
        <table class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($etiquetas as $etiqueta)
                <tr>
                    <td>{{ $etiqueta->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#newEtiqueta').click(function(){
            Swal.fire({
                title: "titulo",           
            });
        })
    });
    
</script>
@endsection