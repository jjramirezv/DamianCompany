<x-layouts.app>
    <style>
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
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-damian-blue/10 border border-damian-blue/20 text-damian-blue text-xs font-black tracking-widest uppercase mb-6">
                <span class="w-2 h-2 rounded-full bg-damian-blue animate-pulse"></span>
                Soporte de Ingeniería
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-6">
                Servicios <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-damian-blue to-damian-green">Especializados.</span>
            </h1>
            <p class="text-lg text-damian-gray_light max-w-2xl mx-auto leading-relaxed">
                Desde mantenimiento preventivo hasta reparaciones complejas, garantizamos que tu maquinaria nunca se detenga.
            </p>
        </div>
    </section>

    <section class="py-24 max-w-7xl mx-auto px-6 relative z-10">
        @forelse($serviciosDb as $servicio)
            <div class="flex flex-col {{ $loop->iteration % 2 == 0 ? 'md:flex-row-reverse' : 'md:flex-row' }} items-center gap-10 md:gap-20 mb-32 last:mb-0 group">
                
                <div class="w-full md:w-1/2">
                    <div class="inline-block px-3 py-1 bg-damian-blue/10 text-damian-blue text-[10px] font-black uppercase tracking-widest rounded-full border border-damian-blue/20 mb-4">
                        Taller Autorizado
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6 leading-tight group-hover:text-damian-green transition-colors">
                        {{ $servicio->titulo }}
                    </h2>
                    <p class="text-damian-gray_light leading-relaxed text-lg whitespace-pre-line">
                        {{ $servicio->descripcion }}
                    </p>
                    <div class="mt-10">
                        <a href="https://wa.me/51964493400" class="text-white font-bold border-b-2 border-damian-green pb-1 hover:text-damian-green transition-all">Solicitar presupuesto →</a>
                    </div>
                </div>

                <div class="w-full md:w-1/2 relative">
                    <div class="absolute inset-0 bg-damian-blue/20 rounded-[40px] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative aspect-video w-full rounded-[40px] overflow-hidden border border-white/10 shadow-2xl bg-damian-card">
                        @if($servicio->codigo_embed)
                            <div class="absolute inset-0 w-full h-full contenedor-video">
                                {!! $servicio->codigo_embed !!}
                            </div>
                        @elseif($servicio->imagen)
                            <img src="{{ Storage::url($servicio->imagen) }}" alt="{{ $servicio->titulo }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-damian-gray_mid">No hay servicios registrados.</p>
        @endforelse
    </section>
</x-layouts.app>