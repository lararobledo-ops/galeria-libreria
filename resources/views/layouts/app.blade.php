<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,
initial-scale=1">
<title>Blog</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstra
p.min.css" rel="stylesheet"
integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEd
K2Kadq2F9CUG65" crossorigin="anonymous">
@php
	$manifest = public_path('build/manifest.json');
@endphp
@if (file_exists($manifest))
	@vite(['resources/css/app.css', 'resources/js/app.js'])
@else
	{{-- Vite manifest not found; fallback stylesheets (CDN) --}}
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
@endif

<!-- Add gallery styles and JS fallback -->
<link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
<script defer src="{{ asset('js/gallery.js') }}"></script>
</head>

<header>
<nav class="navbar bg-primary">
<div class="container-fluid d-flex justify-content-between align-items-center">
	<div>
		<a class="navbar-brand {{ request()->routeIs('photos.*') ? 'text-warning fw-bold' : 'text-white' }}" href="{{ route('photos.index') }}">Galería/Biblioteca</a>
	</div>
	<div class="d-flex align-items-center gap-3">
		<div>
			<a class="{{ request()->routeIs('books.*') ? 'text-warning fw-bold' : 'text-white' }}" href="{{ route('books.index') }}">Libros</a>
			<span class="mx-2 text-white">|</span>
			<a class="{{ request()->routeIs('photos.*') ? 'text-warning fw-bold' : 'text-white' }}" href="{{ route('photos.index') }}">Fotos</a>
			
			@auth
				@if(auth()->user()->is_admin)
					<span class="mx-2 text-white">|</span>
					<a class="{{ request()->routeIs('admin.*') ? 'text-warning fw-bold' : 'text-white' }}" href="{{ route('admin.dashboard') }}">Admin</a>
				@endif
			@endauth
		</div>

		<!-- Auth Links -->
		<div>
			@auth
				<span class="text-white">{{ auth()->user()->name }}</span>
				<span class="mx-1 text-white">|</span>
				<a class="text-white text-decoration-none" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			@else
				<a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Iniciar Sesión</a>
			@endauth
		</div>
	</div>
</div>
</nav>
</header>
<body>
@yield('content')
</body>
<footer class="footer mt-auto py-3 bg-dark">
<div class="container d-lg-flex justify-content-between">
<span class="text-light">Mini-Blog © 2023</span>
</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.
bundle.min.js"
integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rY
XK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</html>