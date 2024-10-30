<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'datas'];

    protected $casts = [
        'datas'=>'array'
    ];

    public function getDatasAttribute($value){
        return json_decode($value, true) ?? [];
    }

    public function setDatasAttribute($value){
        $this->attributes['datas'] = json_encode($value);
    }
}
