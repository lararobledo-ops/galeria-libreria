<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Photo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard del administrador
     */
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalPhotos = Photo::count();
        $recentBooks = Book::latest()->take(5)->get();
        $recentPhotos = Photo::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalBooks', 'totalPhotos', 'recentBooks', 'recentPhotos'));
    }

    // ===== BOOKS CRUD =====

    /**
     * Listar todos los libros
     */
    public function booksIndex()
    {
        $search = request('search');
        $query = Book::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        $books = $query->paginate(10);

        return view('admin.books.index', compact('books', 'search'));
    }

    /**
     * Crear un nuevo libro
     */
    public function booksCreate()
    {
        return view('admin.books.create');
    }

    /**
     * Guardar nuevo libro
     */
    public function booksStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn',
            'published_at' => 'nullable|date',
            'status' => 'required|in:available,borrowed',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Book::create($validated);

        return redirect()->route('admin.books.index')
                        ->with('success', 'Libro creado exitosamente.');
    }

    /**
     * Ver detalles de un libro
     */
    public function booksShow(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Editar libro
     */
    public function booksEdit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Actualizar libro
     */
    public function booksUpdate(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn,' . $book->id,
            'published_at' => 'nullable|date',
            'status' => 'required|in:available,borrowed',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);

        return redirect()->route('admin.books.show', $book)
                        ->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Eliminar libro
     */
    public function booksDestroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')
                        ->with('success', 'Libro eliminado exitosamente.');
    }

    // ===== PHOTOS CRUD =====

    /**
     * Listar todas las fotos
     */
    public function photosIndex()
    {
        $search = request('search');
        $query = Photo::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $photos = $query->paginate(10);

        return view('admin.photos.index', compact('photos', 'search'));
    }

    /**
     * Crear una nueva foto
     */
    public function photosCreate()
    {
        return view('admin.photos.create');
    }

    /**
     * Guardar nueva foto
     */
    public function photosStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('photos', 'public');
            $validated['image_path'] = $path;

            $imagePath = storage_path('app/public/' . $path);
            [$width, $height] = getimagesize($imagePath);
            $validated['width'] = $width;
            $validated['height'] = $height;
        }

        unset($validated['image']);

        Photo::create($validated);

        return redirect()->route('admin.photos.index')
                        ->with('success', 'Foto creada exitosamente.');
    }

    /**
     * Ver detalles de una foto
     */
    public function photosShow(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));
    }

    /**
     * Editar foto
     */
    public function photosEdit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Actualizar foto
     */
    public function photosUpdate(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($photo->image_path && \Storage::disk('public')->exists($photo->image_path)) {
                \Storage::disk('public')->delete($photo->image_path);
            }

            $file = $request->file('image');
            $path = $file->store('photos', 'public');
            $validated['image_path'] = $path;

            $imagePath = storage_path('app/public/' . $path);
            [$width, $height] = getimagesize($imagePath);
            $validated['width'] = $width;
            $validated['height'] = $height;
        }

        unset($validated['image']);

        $photo->update($validated);

        return redirect()->route('admin.photos.show', $photo)
                        ->with('success', 'Foto actualizada exitosamente.');
    }

    /**
     * Eliminar foto
     */
    public function photosDestroy(Photo $photo)
    {
        if ($photo->image_path && \Storage::disk('public')->exists($photo->image_path)) {
            \Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return redirect()->route('admin.photos.index')
                        ->with('success', 'Foto eliminada exitosamente.');
    }
}
