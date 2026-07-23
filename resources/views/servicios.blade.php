@php
    // Obtenemos los clientes de la base de datos
    $clientesDb = \App\Models\Cliente::all();
    
    // Asumo que ya mandabas $serviciosDb desde el controlador, o si no, descomenta la siguiente línea:
    // $serviciosDb = \App\Models\Servicio::all(); 

    // 🚀 OPTIMIZACIÓN PARA CLOUDINARY: 
    // Mapeamos los clientes para extraer la URL de la imagen una SOLA vez.
    // Usamos (object) para poder seguir usando la sintaxis $cliente->nombre en el HTML.
    $clientesOptimizados = $clientesDb->map(function($cliente) {
        return (object) [
            'nombre' => $cliente->nombre,
            'logo_url' => $cliente->logo ? Storage::url($cliente->logo) : null
        ];
    });

    // Mapeamos los servicios para hacer exactamente lo mismo
    $serviciosOptimizados = $serviciosDb->map(function($servicio) {
        $servicio->imagen_url = $servicio->imagen ? Storage::url($servicio->imagen) : null;
        return $servicio;
    });
@endphp

<x-layouts.app>
    <style>
        .contenedor-video iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
        }

        /* Agregamos la animación de scroll aquí por si no está global en el layout */
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(var(--track-width, -1000px)); }
        }
        .animate-scroll { animation: scroll 30s linear infinite; }
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
    
    <section class="py-16 bg-damian-darker relative overflow-hidden border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 mb-10 text-center relative z-10">
            <span class="font-mono text-sm tracking-widest uppercase text-damian-blue">Nuestra Experiencia</span>
            <h2 class="text-3xl font-black text-white mt-2">Empresas que confían en nosotros</h2>
            <div class="h-1 w-16 mt-4 mx-auto rounded-full bg-gradient-to-r from-damian-blue to-damian-green"></div>
        </div>
        
        <div class="relative w-full overflow-hidden flex items-center">
            <div class="absolute left-0 top-0 w-32 h-full bg-gradient-to-r from-damian-darker to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 w-32 h-full bg-gradient-to-l from-damian-darker to-transparent z-10 pointer-events-none"></div>
            
            <div class="flex animate-scroll gap-12 w-max items-center px-4" style="--track-width: calc(-250px * {{ max($clientesOptimizados->count(), 1) }});">
                @if($clientesOptimizados->count() > 0)
                    @for ($i = 0; $i < 8; $i++)
                        @foreach($clientesOptimizados as $cliente)
                            <div class="w-[200px] h-[80px] flex items-center justify-center shrink-0 transition-all duration-300 hover:scale-110 opacity-70 hover:opacity-100">
                                @if($cliente->logo_url)
                                    <img src="{{ $cliente->logo_url }}" alt="{{ $cliente->nombre }}" class="max-h-full max-w-full object-contain">
                                @else
                                    <span class="text-xl font-black text-white tracking-widest uppercase text-center">{{ $cliente->nombre }}</span>
                                @endif
                            </div>
                        @endforeach
                    @endfor
                @else
                    <p class="text-damian-gray_mid ml-10">Agrega clientes con sus logos en el panel de administrador para que aparezcan aquí.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="py-24 max-w-7xl mx-auto px-6 relative z-10">
        @forelse($serviciosOptimizados as $servicio)
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
                    
                    @if($servicio->codigo_embed)
                        <div class="relative aspect-video w-full overflow-hidden rounded-[40px] border border-white/10 bg-damian-card shadow-2xl">
                            <div class="absolute inset-0 w-full h-full contenedor-video">
                                {!! $servicio->codigo_embed !!}
                            </div>
                        </div>
                    @elseif($servicio->imagen_url)
                        <div class="relative mx-auto w-fit max-w-full overflow-hidden rounded-[40px] border border-white/10 bg-damian-card shadow-2xl">
                            <img src="{{ $servicio->imagen_url }}" alt="{{ $servicio->titulo }}" loading="lazy" class="block h-auto max-h-[78vh] max-w-full object-contain transition-transform duration-1000 group-hover:scale-[1.02]">
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-center text-damian-gray_mid">No hay servicios registrados.</p>
        @endforelse
    </section>
</x-layouts.app>
