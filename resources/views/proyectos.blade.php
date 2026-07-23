@php
    $proyectosOptimizados = $proyectosDb->map(function ($proyecto) {
        $imagenes = collect($proyecto->imagenes ?? [])
            ->filter(fn ($imagen) => is_string($imagen) && $imagen !== '');

        if ($imagenes->isEmpty() && $proyecto->imagen) {
            $imagenes->push($proyecto->imagen);
        }

        $proyecto->galeria = $imagenes
            ->take(5)
            ->map(fn ($imagen) => [
                'tipo' => 'imagen',
                'url' => Storage::disk('cloudinary')->url($imagen),
            ])
            ->values();

        if ($proyecto->youtube_embed_url) {
            $proyecto->galeria->push([
                'tipo' => 'video',
                'url' => $proyecto->youtube_embed_url,
            ]);
        }

        return $proyecto;
    });
@endphp

<x-layouts.app>
    <section class="relative overflow-hidden border-b border-white/5 bg-damian-dark pb-20 pt-32">
        <div class="pointer-events-none absolute inset-0 opacity-10" style="background-image: linear-gradient(#0f404f 1px, transparent 1px), linear-gradient(90deg, #0f404f 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="pointer-events-none absolute left-1/2 top-0 z-0 h-[400px] w-[800px] -translate-x-1/2 rounded-full bg-damian-green/10 blur-[120px]"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-6 text-center">
            <span class="mb-6 inline-flex items-center gap-2 rounded-full border border-damian-green/20 bg-damian-green/10 px-4 py-2 text-xs font-black uppercase tracking-widest text-damian-green">
                <span class="h-2 w-2 animate-pulse rounded-full bg-damian-green"></span>
                Nuestra Experiencia
            </span>
            <h1 class="mb-6 text-4xl font-black leading-tight text-white md:text-6xl">
                Proyectos <br>
                <span class="bg-gradient-to-r from-damian-blue to-damian-green bg-clip-text text-transparent">Ejecutados.</span>
            </h1>
            <p class="mx-auto max-w-2xl text-lg leading-relaxed text-damian-gray_light">
                Revisa nuestro portafolio de entregas técnicas, demostraciones de maquinaria pesada y soluciones implementadas.
            </p>
        </div>
    </section>

    <section class="relative z-10 mx-auto max-w-7xl px-6 py-20 lg:py-24">
        @if($proyectosOptimizados->isEmpty())
            <div class="rounded-3xl border border-white/5 bg-damian-card py-20 text-center shadow-2xl">
                <p class="text-damian-gray_mid">Sube tus proyectos desde el panel de administración.</p>
            </div>
        @else
            <div class="space-y-16 lg:space-y-24">
                @foreach($proyectosOptimizados as $proyecto)
                    @php
                        $descripcion = trim(strip_tags($proyecto->descripcion ?? ''));
                        $resumen = trim($proyecto->resumen ?? '') ?: Illuminate\Support\Str::limit($descripcion, 320);
                    @endphp

                    <article
                        class="grid items-start gap-8 border-b border-white/10 pb-16 lg:grid-cols-[minmax(0,0.78fr)_minmax(0,1.22fr)] lg:gap-14 lg:pb-24"
                        x-data="{ activo: 0, ampliada: null }"
                        @keydown.escape.window="ampliada = null"
                    >
                        <div class="lg:sticky lg:top-28">
                            <span class="mb-4 block text-[10px] font-bold uppercase tracking-widest text-damian-green">Portafolio Oficial</span>
                            <h2 class="mb-5 text-2xl font-black leading-tight text-white md:text-3xl">{{ $proyecto->titulo }}</h2>

                            <p class="whitespace-pre-line text-base leading-7 text-damian-gray_light">{{ $resumen }}</p>

                            <a href="{{ route('proyectos.show', $proyecto) }}" class="mt-6 inline-flex items-center gap-2 text-sm font-black uppercase tracking-wider text-damian-green transition-colors hover:text-white">
                                Ver detalles del proyecto
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0-7 7m7-7H3" /></svg>
                            </a>

                            <a href="https://wa.me/51964493400?text={{ urlencode('Hola, quisiera consultar sobre un proyecto similar a: '.$proyecto->titulo) }}" target="_blank" rel="noopener noreferrer" class="mt-8 inline-flex items-center gap-2 rounded-full bg-[#25D366] px-6 py-3 text-sm font-black text-white shadow-lg shadow-[#25D366]/15 transition-all hover:-translate-y-0.5 hover:bg-[#20bd5a]">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.04 2a9.84 9.84 0 0 0-8.42 14.93L2.05 22l5.2-1.53A9.95 9.95 0 1 0 12.04 2Zm0 17.95a8 8 0 0 1-4.08-1.12l-.3-.18-3.08.91.92-3-.2-.31a7.93 7.93 0 1 1 6.74 3.7Zm4.36-5.94c-.24-.12-1.42-.7-1.64-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.93-1.19a7.2 7.2 0 0 1-1.33-1.65c-.14-.24-.01-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.47-.39-.4-.54-.41h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.39 1.37.5.58.18 1.1.16 1.51.1.46-.07 1.42-.58 1.62-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z"/></svg>
                                Consultar por WhatsApp
                            </a>
                        </div>

                        <div class="min-w-0">
                            <div class="relative flex w-full justify-center">
                                <div class="w-full">
                                    @forelse($proyecto->galeria as $indice => $medio)
                                        @if($medio['tipo'] === 'imagen')
                                            <button
                                                x-cloak
                                                x-show="activo === {{ $indice }}"
                                                type="button"
                                                class="group/media relative mx-auto block w-fit max-w-full cursor-zoom-in overflow-hidden rounded-3xl border border-white/10 bg-[#061923] shadow-2xl focus:outline-none focus:ring-2 focus:ring-damian-green"
                                                @click="ampliada = {{ $indice }}"
                                                aria-label="Ampliar imagen {{ $indice + 1 }} de {{ $proyecto->titulo }}"
                                            >
                                                <img src="{{ $medio['url'] }}" alt="{{ $proyecto->titulo }} — imagen {{ $indice + 1 }}" loading="lazy" class="block h-auto max-h-[78vh] max-w-full object-contain transition-transform duration-500 group-hover/media:scale-[1.01]" />
                                                <span class="pointer-events-none absolute right-4 top-4 z-20 flex h-11 w-11 items-center justify-center rounded-full bg-white text-damian-dark shadow-xl">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-3v6m-3-3h6" /></svg>
                                                </span>
                                            </button>
                                        @else
                                            <div x-cloak x-show="activo === {{ $indice }}" class="aspect-video w-full overflow-hidden rounded-3xl border border-white/10 bg-black shadow-2xl">
                                                <iframe class="h-full w-full" src="{{ $medio['url'] }}" title="Video de {{ $proyecto->titulo }}" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="flex min-h-[280px] w-full flex-col items-center justify-center gap-3 rounded-3xl border border-white/10 bg-[#061923] text-white/30">
                                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3 16 5-5 4 4 3-3 6 6M5 20h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" /></svg>
                                            <span class="text-sm">Sin multimedia</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            @if($proyecto->galeria->count() > 1)
                                <div class="mt-3 grid grid-cols-3 gap-2 sm:grid-cols-5" aria-label="Todas las imágenes de {{ $proyecto->titulo }}">
                                    @foreach($proyecto->galeria as $indice => $medio)
                                        <button
                                            type="button"
                                            class="relative aspect-square w-full overflow-hidden rounded-xl border-2 bg-[#061923] transition-all hover:border-damian-green focus:outline-none focus:ring-2 focus:ring-damian-green/60"
                                            :class="activo === {{ $indice }} ? 'border-damian-green opacity-100' : 'border-white/10 opacity-70'"
                                            @click="activo = {{ $indice }}; ampliada = null"
                                            aria-label="Mostrar {{ $medio['tipo'] === 'video' ? 'video' : 'imagen '.($indice + 1) }} como principal"
                                        >
                                            @if($medio['tipo'] === 'imagen')
                                                <img src="{{ $medio['url'] }}" alt="" loading="lazy" class="h-full w-full object-contain p-1" />
                                            @else
                                                <span class="flex h-full w-full items-center justify-center bg-black text-damian-green">
                                                    <svg class="h-9 w-9" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z" /></svg>
                                                </span>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            <template x-teleport="body">
                                <div x-cloak x-show="ampliada !== null" x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 p-4 sm:p-8" role="dialog" aria-modal="true" aria-label="Imagen ampliada">
                                    <button type="button" class="absolute right-5 top-5 rounded-full border border-white/20 bg-black/50 p-3 text-white hover:bg-white/10" @click="ampliada = null" aria-label="Cerrar imagen ampliada">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg>
                                    </button>
                                    @foreach($proyecto->galeria as $indice => $medio)
                                        @if($medio['tipo'] === 'imagen')
                                            <img x-cloak x-show="ampliada === {{ $indice }}" src="{{ $medio['url'] }}" alt="{{ $proyecto->titulo }} — imagen ampliada {{ $indice + 1 }}" class="max-h-full max-w-full object-contain" />
                                        @endif
                                    @endforeach
                                </div>
                            </template>

                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
