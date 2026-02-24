<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = Photo::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $photos = $query->latest()->paginate(12);
        return view('photos.index', compact('photos', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('photos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120',
        ]);

        $file = $request->file('image');
        $path = $file->store('photos', 'public');

        $size = getimagesize($file->getPathname());
        $width = $size[0] ?? null;
        $height = $size[1] ?? null;

        $photo = Photo::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $path,
            'image_alt' => $validated['title'],
            'width' => $width,
            'height' => $height,
        ]);

        return redirect()->route('photos.index')->with('success', 'Foto subida exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return view('photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        return view('photos.edit', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // delete previous file
            if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
            }
            $file = $request->file('image');
            $path = $file->store('photos', 'public');
            $size = getimagesize($file->getPathname());
            $width = $size[0] ?? null;
            $height = $size[1] ?? null;
            $photo->image_path = $path;
            $photo->width = $width;
            $photo->height = $height;
        }

        $photo->title = $validated['title'];
        $photo->description = $validated['description'] ?? null;
        $photo->save();

        return redirect()->route('photos.show', $photo)->with('success', 'Foto actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();
        return redirect()->route('photos.index')->with('success', 'Foto eliminada.');
    }
}
