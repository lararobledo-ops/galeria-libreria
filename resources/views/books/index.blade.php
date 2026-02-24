@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Biblioteca</h1>
        <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            + Nuevo Libro
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <!-- Búsqueda y Filtros -->
    <div class="bg-white rounded shadow p-4 mb-6">
        <form action="{{ route('books.index') }}" method="GET" class="flex gap-4 flex-wrap">
            <input type="text" name="search" placeholder="Buscar por título o autor..." 
                   value="{{ $search }}" class="flex-1 px-3 py-2 border rounded min-w-64">
            
            <select name="status" class="px-3 py-2 border rounded">
                <option value="">Todos los estados</option>
                <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="borrowed" {{ $status === 'borrowed' ? 'selected' : '' }}>Prestado</option>
            </select>
            
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Buscar
            </button>
            <a href="{{ route('books.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">
                Limpiar
            </a>
        </form>
    </div>

    <!-- Tabla de libros -->
    <div class="bg-white rounded shadow overflow-hidden">
        @if ($books->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Título</th>
                        <th class="px-4 py-3 text-left">Autor</th>
                        <th class="px-4 py-3 text-left">Stock</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">ISBN</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3 font-semibold">{{ $book->title }}</td>
                            <td class="px-4 py-3">{{ $book->author }}</td>
                            <td class="px-4 py-3">{{ $book->stock }}</td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded text-sm font-semibold
                                    {{ $book->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $book->status === 'available' ? 'Disponible' : 'Prestado' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $book->isbn ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                                    Ver
                                </a>
                                <a href="{{ route('books.edit', $book) }}" class="text-yellow-500 hover:text-yellow-700 text-sm font-semibold ml-2">
                                    Editar
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold"
                                            onclick="return confirm('¿Estás seguro?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-3 bg-gray-50">
                {{ $books->appends(request()->query())->links() }}
            </div>
        @else
            <div class="px-4 py-6 text-center text-gray-500">
                No se encontraron libros. <a href="{{ route('books.create') }}" class="text-blue-500 hover:text-blue-700">Crear uno</a>
            </div>
        @endif
    </div>
    
</div>
@endsection
