@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Panel de Administración</h1>
            
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Libros</h5>
                            <p class="card-text display-4">{{ $totalBooks }}</p>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-light">Gestionar Libros</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Fotos</h5>
                            <p class="card-text display-4">{{ $totalPhotos }}</p>
                            <a href="{{ route('admin.photos.index') }}" class="btn btn-light">Gestionar Fotos</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h3>Libros Recientes</h3>
                    @if($recentBooks->count() > 0)
                        <ul class="list-group">
                            @foreach($recentBooks as $book)
                                <li class="list-group-item">
                                    <strong>{{ $book->title }}</strong>
                                    <br>
                                    <small class="text-muted">Autor: {{ $book->author }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No hay libros.</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h3>Fotos Recientes</h3>
                    @if($recentPhotos->count() > 0)
                        <ul class="list-group">
                            @foreach($recentPhotos as $photo)
                                <li class="list-group-item">
                                    <strong>{{ $photo->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $photo->created_at->format('d/m/Y H:i') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No hay fotos.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
