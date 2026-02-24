<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Photo;

Route::get('/', function (Request $request) {
    $search = $request->input('search');

    $photos = Photo::query()
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })
        ->paginate(6); 

    return view('photos.index', compact('photos', 'search'));
});

Route::resource('books', BookController::class);
Route::resource('photos', PhotoController::class);

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Las credenciales no son válidas.',
    ]);
})->name('login.post');

Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Admin Routes - Protegidas con CheckAdmin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Books CRUD
    Route::get('/books', [AdminController::class, 'booksIndex'])->name('books.index');
    Route::get('/books/create', [AdminController::class, 'booksCreate'])->name('books.create');
    Route::post('/books', [AdminController::class, 'booksStore'])->name('books.store');
    Route::get('/books/{book}', [AdminController::class, 'booksShow'])->name('books.show');
    Route::get('/books/{book}/edit', [AdminController::class, 'booksEdit'])->name('books.edit');
    Route::put('/books/{book}', [AdminController::class, 'booksUpdate'])->name('books.update');
    Route::delete('/books/{book}', [AdminController::class, 'booksDestroy'])->name('books.destroy');
    
    // Photos CRUD
    Route::get('/photos', [AdminController::class, 'photosIndex'])->name('photos.index');
    Route::get('/photos/create', [AdminController::class, 'photosCreate'])->name('photos.create');
    Route::post('/photos', [AdminController::class, 'photosStore'])->name('photos.store');
    Route::get('/photos/{photo}', [AdminController::class, 'photosShow'])->name('photos.show');
    Route::get('/photos/{photo}/edit', [AdminController::class, 'photosEdit'])->name('photos.edit');
    Route::put('/photos/{photo}', [AdminController::class, 'photosUpdate'])->name('photos.update');
    Route::delete('/photos/{photo}', [AdminController::class, 'photosDestroy'])->name('photos.destroy');
});

