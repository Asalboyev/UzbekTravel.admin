<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'desc',
        'views_count',
        'img',
        'price',
        'slug'
    ];

    protected $casts = [
        'title' => 'array',
        'img' => 'array',
    ];


}
