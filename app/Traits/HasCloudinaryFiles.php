<?php

namespace App\Traits;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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

    protected static function deleteFromCloudinary($url)
    {
        if (!$url) return;

        try {
            // 1. Cortamos la URL justo donde dice '/upload/'
            $parts = explode('/upload/', $url);
            
            if (count($parts) > 1) {
                $path = $parts[1]; // Ejemplo: "v1690000000/marcas/logo.png"
                
                // 2. Separamos por las barras '/'
                $segments = explode('/', $path);
                
                // 3. Si el primer segmento es la versión (empieza con 'v' y tiene números), lo eliminamos
                if (preg_match('/^v\d+$/', $segments[0])) {
                    array_shift($segments);
                }
                
                // 4. Volvemos a unir lo que queda (ej. "marcas/logo.png")
                $publicIdWithExtension = implode('/', $segments);
                
                // 5. Le quitamos la extensión (.png, .jpg, .webp) para tener el ID exacto
                $publicId = preg_replace('/\.[^.]+$/', '', $publicIdWithExtension);
                
                // 6. ¡Le damos la orden de destrucción a Cloudinary!
                Cloudinary::destroy($publicId);
            }
        } catch (\Throwable $e) {
            // Si algo falla, ahora lo guardará en los logs para que no sea un error silencioso
            Log::error("Fallo al borrar en Cloudinary: " . $e->getMessage());
        }
    }
}