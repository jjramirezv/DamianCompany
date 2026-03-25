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
                // Si el campo cambió, borramos el archivo viejo
                if ($model->isDirty($field) && $model->getOriginal($field)) {
                    static::deleteFromCloudinary($model->getOriginal($field));
                }
            }
        });

        static::deleting(function ($model) {
            foreach ($model->getCloudinaryFields() as $field) {
                // Al borrar el registro, borramos el archivo
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
            // Le decimos al disco de Cloudinary que busque el archivo y lo elimine.
            // Laravel y el paquete se encargan de encontrar el ID correcto automáticamente.
            Storage::disk('cloudinary')->delete($path);
            
        } catch (\Throwable $e) {
            Log::error("Fallo al borrar en Cloudinary: " . $e->getMessage());
        }
    }
}