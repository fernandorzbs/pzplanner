<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->
    {{-- zwicon --}}
    <link rel="stylesheet" href="{{asset('admins/css/zwicon.css')}}">
    {{-- core --}}
    <link rel="stylesheet" href="{{asset('admins/css/core.css')}}">  
    <link rel="stylesheet" href="{{asset('admins/css/dataTables.bootstrap5.css')}}">  
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('admins/css/flatpickr.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/flag-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/style.css')}}">
    <style>
        .main-wrapper .page-wrapper{
            background-color: #202124;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
@yield('push-script')
@stack('after-script')