<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{$title}} - {{ config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->
	<link rel="stylesheet" href="{{asset('admins/css/core.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/select2.min.css')}}"  />
    <link rel="stylesheet" href="{{asset('admins/css/flatpickr.min.css')}}">
	<link rel="stylesheet" href="{{asset('admins/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/sweetalert2.min.css')}}">
    <script src="{{asset('admins/js/color-modes.js')}}"></script>
    @yield('push-css')
</head>
<body>
	<div class="main-wrapper">
		<nav class="sidebar">
            <div class="sidebar-header bg-black">
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    <img src="{{asset('admins/img/whatzaby-light.svg')}}" width="140">
                </a>
                <div class="sidebar-toggler not-active text-white">
                    <span class="bg-white"></span>
                    <span class="bg-white"></span>
                    <span class="bg-white"></span>
                </div>
            </div>
            <div class="sidebar-body">
                <ul class="nav">
                    <li class="nav-item nav-category">Principal</li>
                    <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-grid"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                            <span class="link-title">Panel principal</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('administradores*') ? 'active' : '' }}">
                        <a href="{{ route('admin.index') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-cog"><circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/><path d="M10 15H6a4 4 0 0 0-4 4v2"/><path d="m21.7 16.4-.9-.3"/><path d="m15.2 13.9-.9-.3"/><path d="m16.6 18.7.3-.9"/><path d="m19.1 12.2.3-.9"/><path d="m19.6 18.7-.4-1"/><path d="m16.8 12.3-.4-1"/><path d="m14.3 16.6 1-.4"/><path d="m20.7 13.8 1-.4"/></svg>
                            <span class="link-title">Administradores</span>
                        </a>
                    </li>
                    {{-- CLIENTES --}}
                    <li class="nav-item nav-category">Whatzaby</li>
                    <li class="nav-item {{ Request::is('contactos*') ? 'active' : '' }}">
                        <a href="{{ route('contacto.index') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-tabs"><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M15 2v20"/><path d="M15 7h5"/><path d="M15 12h5"/><path d="M15 17h5"/></svg>
                            <span class="link-title">Contactos</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('broadcast*') ? 'active' : '' }}">
                        <a href="{{ route('campana.index') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-radio-tower"><path d="M4.9 16.1C1 12.2 1 5.8 4.9 1.9"/><path d="M7.8 4.7a6.14 6.14 0 0 0-.8 7.5"/><circle cx="12" cy="9" r="2"/><path d="M16.2 4.8c2 2 2.26 5.11.8 7.47"/><path d="M19.1 1.9a9.96 9.96 0 0 1 0 14.1"/><path d="M9.5 18h5"/><path d="m8 22 4-11 4 11"/></svg>
                            <span class="link-title">Campañas</span>
                        </a>
                    </li>

                    <li class="nav-item nav-category">Sistema</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cog"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>
                            <span class="link-title">Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"  class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-code-xml"><path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/></svg>
                            <span class="link-title">Documentación</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
	
		<div class="page-wrapper">
		
            <nav class="navbar">
				<div class="navbar-content">
                    <div class="logo-mini-wrapper">
                        <img src="{{asset('admins/img/logo-white.svg')}}" class="logo-mini logo-mini-light" alt="logo">
                        <img src="{{asset('admins/img/logo-white.svg')}}" class="logo-mini logo-mini-dark" alt="logo">
                    </div>

					<form class="search-form">
						<div class="input-group">
                            <div class="input-group-text">
                                <i data-feather="search"></i>
                            </div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Buscar por modelo...">
						</div>
					</form>

					<ul class="navbar-nav">
                        {{-- TEMA --}}
                        <li class="theme-switcher-wrapper nav-item">
                            <input type="checkbox" value="" id="theme-switcher">
                            <label for="theme-switcher">
                                <div class="box">
                                <div class="ball"></div>
                                <div class="icons">
                                    <i class="feather icon-sun"></i>
                                    <i class="feather icon-moon"></i>
                                </div>
                                </div>
                            </label>
                        </li>
                        {{-- NOTIFICACIONES --}}
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i data-feather="bell"></i>
                                <div class="indicator">
                                    <div class="circle"></div>
                                </div>
                            </a>
                        </li>
                        {{-- PERFIL DE USUARIO --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="w-30px h-30px ms-1 rounded-circle" src="{{asset(Auth::user()->getAvatarUrl('avatar'))}}" alt="profile">
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                    <div class="mb-3">
                                        <img class="w-80px h-80px rounded-circle" src="{{asset(Auth::user()->getAvatarUrl('avatar'))}}" alt="">
                                    </div>
                                    <div class="text-center">
                                        <p class="fs-16px fw-bolder">{{ Auth::user()->name }}</p>
                                        <p class="fs-12px text-secondary">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled p-1">
                                    <li class="dropdown-item py-2">
                                        <a href="{{route('admin.edit', Auth::user())}}" class="text-body ms-0 d-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                            <span>Mi perfil</span>
                                        </a>
                                    </li>
                                    <li class="dropdown-item py-2">
                                        <a href="{{ route('admin.logout') }}" class="text-body ms-0 d-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                            <span>Salir del sistema</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                    <a href="#" class="sidebar-toggler">
                        <i data-feather="menu"></i>
                    </a>
				</div>
			</nav>

			<div class="page-content">
                @yield('content') 
			</div>
		</div>
	</div>

    <script src="{{asset('admins/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admins/js/core.js')}}"></script>
	<script src="{{asset('admins/js/easymde.min.js')}}"></script>
	<script src="{{asset('admins/js/feather.min.js')}}"></script>
	<script src="{{asset('admins/js/app.js')}}"></script>
    <script src="{{asset('admins/js/tinymce.min.js')}}"></script>
    {{-- dataTables --}}
    <script src="{{asset('admins/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admins/js/dataTables.bootstrap5.js')}}"></script>
    {{-- sweet alert --}}
    <script src="{{asset('admins/js/apexcharts.min.js')}}"></script>
    <script src="{{asset('admins/js/flatpickr.min.js')}}"></script>
    <script src="{{asset('admins/js/dashboard.js')}}"></script>
    <script src="{{asset('admins/js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('admins/js/jquery.inputmask.min.js')}}"></script>
    @yield('push-script')
    @stack('after-script')
</body>
</html>   