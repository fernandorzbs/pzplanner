@extends('admin.layout.register')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .radix{
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }
</style>
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-4 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <p class="text-center">
                                        <img src="{{ asset('admins/img/whatzaby-dark.svg') }}" alt="WHATZABY" class="mb-3" width="240">
                                    </p>
                                    <p class="text-left mb-4">
                                        ¡Bienvenido!</br>
                                        Por favor ingrese sus datos de acceso
                                    </p>
                                    <form class="forms-sample" action="{{ route('admin.login.post') }}" method="POST">
                                        @csrf
                                        <x-input-text title="Dirección de correo" id="email" type="email" placeholder="E-mail" />
                                        <x-input-text title="Contraseña" id="password" type="password" placeholder="Su contraseña" />
                                        @if(session('mensaje'))
                                            <p class="alert alert-danger py-2">{{session('mensaje')}}</p>
                                        @endif
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary btn-icon-text mb-2 mb-md-0 w-100"><i class="zwicon zwicon-store"></i> Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection