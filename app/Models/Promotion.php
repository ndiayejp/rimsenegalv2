<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use App\Concerns\AttachableConcern;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Promotion extends Model implements HasMedia
{
    use HasFactory, HasTags, AttachableConcern, InteractsWithMedia;

    protected $fillable = ['title','slug', 'content', 'status'];

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public static function draft()
    {
        return self::firstOrCreate(['title' => null], ['content' => '']);
    }

     public function getSlug(): string
     {
     return Str::slug($this->title);
     }

    public function scopeNotDraft($query)
    {
        return $query->whereNotNull('title');
    }
}
