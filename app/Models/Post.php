<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Attachment;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use App\Concerns\AttachableConcern;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, AttachableConcern, InteractsWithMedia;

    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function draft()
    {
        return self::firstOrCreate(['name' => null], ['content' => '']);
    }

    public function scopeNotDraft($query)
    {
        return $query->whereNotNull('name');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function scopeMightAlsoLike($query)
    {
    return $query->inRandomOrder()->take(4);
    }

    public function getSlug(): string
    {
        return Str::slug($this->name);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
