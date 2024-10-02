<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

     public $appends = ['url'];

    protected $guarded = [];

    public function attachable(){
        return $this->morphTo();
    }

    public function uploadFile(UploadedFile $file){
        $file = $file->storePublicly('uploads',['disk'=>'public']);
        $this->name = basename($file);
        return $this;
    }

     public function deleteFile(){
     Storage::disk('public')->delete('/uploads/'.$this->name);
     }

    public function getUrlAttribute(){
        return Storage::disk('public')->url('/uploads/'.$this->name);
    }
}
