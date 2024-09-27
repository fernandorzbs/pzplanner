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
        <li class="breadcrumb-item"><a href="{{route('campana.index')}}">{{$from}}</a></li>
        <li class="breadcrumb-item active">Agregar</li>
    </ol>
</nav> 
{{-- CARD CONTENIDO MAIN --}}
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-normal">Crear <strong>Campaña</strong></h6>
            </div>
            <div class="card-body">
                <form action="{{route('campana.update', $Data)}}" id="formDropzone" method="POST" enctype="multipart/form-data" novalidate>
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
                            <x-input-text title="Nombre del evento" id="nombre" value="{{$Data->nombre}}" />
                            <div class="col">
                                <label for="fecha" class="form-label">Fecha del evento:</label>
                                <div class="input-group flatpickr" id="flatpickr-date">
                                    <input type="text" id="fecha" name="fecha" class="form-control" placeholder="Seleccionar fecha" data-input value="{{$Data->fecha}}">
                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                </div>
                                @error('fecha')
                                    <style>
                                        #fecha{
                                            border : 1px solid red;
                                        }
                                    </style>
                                    <p class="alert alert-danger py-2 mt-2">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between py-2">
                <x-link href="{{route('campana.index')}}" type="back">Atrás</x-link>
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
        const flatpickrDateEl = document.querySelector('#flatpickr-date');
        if(flatpickrDateEl) {
            flatpickr("#flatpickr-date", {
            wrap: true,
            dateFormat: "Y-m-d",
            });
        }
    });
</script>
@endpush