@php
    // Obtenemos los proyectos de la base de datos (si no vienen del controlador)
    // $proyectosDb = \App\Models\Proyecto::all();

    // 🚀 OPTIMIZACIÓN PARA CLOUDINARY:
    // Mapeamos la colección para generar las URLs de las imágenes una sola vez.
    // Esto evita que el Rate Limit de Cloudinary se agote al recorrer el loop.
    $proyectosOptimizados = $proyectosDb->map(function($proyecto) {
        $proyecto->imagen_url = $proyecto->imagen ? Storage::url($proyecto->imagen) : null;
        return $proyecto;
    });
@endphp

<x-layouts.app>
    <style>
        /* Forzamos a que cualquier video de YouTube llene el contenedor horizontal */
        .contenedor-video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <section class="relative pt-32 pb-20 overflow-hidden bg-damian-dark border-b border-white/5">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: linear-gradient(#0f404f 1px, transparent 1px), linear-gradient(90deg, #0f404f 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-damian-green/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-damian-green/10 border border-damian-green/20 text-damian-green text-xs font-black tracking-widest uppercase mb-6">
                <span class="w-2 h-2 rounded-full bg-damian-green animate-pulse"></span>
                Nuestra Experiencia
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-6">
                Proyectos <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-damian-blue to-damian-green">Ejecutados.</span>
            </h1>
            <p class="text-lg text-damian-gray_light max-w-2xl mx-auto leading-relaxed">
                Revisa nuestro portafolio de entregas técnicas, demostraciones de maquinaria pesada y soluciones implementadas.
            </p>
        </div>
    </section>

    <section class="py-24 max-w-7xl mx-auto px-6 relative z-10">
        @if($proyectosOptimizados->isEmpty())
            <div class="text-center py-20 bg-damian-card rounded-3xl border border-white/5 shadow-2xl">
                <p class="text-damian-gray_mid">Sube tus proyectos desde el panel de administración.</p>
            </div>
        @else
            <div class="flex flex-col gap-24">
                @foreach($proyectosOptimizados as $proyecto)
                    <div class="flex flex-col {{ $loop->iteration % 2 == 0 ? 'md:flex-row-reverse' : 'md:flex-row' }} items-center gap-10 md:gap-16 group">
                        
                        <div class="w-full md:w-1/2">
                            <span class="text-[10px] font-bold text-damian-green uppercase tracking-widest mb-4 block">
                                Portafolio Oficial
                            </span>
                            <h2 class="text-3xl md:text-4xl font-black text-white mb-6 leading-tight group-hover:text-damian-blue transition-colors">
                                {{ $proyecto->titulo }}
                            </h2>
                            <p class="text-damian-gray_light leading-relaxed text-lg whitespace-pre-line mb-8">
                                {{ $proyecto->descripcion }}
                            </p>
                            <a href="https://wa.me/51964493400" class="inline-flex items-center gap-2 text-sm font-bold text-white border border-white/20 px-6 py-3 rounded-full hover:bg-white/10 transition-all">
                                Consultar similar <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                        <div class="w-full md:w-1/2 relative">
                            <div class="absolute inset-0 bg-gradient-to-tr from-damian-green/20 to-transparent rounded-3xl transform translate-x-4 translate-y-4 -z-10 group-hover:translate-x-2 group-hover:translate-y-2 transition-transform duration-500"></div>
                            
                            <div class="relative w-full aspect-video rounded-3xl overflow-hidden border border-white/10 shadow-2xl bg-damian-card">
                                
                                @if($proyecto->codigo_embed)
                                    <div class="absolute inset-0 w-full h-full contenedor-video">
                                        {!! $proyecto->codigo_embed !!}
                                    </div>
                                @elseif($proyecto->imagen_url)
                                    {{-- ✅ Usamos la URL pre-procesada --}}
                                    <img src="{{ $proyecto->imagen_url }}" alt="{{ $proyecto->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white/20">Sin multimedia</div>
                                @endif

                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </section>

</x-layouts.app>