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
                    @can('administracion')
                    <button id="newEtiqueta" class="btn btn-sm btn-info">Crear etiqueta</button>
                    @endcan
                </div>
            </div>
        </div>
        <table class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Exclusividad</th>
                    <th>Aprobación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($etiquetas as $etiqueta)
                <tr>
                    <td>{{ $etiqueta->name }}</td>
                    <td>@if($etiqueta->exclusive) Si @else No @endif</td>
                    <td>@if($etiqueta->approval) Si @else No @endif</td>
                    <td align="center" style="text-align: right">
                        <button class="btn btn-sm btn-secondary" type="button" onclick="edit({{$etiqueta}})">Editar</button>
                        <a href="{{ route('etiquetas.destroy',$etiqueta) }}" class="btn btn-sm btn-danger">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div align="center">
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Atrás</a>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#newEtiqueta').click(async function(){
            const { value: formValues } = await Swal.fire({
                title: 'Nueva etiqueta',
                html:'<div id="swal2-create">'+
                    '<label for="input1">Nombre</label>'+
                    '<input id="input1" name="name" class="swal2-input">'+
                    '<label for="checkbox1">Exclusividad</label> '+
                    '<input type="checkbox" name="exclusive" value="1" id="checkbox1"><br>'+
                    '<label for="checkbox2">Aprobación</label> '+
                    '<input type="checkbox" name="approval" value="1" id="checkbox2" class="swal2-checkbox">'+
                    '</div>',
                focusConfirm: false,
                confirmButtonText:"Enviar",
                showCancelButton: true,
                cancelButtonText:"Cancelar",
                preConfirm: () => {
                    return {
                        name:document.getElementById('input1').value,
                        exclusive:$('#checkbox1').is(':checked'),
                        approval:$('#checkbox2').is(':checked'),
                    }
                }
            })
            if (formValues) {
                axios.post('/etiquetas',{
                    _method: "POST",
                    formValues: formValues
                }).then(response => {
                    window.location.reload(false);
                });
            }

        })

    });
    async function edit(etiqueta) {
        if(etiqueta.exclusive){
            var checked1 = "checked";
        }else{
            var checked1 = "";
        }
        if(etiqueta.approval){
            var checked2 = "checked";
        }else{
            var checked2 = "";
        }
        const { value: formValues } = await Swal.fire({
            title: 'Editar etiqueta',
            html:'<div id="swal2-create">'+
                '<label for="input1">Nombre</label>'+
                '<input id="input1" name="name" class="swal2-input" value="'+etiqueta.name+'">'+
                '<label for="checkbox1">Exclusividad</label> '+
                '<input type="checkbox" name="exclusive" value="1" id="checkbox1" '+checked1+'><br>'+
                '<label for="checkbox2">Aprobación</label> '+
                '<input type="checkbox" name="approval" value="1" id="checkbox2" class="swal2-checkbox" '+checked2+'>'+
                '</div>',
            focusConfirm: false,
            confirmButtonText:"Enviar",
            showCancelButton: true,
            cancelButtonText:"Cancelar",
            preConfirm: () => {
                return {
                    name:document.getElementById('input1').value,
                    exclusive:$('#checkbox1').is(':checked'),
                    approval:$('#checkbox2').is(':checked'),
                }
            }
        })
        if (formValues) {
            axios.put('/etiquetas/'+etiqueta.id,{
                formValues: formValues
            }).then(response => {
                window.location.reload(false);
            });
        }
    }

</script>
@endsection
