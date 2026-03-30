<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        static::deleting(function ($model) {
            foreach ($model->getCloudinaryFields() as $field) {
                if ($model->$field) {
                    static::deleteFromCloudinary($model->$field);
                }
            }
        });
    }

    protected static function deleteFromCloudinary($path)
    {
        if (!$path) return;

        try {
            Storage::disk('cloudinary')->delete($path);
            
        } catch (\Throwable $e) {
            Log::error("Fallo al borrar en Cloudinary: " . $e->getMessage());
        }
    }
}