<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'image_alt',
        'width',
        'height',
    ];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
    ];
}
