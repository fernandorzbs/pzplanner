@extends('admin.layout.app')
@section('push-css')
<style>
/* #mensaje_ifr .mce-content-body p{
    margin: 0 !important;
} */
</style>
@endsection
@section('content')
{{-- BREADCRUMBS --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('campana.index')}}">{{$from}}</a></li>
        <li class="breadcrumb-item active">{{$Data->nombre}}</li>
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
    <div class="col-md-4">
        <div class="card">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col pt-1">
                        <div class="py-2 px-3 mb-2 border-bottom ">
                            <form action="{{ route('contactos.import', $Data) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <input type="file" name="file" id="file" class="d-none" onchange="document.getElementById('uploadForm').submit();" required>
                                <button type="button" class="btn btn-primary w-100" onclick="document.getElementById('file').click();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor-up"><path d="m9 10 3-3 3 3"/><path d="M12 13V7"/><rect width="20" height="14" x="2" y="3" rx="2"/><path d="M12 17v4"/><path d="M8 21h8"/></svg>
                                    Importar contactos
                                </button>
                            </form>  
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <form action="{{ route('campana.sendmensajewhatsap', $Data) }}" method="POST" enctype="multipart/form-data" id="sendmensaje">
                        @csrf
                        <div class="py-2 px-3">
                            <div class="mb-3">
                                <x-input-select title="Destinatario" id="destinatario" displayKey="name" :list="$filtroObjeto" />
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5"></textarea>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between py-2">
                <x-link href="{{route('campana.index')}}" type="back">Atrás</x-link>
                <x-btn type="submit" form="sendmensaje" id="sendmensaje" style="send">Enviar</x-btn>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-bold">Total de invitados {{ $Invitados }}</h6>
            </div>
            <div class="card-body p-0">
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
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invitadoData as $key)
                            <tr id="tr_{{$key->id}}" class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{asset($key->getAvatar())}}" width="50">
                                </td>
                                <td>{{ $key->nombre }}</td>
                                <td>{{ $key->apellido }}</td>
                                <td>{{ $key->getFormateado() }}</td>
                                <td>{!! $key->getConfirmacion() !!}</td>
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
<script src="https://cdn.tiny.cloud/1/lgeo6zfomd0cthizw0lgwsrgqa81l0oq9sjzs7lkeo3sosl6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#mensaje',
        plugins: 'lists emoticons',
        toolbar: 'undo redo | emoticons | numlist bullist | bold italic underline strikethrough',
        content_style: 'p { margin: 0; }'
    });
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
