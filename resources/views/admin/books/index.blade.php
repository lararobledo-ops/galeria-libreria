@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Gestionar Libros</h1>
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">+ Nuevo Libro</a>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por título o autor..." value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>ISBN</th>
                        <th>Estado</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->isbn ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $book->status === 'available' ? 'success' : 'warning' }}">
                                    {{ ucfirst($book->status) }}
                                </span>
                            </td>
                            <td>{{ $book->stock }}</td>
                            <td>
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay libros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
