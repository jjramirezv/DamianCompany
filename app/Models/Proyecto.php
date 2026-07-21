<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCloudinaryFiles;

class Proyecto extends Model
{
    use HasCloudinaryFiles;

    protected $fillable = [
        'titulo', 'descripcion', 'imagen', 'imagenes', 'video_url', 'codigo_embed',
    ];

    protected function casts(): array
    {
        return ['imagenes' => 'array'];
    }

    public function getCloudinaryFields(): array
    {
        return ['imagen', 'imagenes'];
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $source = $this->video_url ?: $this->codigo_embed;

        if (!$source) {
            return null;
        }

        if (preg_match('/src=["\']([^"\']+)["\']/', $source, $match)) {
            $source = html_entity_decode($match[1]);
        }

        $parts = parse_url(trim($source));
        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        $videoId = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $videoId = explode('/', $path)[0] ?? null;
        } elseif (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com'], true)) {
            if ($path === 'watch') {
                parse_str($parts['query'] ?? '', $query);
                $videoId = $query['v'] ?? null;
            } elseif (preg_match('#^(?:embed|shorts)/([^/]+)#', $path, $match)) {
                $videoId = $match[1];
            }
        }

        return $videoId && preg_match('/^[A-Za-z0-9_-]{6,20}$/', $videoId)
            ? "https://www.youtube-nocookie.com/embed/{$videoId}"
            : null;
    }
}
