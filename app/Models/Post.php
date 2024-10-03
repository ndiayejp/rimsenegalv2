<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Attachment;
use App\Concerns\AttachableConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;
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

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
