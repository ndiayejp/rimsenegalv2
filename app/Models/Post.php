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

class Post extends Model
{
    use HasFactory, AttachableConcern;

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
        return self::firstOrCreate(['name'=>null],['content'=>'']);
    }

    public function scopeNotDraft($query)
    {
        return $query->whereNotNull('name');
    }

}
