@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('photos.index') }}">← Volver a galería</a>
    <div class="card p-4 mt-3">
        <h1>{{ $photo->title }}</h1>
        <p class="text-muted">Subido el {{ $photo->created_at->format('d/m/Y') }}</p>

        <div class="text-center">
            <img src="{{ (\Illuminate\Support\Str::startsWith($photo->image_path, ['http','https']) ? $photo->image_path : asset('storage/' . $photo->image_path)) }}" alt="{{ $photo->image_alt }}" class="img-fluid gallery-show">
        </div>

        @if ($photo->description)
            <div class="mt-3">
                <p>{{ $photo->description }}</p>
            </div>
        @endif

        <div class="mt-3">
            <a class="btn btn-warning" href="{{ route('photos.edit', $photo) }}">Editar</a>
            <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('¿Eliminar esta foto?')">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
