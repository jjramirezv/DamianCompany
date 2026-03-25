<?php

namespace App\Traits;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait HasCloudinaryFiles
{
    protected static function bootHasCloudinaryFiles()
    {
        static::updating(function ($model) {
            foreach ($model->getCloudinaryFields() as $field) {
                if ($model->isDirty($field) && $model->getOriginal($field)) {
                    static::deleteFromCloudinary($model->getOriginal($field));
                }
            }
        });

        static::deleted(function ($model) {
            foreach ($model->getCloudinaryFields() as $field) {
                if ($model->$field) {
                    static::deleteFromCloudinary($model->$field);
                }
            }
        });
    }

    protected static function deleteFromCloudinary($url)
    {
        try {
            $publicId = pathinfo($url, PATHINFO_FILENAME);
            Cloudinary::destroy($publicId);
        } catch (\Exception $e) {}
    }
}