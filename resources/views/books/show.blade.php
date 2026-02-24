@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('books.index') }}" class="text-blue-500 hover:text-blue-700 mb-4 inline-block">← Volver a libros</a>

    <div class="bg-white rounded shadow p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $book->title }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold mb-2">Autor</h3>
                <p class="text-gray-700">{{ $book->author }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">ISBN</h3>
                <p class="text-gray-700">{{ $book->isbn ?? 'No especificado' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Fecha de publicación</h3>
                <p class="text-gray-700">{{ $book->published_at?->format('d/m/Y') ?? 'No especificada' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Stock</h3>
                <p class="text-gray-700">{{ $book->stock }} unidades</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Estado</h3>
                <p>
                    <span class="px-3 py-1 rounded font-semibold
                        {{ $book->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $book->status === 'available' ? 'Disponible' : 'Prestado' }}
                    </span>
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Creado el</h3>
                <p class="text-gray-700">{{ $book->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        @if ($book->description)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Descripción</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $book->description }}</p>
            </div>
        @endif

        <div class="flex gap-4">
            <a href="{{ route('books.edit', $book) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('¿Estás seguro?')">
                    Eliminar
                </button>
            </form>
            <a href="{{ route('books.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection
