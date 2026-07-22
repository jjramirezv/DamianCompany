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
                <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-[#061923] shadow-2xl">
                    <div class="relative flex aspect-[4/3] min-h-[300px] items-center justify-center sm:min-h-[420px]">
                        @forelse($galeria as $indice => $medio)
                            @if($medio['tipo'] === 'imagen')
                                <button x-cloak x-show="activo === {{ $indice }}" type="button" class="absolute inset-0 flex h-full w-full cursor-zoom-in items-center justify-center p-3 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-damian-green sm:p-6" @click="ampliada = {{ $indice }}" aria-label="Ampliar imagen {{ $indice + 1 }}">
                                    <img src="{{ $medio['url'] }}" alt="{{ $proyecto->titulo }} — imagen {{ $indice + 1 }}" class="max-h-full max-w-full object-contain" />
                                </button>
                            @else
                                <div x-cloak x-show="activo === {{ $indice }}" class="absolute inset-0 flex items-center bg-black">
                                    <iframe class="aspect-video w-full" src="{{ $medio['url'] }}" title="Video de {{ $proyecto->titulo }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            @endif
                        @empty
                            <span class="text-white/30">Sin contenido multimedia</span>
                        @endforelse

                        <span class="pointer-events-none absolute right-4 top-4 z-20 flex h-12 w-12 items-center justify-center rounded-full bg-white text-damian-dark shadow-xl">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-3v6m-3-3h6" /></svg>
                        </span>
                    </div>

                    @if($galeria->count() > 1)
                        <div class="relative z-20 -mt-20 grid grid-cols-3 gap-2 bg-gradient-to-t from-black/95 via-black/75 to-transparent p-2 pt-8 sm:grid-cols-5">
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
            </div>

            <article class="lg:sticky lg:top-28">
                <h2 class="mb-4 text-xl font-black text-white">Acerca del proyecto</h2>
                <div class="whitespace-pre-line text-base leading-7 text-damian-gray_light">{{ $proyecto->descripcion }}</div>
                <a href="https://wa.me/51964493400" class="mt-7 inline-flex items-center gap-2 rounded-full bg-damian-green px-5 py-2.5 text-sm font-bold text-white transition hover:scale-105">Consultar un proyecto similar</a>
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
