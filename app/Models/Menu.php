<?php

namespace App\Models;


use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

     protected $fillable = ['name', 'parent_id', 'page_id', 'url', 'order'];

     public function page():BelongsTo {
        return $this->belongsTo(Page::class);
     }

     public function children(){
        return $this->hasMany(Menu::class,'parent_id');
     }

     public function scopeTopLevel($query){
        return $query->whereNull('parent_id')->orderBy('order');
     }
}
