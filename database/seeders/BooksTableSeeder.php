<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Don Quijote',
            'author' => 'Miguel de Cervantes',
            'isbn' => '978-84-203-0265-1',
            'published_at' => '1605-01-16',
            'status' => 'available',
            'stock' => 5,
            'description' => 'Una novela clásica sobre las aventuras de un caballero andante y su fiel escudero Sancho Panza.',
        ]);

        Book::create([
            'title' => 'Cien años de soledad',
            'author' => 'Gabriel García Márquez',
            'isbn' => '978-84-204-4466-6',
            'published_at' => '1967-05-30',
            'status' => 'available',
            'stock' => 3,
            'description' => 'La historia de la familia Buendía en el pueblo ficticio de Macondo, una obra maestra de la literatura latinoamericana.',
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'isbn' => '978-0-451-52494-2',
            'published_at' => '1949-06-08',
            'status' => 'borrowed',
            'stock' => 2,
            'description' => 'Una novela distópica sobre un futuro totalitario donde el gobierno controla todos los aspectos de la vida.',
        ]);

        Book::create([
            'title' => 'El quijote de la mancha',
            'author' => 'Miguel de Cervantes',
            'isbn' => '978-84-376-0494-7',
            'published_at' => '1615-10-27',
            'status' => 'available',
            'stock' => 4,
            'description' => 'La segunda parte de las aventuras del caballero Don Quijote.',
        ]);

        Book::create([
            'title' => 'Orgullo y prejuicio',
            'author' => 'Jane Austen',
            'isbn' => '978-0-14-143951-8',
            'published_at' => '1813-01-28',
            'status' => 'available',
            'stock' => 2,
            'description' => 'Un romance clásico que sigue a Elizabeth Bennet mientras busca amor y felicidad en la sociedad inglesa del siglo XIX.',
        ]);

        Book::create([
            'title' => 'La metamorfosis',
            'author' => 'Franz Kafka',
            'isbn' => '978-84-359-0277-2',
            'published_at' => '1915-06-01',
            'status' => 'available',
            'stock' => 1,
            'description' => 'Una novela corta sobre un hombre que se transforma en insecto y sus consecuencias familiares.',
        ]);
    }
}
