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
    <div class="col">
        @if(session()->has('success'))
            <p class="alert alert-success py-2">{{ session()->get('success') }}</p>
        @elseif (session()->has('error'))
            <p class="alert alert-danger py-2">{{ session()->get('error') }}</p>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-bold">Lista de {{$title}}</h6>
            </div>
            <div class="card-body p-0">
                <div class="py-2 px-3 mb-2 border-bottom d-flex gap-2">
                    <div>
                        <x-link type="export" href="#">Exportar</x-link>
                    </div>
                    
                   
                </div>
                {{-- table-responsive --}}
                <div class="table-responsive p-4">
                    <table id="data-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Avatar</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Celular</th>
                                <th>Confirmado</th>
                                <th>Evento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key)
                            <tr id="tr_{{$key->id}}" class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{asset($key->getAvatar())}}" width="50">
                                </td>
                                <td>{{ $key->nombre }}</td>
                                <td>{{ $key->apellido }}</td>
                                <td>{{ $key->celular }}</td>
                                <td>{!! $key->getConfirmacion() !!}</td>
                                <td>null</td>
                                <td>
                                    <x-link type="edit" href="{{route('contacto.edit', $key)}}">Editar</x-link>
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
            fetch("{{ route('contacto.destroy', '') }}/"+dataId, {
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
