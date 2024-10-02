<?php

namespace App\Models;

use App\Concerns\AttachableConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory,AttachableConcern;

    protected $fillable = ['title', 'slug', 'content', 'status'];

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public static function draft()
    {
        return self::firstOrCreate(['title'=>null],['content'=>'']);
    }

    public function scopeNotDraft($query)
    {
        return $query->whereNotNull('title');
    }
}
