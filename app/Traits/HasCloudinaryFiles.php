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
                if ($model->isDirty($field)) {
                    $originalPaths = static::normalizeCloudinaryPaths($model->getOriginal($field));
                    $currentPaths = static::normalizeCloudinaryPaths($model->{$field});

                    foreach (array_diff($originalPaths, $currentPaths) as $removedPath) {
                        static::deleteFromCloudinary($removedPath);
                    }
                }
            }
        });

        static::deleting(function ($model) {
            $paths = [];

            foreach ($model->getCloudinaryFields() as $field) {
                $paths = array_merge($paths, static::normalizeCloudinaryPaths($model->{$field}));
            }

            foreach (array_unique($paths) as $path) {
                static::deleteFromCloudinary($path);
            }
        });
    }

    protected static function normalizeCloudinaryPaths($value): array
    {
        if (!$value) {
            return [];
        }

        if (is_string($value) && str_starts_with(trim($value), '[')) {
            $decoded = json_decode($value, true);
            $value = json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
        }

        return array_values(array_filter(
            is_array($value) ? $value : [$value],
            fn ($path) => is_string($path) && $path !== ''
        ));
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
