@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ $book->title }}</h2>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Autor:</dt>
                        <dd class="col-sm-9">{{ $book->author }}</dd>

                        <dt class="col-sm-3">ISBN:</dt>
                        <dd class="col-sm-9">{{ $book->isbn ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Publicado:</dt>
                        <dd class="col-sm-9">{{ $book->published_at ? $book->published_at->format('d/m/Y') : 'N/A' }}</dd>

                        <dt class="col-sm-3">Estado:</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-{{ $book->status === 'available' ? 'success' : 'warning' }}">
                                {{ ucfirst($book->status) }}
                            </span>
                        </dd>

                        <dt class="col-sm-3">Stock:</dt>
                        <dd class="col-sm-9">{{ $book->stock }}</dd>

                        <dt class="col-sm-3">Descripción:</dt>
                        <dd class="col-sm-9">{{ $book->description ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Creado:</dt>
                        <dd class="col-sm-9">{{ $book->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-3">Actualizado:</dt>
                        <dd class="col-sm-9">{{ $book->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">Editar</a>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Volver</a>
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline">
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
