<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Photo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $booksCount = Book::count();
        $photosCount = Photo::count();

        return view('admin.dashboard', compact('booksCount', 'photosCount'));
    }

    /**
     * Display a listing of books.
     */
    public function indexBooks(Request $request)
    {
        $search = $request->input('search');
        $query = Book::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        $books = $query->paginate(10);

        return view('admin.books.index', compact('books', 'search'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function createBook()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created book in storage.
     */
    public function storeBook(Request $request)
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
     * Show the form for editing the specified book.
     */
    public function editBook(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified book in storage.
     */
    public function updateBook(Request $request, Book $book)
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

        return redirect()->route('admin.books.index')
                        ->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroyBook(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')
                        ->with('success', 'Libro eliminado exitosamente.');
    }

    /**
     * Display a listing of photos.
     */
    public function indexPhotos(Request $request)
    {
        $search = $request->input('search');
        $query = Photo::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $photos = $query->paginate(10);

        return view('admin.photos.index', compact('photos', 'search'));
    }

    /**
     * Show the form for creating a new photo.
     */
    public function createPhoto()
    {
        return view('admin.photos.create');
    }

    /**
     * Store a newly created photo in storage.
     */
    public function storePhoto(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'image_alt' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('photos', 'public');
            $dimensions = getimagesize(storage_path("app/public/{$path}"));

            $validated['image_path'] = $path;
            $validated['width'] = $dimensions[0];
            $validated['height'] = $dimensions[1];
        }

        Photo::create($validated);

        return redirect()->route('admin.photos.index')
                        ->with('success', 'Foto creada exitosamente.');
    }

    /**
     * Show the form for editing the specified photo.
     */
    public function editPhoto(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Update the specified photo in storage.
     */
    public function updatePhoto(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'image_alt' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($photo->image_path && \Storage::disk('public')->exists($photo->image_path)) {
                \Storage::disk('public')->delete($photo->image_path);
            }

            $file = $request->file('image');
            $path = $file->store('photos', 'public');
            $dimensions = getimagesize(storage_path("app/public/{$path}"));

            $validated['image_path'] = $path;
            $validated['width'] = $dimensions[0];
            $validated['height'] = $dimensions[1];
        }

        $photo->update($validated);

        return redirect()->route('admin.photos.index')
                        ->with('success', 'Foto actualizada exitosamente.');
    }

    /**
     * Remove the specified photo from storage.
     */
    public function destroyPhoto(Photo $photo)
    {
        if ($photo->image_path && \Storage::disk('public')->exists($photo->image_path)) {
            \Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return redirect()->route('admin.photos.index')
                        ->with('success', 'Foto eliminada exitosamente.');
    }
}
