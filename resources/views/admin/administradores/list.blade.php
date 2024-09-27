@extends('admin.layout.app')
@section('push-css')
    
@endsection
@section('content')
{{-- BREADCRUMBS --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
</nav>
{{-- TABLA LISTA --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-bold">Lista de {{$title}}</h6>
            </div>
            <div class="card-body p-0">
                <div class="cont-btns py-2 px-3 mb-2 border-bottom">
                    <x-link type="add" href="{{route('admin.create')}}">Agregar</x-link>
                </div>
                {{-- table-responsive --}}
                <div class="table-responsive p-4">
                    <table id="data-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Avatar</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key)
                            <tr id="tr_{{$key->id}}" class="align-middle">
                                <td>{{ $key->id }}</td>
                                <td>
                                    <img src="{{asset($key->getAvatarUrl('avatar'))}}" width="50">
                                </td>
                                <td>{{ $key->name }}</td>
                                <td>{{ $key->email }}</td>
                                <td>{{ $key->celular }}</td>
                                <td>
                                    <x-link type="edit" href="{{route('admin.edit', $key)}}">Editar</x-link>
                                    <x-btn type="submit" onclick="deleteData({{$key->id}}, this)" style="delete">Eliminar</x-btn>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('push-script')
<script>
    var tblGeneral;
    $(function () {
        tblGeneral = $('#data-table').DataTable({
            "aLengthMenu": [
                [5, 10, 30, -1],
                [5, 10, 30, "All"]
            ],
            "iDisplayLength": 5,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            }
        });
    });
const deleteData = (dataId, trElement) =>{
    Swal.fire({
        title: "Eliminar",
        text: "Desea eliminar este elemento?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
    }).then((result) => {
        if (result.value){
            fetch("{{ route('admin.destroy', '') }}/"+dataId, {
                method: 'DELETE',
                credentials: "same-origin",
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": '{{ csrf_token() }}'
                },
                body : JSON.stringify({
                    'id' : dataId
                })
            }).then((response) => response.json())
            .then((data) => {
                tblGeneral.row( $(trElement).parents('tr')).remove().draw();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                Toast.fire({
                    icon: 'success',
                    title: data.mensaje
                });
            });
        }
    });
}   
</script>
@endsection
