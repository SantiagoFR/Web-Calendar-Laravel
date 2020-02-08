@extends('layouts.app')
@section('content')
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Administracion de usuarios</h2>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-info">Crear usuario</a>
                </div>
            </div>
        </div>

        <users-component></users-component>
    </div>

</div>
@endsection
