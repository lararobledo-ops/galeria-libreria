<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $photo?->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $photo?->description) }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($photo?->image_path)
                <div class="mt-2">
                    <img src="{{ (\Illuminate\Support\Str::startsWith($photo->image_path, ['http','https']) ? $photo->image_path : asset('storage/' . $photo->image_path)) }}" alt="{{ $photo->image_alt }}" class="img-thumbnail" style="max-width:150px">
                </div>
            @endif
        </div>
    </div>
</div>
