<?php

namespace App\Traits;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait HasCloudinaryFiles
{
    protected static function bootHasCloudinaryFiles()
    {
        // 1. ANTES DE ACTUALIZAR
        static::updating(function ($model) {
            foreach ($model->getCloudinaryFields() as $field) {
                if ($model->isDirty($field) && $model->getOriginal($field)) {
                    static::deleteFromCloudinary($model->getOriginal($field));
                }
            }
        });

        // 2. EL CAMBIO CLAVE: Usamos 'deleting' en lugar de 'deleted'
        // Esto evita el error de "Cannot use ::class on null" en Filament
        static::deleting(function ($model) {
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
            // Extraer el Public ID exacto, incluso si está en carpetas de Cloudinary
            $parts = explode('/upload/', $url);
            
            if (count($parts) > 1) {
                // Quitamos la versión (ej. v1700000000/) de la URL
                $pathWithoutVersion = preg_replace('/^v\d+\//', '', $parts[1]);
                
                $dirname = pathinfo($pathWithoutVersion, PATHINFO_DIRNAME);
                $filename = pathinfo($pathWithoutVersion, PATHINFO_FILENAME);
                
                // Construimos el ID final
                $publicId = ($dirname !== '.') ? $dirname . '/' . $filename : $filename;
                
                // Mandamos la orden de destrucción
                Cloudinary::destroy($publicId);
            }
        } catch (\Throwable $e) {
            // Usamos Throwable para atrapar cualquier falla interna y evitar la pantalla de error 500
            \Log::warning("No se pudo eliminar la imagen de Cloudinary: " . $e->getMessage());
        }
    }
}