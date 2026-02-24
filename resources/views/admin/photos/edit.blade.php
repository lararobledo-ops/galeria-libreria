@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="mb-4">Editar Foto</h1>

            <form action="{{ route('admin.photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Título *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $photo->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $photo->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($photo->image_path)
                    <div class="mb-3">
                        <label class="form-label">Imagen Actual</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->image_alt ?? $photo->title }}" class="img-fluid" style="max-width: 300px;">
                        </div>
                        <small class="text-muted">{{ $photo->width }}x{{ $photo->height }}px</small>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="image" class="form-label">Nueva Imagen (opcional)</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    <small class="text-muted">Max 5MB. Formatos: JPEG, PNG, JPG, GIF</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image_alt" class="form-label">Texto Alternativo</label>
                    <input type="text" class="form-control @error('image_alt') is-invalid @enderror" id="image_alt" name="image_alt" value="{{ old('image_alt', $photo->image_alt) }}">
                    @error('image_alt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Actualizar Foto</button>
                    <a href="{{ route('admin.photos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
