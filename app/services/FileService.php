<?php

namespace App\Services;
use Image;
use Illuminate\Support\Facades\File;
class FileService
{
    /**
     * Upload a new image and delete the old one if it exists.
     * @param mixed $model
     * @param mixed $request
     * @return mixed
     */
    public function uploadImage($model, $request)
    {
          $image = Image::make($request);
          if(!empty($model->image)){
          $currentImage = public_path().$model->image;
          if(file_exists($currentImage) && $currentImage!=public_path()."/uploads/default.png"){
          unlink($currentImage);
          }
          }
          $file = $request;
          $extension = $file->getClientOriginalExtension();
          $name = time().'.'.$extension;
          $image->save(public_path().'/uploads/'.$name);
          $model->image = '/uploads/'.$name;
          return $model;
    }


}
