@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">{{ $photo->title }}</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->image_alt ?? $photo->title }}" class="img-fluid" style="max-height: 400px;">
                    </div>

                    <dl class="row">
                        <dt class="col-sm-3">Descripción:</dt>
                        <dd class="col-sm-9">{{ $photo->description ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Texto Alternativo:</dt>
                        <dd class="col-sm-9">{{ $photo->image_alt ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Ruta de Imagen:</dt>
                        <dd class="col-sm-9">{{ $photo->image_path }}</dd>

                        <dt class="col-sm-3">Dimensiones:</dt>
                        <dd class="col-sm-9">{{ $photo->width }}x{{ $photo->height }} px</dd>

                        <dt class="col-sm-3">Creado:</dt>
                        <dd class="col-sm-9">{{ $photo->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-3">Actualizado:</dt>
                        <dd class="col-sm-9">{{ $photo->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.photos.edit', $photo) }}" class="btn btn-warning">Editar</a>
                    <a href="{{ route('admin.photos.index') }}" class="btn btn-secondary">Volver</a>
                    <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
