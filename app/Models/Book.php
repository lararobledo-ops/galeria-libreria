<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'published_at',
        'status',
        'stock',
        'description',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];
}
