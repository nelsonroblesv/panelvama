<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'marcas_id',
        'category',
        'url',
        'thumbnail',
        'primary_color',
        'description',
        'is_active',
    ];

    protected $casts = [
        'category' => 'array',
    ];
}
