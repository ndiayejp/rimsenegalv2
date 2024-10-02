<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'status', 'image', 'images', 'specifications'];
    protected $casts = [
        'images' => 'array',
        'generales' => 'array',
    ];
}
