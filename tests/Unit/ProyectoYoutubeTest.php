<?php

namespace Tests\Unit;

use App\Models\Proyecto;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ProyectoYoutubeTest extends TestCase
{
    #[DataProvider('youtubeSources')]
    public function test_it_converts_youtube_links_and_iframes_to_an_embed_url(string $source): void
    {
        $proyecto = new Proyecto(['video_url' => $source]);

        $this->assertSame(
            'https://www.youtube.com/embed/T96K_Ks5c_E',
            $proyecto->youtube_embed_url,
        );
    }

    public static function youtubeSources(): array
    {
        return [
            'iframe' => ['<iframe width="560" height="315" src="https://www.youtube.com/embed/T96K_Ks5c_E?si=FZlbZBZ3IiTzDlRR" title="YouTube video player" frameborder="0" allowfullscreen></iframe>'],
            'watch link' => ['https://www.youtube.com/watch?v=T96K_Ks5c_E'],
            'short link' => ['https://youtu.be/T96K_Ks5c_E'],
            'embed link' => ['https://www.youtube.com/embed/T96K_Ks5c_E?si=FZlbZBZ3IiTzDlRR'],
        ];
    }
}
