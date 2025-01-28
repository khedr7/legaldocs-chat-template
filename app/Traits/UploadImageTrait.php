<?php
namespace App\Traits;
use Illuminate\Support\Str;

trait UploadImageTrait
{
    public function uploadImage($model, $file, $collectionName)
    {

        $model->clearMediaCollection($collectionName);
        $model->addMedia($file)->toMediaCollection($collectionName);
    }
    public function uploadImages($model, $file, $collectionName)
    {
        foreach ($file as $image) {
            $model->addMedia($image)->toMediaCollection($collectionName);
        }
    }
}
