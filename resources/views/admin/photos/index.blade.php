@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Gestionar Fotos</h1>
                <a href="{{ route('admin.photos.create') }}" class="btn btn-success">+ Nueva Foto</a>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por título..." value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </form>

            <div class="row">
                @forelse ($photos as $photo)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top" alt="{{ $photo->image_alt ?? $photo->title }}" style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $photo->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($photo->description, 100) }}</p>
                                <p class="card-text small">{{ $photo->width }}x{{ $photo->height }}px</p>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="{{ route('admin.photos.edit', $photo) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No hay fotos.</p>
                    </div>
                @endforelse
            </div>

            {{ $photos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
