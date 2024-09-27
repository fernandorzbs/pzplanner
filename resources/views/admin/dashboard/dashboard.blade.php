@extends('admin.layout.app')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0 fw-light">
            <strong>Bienvenido, </strong>{{Auth::user()->name.' '.Auth::user()->lastname}}
        </h4>
    </div>
</div>

<div class="row">
    <div class="col col-md-4 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-2">Total de contactos</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{$contactos}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-md-4 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-2">Total de campañas</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
