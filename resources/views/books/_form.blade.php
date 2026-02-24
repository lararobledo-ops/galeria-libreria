<!-- Formulario reutilizable para crear y editar libros -->
<div class="space-y-4">
    <div>
        <label for="title" class="block text-gray-700 font-semibold mb-2">Título *</label>
        <input type="text" id="title" name="title" value="{{ old('title', $book?->title) }}" 
               placeholder="Ej: Don Quijote" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500"
               required>
        @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="author" class="block text-gray-700 font-semibold mb-2">Autor *</label>
        <input type="text" id="author" name="author" value="{{ old('author', $book?->author) }}"
               placeholder="Ej: Miguel de Cervantes" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500"
               required>
        @error('author')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="isbn" class="block text-gray-700 font-semibold mb-2">ISBN</label>
            <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book?->isbn) }}"
                   placeholder="Ej: 978-0-14-018571-8" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
            @error('isbn')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="published_at" class="block text-gray-700 font-semibold mb-2">Fecha de publicación</label>
            <input type="date" id="published_at" name="published_at" 
                   value="{{ old('published_at', $book?->published_at?->format('Y-m-d')) }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
            @error('published_at')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="stock" class="block text-gray-700 font-semibold mb-2">Stock *</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $book?->stock ?? 1) }}"
                   min="0" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('stock')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-gray-700 font-semibold mb-2">Estado *</label>
            <select id="status" name="status" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
                <option value="available" {{ old('status', $book?->status) === 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="borrowed" {{ old('status', $book?->status) === 'borrowed' ? 'selected' : '' }}>Prestado</option>
            </select>
            @error('status')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción</label>
        <textarea id="description" name="description" rows="4" 
                  placeholder="Describe el contenido del libro..." 
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">{{ old('description', $book?->description) }}</textarea>
        @error('description')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>
