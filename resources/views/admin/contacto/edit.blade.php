@extends('admin.layout.app')
@section('push-css')
<style>
#previewImage {
    width: 150px;
    height: 150px;
    object-fit: cover; /* Esto asegurará que la imagen se mantenga cuadrada y recorte el exceso */
    border: 1px solid #ddd; /* Opcional: para darle un borde */
}
</style>
@endsection
@section('content')
{{-- BREADCRUMBS --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('contacto.index')}}">{{$from}}</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav> 
{{-- CARD CONTENIDO MAIN --}}
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-normal">Editar <strong>Contacto</strong></h6>
            </div>
            <div class="card-body">
                <form action="{{route('contacto.update', $data)}}" id="formDropzone" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
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
                        <div class="col">
                            <x-input-text title="Nombre" id="nombre" value="{!! $data->nombre !!}" />
                            <x-input-text title="Apellido" id="apellido" value="{!! $data->apellido !!}" />
                            <x-input-text title="Correo" id="email" value="{!! $data->email !!}" />
                            <x-input-text title="Celular" id="celular" value="{{ $data->celular }}" />
                            
                            <x-input-text title="Confirmado" id="confirmado" value="{{ $data->confirmado }}" />
                        </div>

                        <div class="col bg-gris border rounded p-3">
                            <div class="form-group mb-4">
                                <p class="form-label fw-medium">Foto de perfil:</p>
                                <p class="text-center mb-3">
                                    <img class="rounded-circle border" width="140" id="previewImage" src="{{asset($data->getAvatar())}}" alt="Preview">
                                </p>
                                <input class="form-control" type="file" id="formFile" name="profile_image" accept="image/*">
                            </div>
                            <div class="alert alert-warning" role="alert">
                                Se recomienda que las imagenes deben ser de 1:1 ejemplo (300x300) en adelante con un formato de jpg, png, jpeg, webp no mayor a 3MB
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between py-2">
                <x-link href="{{route('contacto.index')}}" type="back">Atrás</x-link>
                <x-btn type="submit" form="formDropzone" id="formSubmit" style="save">Guardar</x-btn>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script>
    $(document).ready(function() {
        $('#formFile').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewImage').attr('src', e.target.result);
                    $('#previewImage').removeClass('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                $('#previewImage').addClass('d-none');
            }
        });
    });
</script>
@endpush