<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Photo::truncate();

        $photos = [
            [
                'title' => 'Foto 1: Auto',
                'description' => 'Foto de auto vintage.',
                'image_path' => 'https://picsum.photos/seed/lion/1200/800',
            ],
            [
                'title' => 'Foto 2: Otoño',
                'description' => 'Foto de otoño con hojas.',
                'image_path' => 'https://picsum.photos/seed/tiger/1200/800',
            ],
            [
                'title' => 'Foto 3: Mar',
                'description' => 'Foto del mar y del cielo.',
                'image_path' => 'https://picsum.photos/seed/elephant/1200/800',
            ],
            [
                'title' => 'Foto 4: Bosque',
                'description' => 'Foto de un bosque con sombras.',
                'image_path' => 'https://picsum.photos/seed/cheetah/1200/800',
            ],
            [
                'title' => 'Foto 5: Computadora',
                'description' => 'Foto de una computadora Apple.',
                'image_path' => 'https://picsum.photos/seed/giraffe/1200/800',
            ],
            [
                'title' => 'Foto 6: Ventana',
                'description' => 'Foto de una ventana con arboles.',
                'image_path' => 'https://picsum.photos/seed/zebra/1200/800',
            ],
        ];

        foreach ($photos as $p) {
            // If remote image, download and store locally
            $imgPath = $p['image_path'];
            if (Str::startsWith($imgPath, ['http://', 'https://'])) {
                try {
                    $contents = file_get_contents($imgPath);
                    if ($contents) {
                        $filename = 'photos/' . Str::random(8) . '-' . basename(parse_url($imgPath, PHP_URL_PATH));
                        Storage::disk('public')->put($filename, $contents);
                        $p['image_path'] = $filename;
                    }
                } catch (\Exception $e) {
                    // fallback: keep original path
                }
            }

            Photo::create($p);
        }
    }
}
