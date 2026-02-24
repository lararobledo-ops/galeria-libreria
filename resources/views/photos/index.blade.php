@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Galería de Fotos</h1>
        <a href="{{ route('photos.create') }}" class="btn btn-primary">+ Subir Foto</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="mb-4 d-flex gap-2" action="{{ route('photos.index') }}" method="GET">
       <input
    type="text"
    name="search"
    value="{{ $search ?? '' }}"
    class="form-control"
    placeholder="Buscar por título..."
>
        <button class="btn btn-outline-secondary">Buscar</button>
    </form>

    <div class="gallery-grid">
        @foreach($photos as $photo)
            <div class="photo-card">
                <img class="photo-image" data-full="{{ (\Illuminate\Support\Str::startsWith($photo->image_path, ['http', 'https']) ? $photo->image_path : asset('storage/' . $photo->image_path)) }}" src="{{ (\Illuminate\Support\Str::startsWith($photo->image_path, ['http', 'https']) ? $photo->image_path : asset('storage/' . $photo->image_path)) }}" alt="{{ $photo->image_alt }}" loading="lazy" style="cursor: pointer; width: 100%; height: 200px; object-fit: cover; display: block;">
                <div class="photo-overlay"></div>
                <div class="photo-meta">
                    <h5 class="mb-1">{{ $photo->title }}</h5>
                    <small class="text-muted">{{ $photo->created_at->format('d/m/Y') }}</small>
                    <div class="mt-2 d-flex gap-2">
                        <a href="{{ route('photos.edit', $photo) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta foto?')">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Lightbox modal -->
    <div class="gallery-modal" aria-hidden="true">
        <div class="close">×</div>
        <div class="modal-content">
            <img src="" alt="">
            <div class="caption"></div>
        </div>
    </div>

{{ $photos->appends(request()->query())->links() }}

</div>
@endsection
