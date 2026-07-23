@php
    $imagenes = collect($proyecto->imagenes ?? [])->filter();
    if ($imagenes->isEmpty() && $proyecto->imagen) {
        $imagenes->push($proyecto->imagen);
    }

    $galeria = $imagenes->take(5)->map(fn ($imagen) => [
        'tipo' => 'imagen',
        'url' => Storage::disk('cloudinary')->url($imagen),
    ])->values();

    if ($proyecto->youtube_embed_url) {
        $galeria->push(['tipo' => 'video', 'url' => $proyecto->youtube_embed_url]);
    }
@endphp

<x-layouts.app>
    <section class="relative overflow-hidden border-b border-white/5 bg-damian-dark pb-12 pt-28">
        <div class="pointer-events-none absolute inset-0 opacity-10" style="background-image: linear-gradient(#0f404f 1px, transparent 1px), linear-gradient(90deg, #0f404f 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="relative z-10 mx-auto max-w-7xl px-6">
            <a href="{{ route('proyectos') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-bold text-damian-gray_light transition-colors hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19 3 12m0 0 7-7m-7 7h18" /></svg>
                Volver a proyectos
            </a>
            <h1 class="max-w-4xl text-3xl font-black leading-tight text-white md:text-5xl">{{ $proyecto->titulo }}</h1>
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-6 py-10 lg:py-16" x-data="{ activo: 0, ampliada: null }" @keydown.escape.window="ampliada = null">
        <section class="grid items-start gap-8 lg:grid-cols-[minmax(0,1.2fr)_minmax(300px,0.8fr)] lg:gap-10">
            <div class="min-w-0">
                <div class="relative w-full">
                    <div class="w-full">
                        @forelse($galeria as $indice => $medio)
                            @if($medio['tipo'] === 'imagen')
                                <button x-cloak x-show="activo === {{ $indice }}" type="button" class="group/media relative mx-auto block w-fit max-w-full cursor-zoom-in overflow-hidden rounded-2xl border border-white/10 bg-[#061923] shadow-2xl focus:outline-none focus:ring-2 focus:ring-damian-green" @click="ampliada = {{ $indice }}" aria-label="Ampliar imagen {{ $indice + 1 }}">
                                    <img src="{{ $medio['url'] }}" alt="{{ $proyecto->titulo }} — imagen {{ $indice + 1 }}" class="block h-auto max-h-[78vh] max-w-full object-contain transition-transform duration-500 group-hover/media:scale-[1.01]" />
                                    <span class="pointer-events-none absolute right-4 top-4 z-20 flex h-11 w-11 items-center justify-center rounded-full bg-white text-damian-dark shadow-xl">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-3v6m-3-3h6" /></svg>
                                    </span>
                                </button>
                            @else
                                <div x-cloak x-show="activo === {{ $indice }}" class="aspect-video w-full overflow-hidden rounded-2xl border border-white/10 bg-black shadow-2xl">
                                    <iframe class="h-full w-full" src="{{ $medio['url'] }}" title="Video de {{ $proyecto->titulo }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            @endif
                        @empty
                            <div class="flex min-h-[300px] items-center justify-center rounded-2xl border border-white/10 bg-[#061923]"><span class="text-white/30">Sin contenido multimedia</span></div>
                        @endforelse
                    </div>

                    @if($galeria->count() > 1)
                        <div class="mt-3 grid grid-cols-3 gap-2 sm:grid-cols-5">
                            @foreach($galeria as $indice => $medio)
                                <button type="button" class="relative aspect-[4/3] overflow-hidden border-2 bg-[#061923] transition" :class="activo === {{ $indice }} ? 'border-white opacity-100' : 'border-white/20 opacity-60 hover:opacity-100'" @click="activo = {{ $indice }}; ampliada = null" aria-label="Mostrar {{ $medio['tipo'] === 'video' ? 'video' : 'imagen '.($indice + 1) }}">
                                    @if($medio['tipo'] === 'imagen')
                                        <img src="{{ $medio['url'] }}" alt="" class="h-full w-full object-cover" />
                                    @else
                                        <span class="flex h-full w-full items-center justify-center bg-black text-damian-green"><svg class="h-9 w-9" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg></span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($proyecto->flujo_tecnico)
                    <section class="mt-8" aria-labelledby="flujo-tecnico-titulo">
                        <div class="mb-4 flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-damian-green/15 text-damian-green">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3v12m0 0a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm0-8h9a3 3 0 0 1 3 3v2m0 0a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z" /></svg>
                            </span>
                            <div>
                                <h2 id="flujo-tecnico-titulo" class="text-lg font-black text-white">Flujo técnico del proyecto</h2>
                                <p class="mt-1 text-sm leading-6 text-damian-gray_light">Proceso y etapas considerados durante su desarrollo.</p>
                            </div>
                        </div>

                        <a href="{{ Storage::disk('cloudinary')->url($proyecto->flujo_tecnico) }}" target="_blank" rel="noopener noreferrer" class="group relative mx-auto block w-fit max-w-full overflow-hidden rounded-2xl border border-white/10 bg-[#061923] shadow-2xl focus:outline-none focus:ring-2 focus:ring-damian-green" aria-label="Abrir el flujo técnico completo en una nueva pestaña">
                            <img src="{{ Storage::disk('cloudinary')->url($proyecto->flujo_tecnico) }}" alt="Flujo técnico de {{ $proyecto->titulo }}" loading="lazy" class="block h-auto max-h-[78vh] max-w-full object-contain transition-transform duration-500 group-hover:scale-[1.02]" />
                            <span class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white text-damian-dark shadow-xl">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-3v6m-3-3h6" /></svg>
                            </span>
                        </a>
                    </section>
                @endif
            </div>

            <article class="lg:sticky lg:top-28">
                <h2 class="mb-4 text-xl font-black text-white">Acerca del proyecto</h2>
                @php($descripcionConFormato = $proyecto->descripcion !== strip_tags($proyecto->descripcion ?? ''))
                <div class="text-base leading-7 text-damian-gray_light [&_a]:text-damian-green [&_a]:underline [&_blockquote]:my-5 [&_blockquote]:border-l-4 [&_blockquote]:border-damian-green [&_blockquote]:pl-4 [&_h1]:mb-4 [&_h1]:mt-7 [&_h1]:text-3xl [&_h1]:font-black [&_h1]:leading-tight [&_h1]:text-white [&_h2]:mb-3 [&_h2]:mt-6 [&_h2]:text-2xl [&_h2]:font-black [&_h2]:leading-tight [&_h2]:text-white [&_h3]:mb-2 [&_h3]:mt-5 [&_h3]:text-xl [&_h3]:font-bold [&_h3]:text-white [&_li]:mb-1 [&_ol]:my-4 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:mb-4 [&_ul]:my-4 [&_ul]:list-disc [&_ul]:pl-6">
                    @if($descripcionConFormato)
                        {!! $proyecto->descripcion !!}
                    @else
                        {!! nl2br(e($proyecto->descripcion)) !!}
                    @endif
                </div>
                <a href="https://wa.me/51964493400?text={{ urlencode('Hola, quisiera consultar sobre un proyecto similar a: '.$proyecto->titulo) }}" target="_blank" rel="noopener noreferrer" class="mt-7 inline-flex items-center gap-2 rounded-full bg-[#25D366] px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-[#25D366]/15 transition hover:-translate-y-0.5 hover:bg-[#20bd5a]">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.04 2a9.84 9.84 0 0 0-8.42 14.93L2.05 22l5.2-1.53A9.95 9.95 0 1 0 12.04 2Zm0 17.95a8 8 0 0 1-4.08-1.12l-.3-.18-3.08.91.92-3-.2-.31a7.93 7.93 0 1 1 6.74 3.7Zm4.36-5.94c-.24-.12-1.42-.7-1.64-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.93-1.19a7.2 7.2 0 0 1-1.33-1.65c-.14-.24-.01-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.47-.39-.4-.54-.41h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.39 1.37.5.58.18 1.1.16 1.51.1.46-.07 1.42-.58 1.62-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z"/></svg>
                    Consultar por WhatsApp
                </a>
            </article>
        </section>

        @if(collect($proyecto->secciones ?? [])->filter(fn ($seccion) => filled($seccion['titulo'] ?? null) || filled($seccion['contenido'] ?? null))->isNotEmpty())
            <section class="mx-auto mt-14 max-w-4xl border-t border-white/10 pt-10 lg:mt-16">
                <div class="space-y-10">
                    @foreach($proyecto->secciones as $seccion)
                        @if(filled($seccion['titulo'] ?? null) || filled($seccion['contenido'] ?? null))
                            <article class="grid gap-3 md:grid-cols-[220px_1fr] md:gap-8">
                                <h2 class="text-xl font-black leading-snug text-white">{{ $seccion['titulo'] ?? '' }}</h2>
                                <div class="whitespace-pre-line text-base leading-7 text-damian-gray_light">{{ $seccion['contenido'] ?? '' }}</div>
                            </article>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <template x-teleport="body">
            <div x-cloak x-show="ampliada !== null" x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 p-4 sm:p-8" role="dialog" aria-modal="true">
                <button type="button" class="absolute right-5 top-5 rounded-full border border-white/20 bg-black/50 p-3 text-white" @click="ampliada = null" aria-label="Cerrar"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg></button>
                @foreach($galeria as $indice => $medio)
                    @if($medio['tipo'] === 'imagen')
                        <img x-cloak x-show="ampliada === {{ $indice }}" src="{{ $medio['url'] }}" alt="{{ $proyecto->titulo }} — imagen ampliada" class="max-h-full max-w-full object-contain" />
                    @endif
                @endforeach
            </div>
        </template>
    </main>
</x-layouts.app>
