<x-layouts.app>
    <div class="pt-32 pb-24 max-w-7xl mx-auto px-6 relative z-10">
        
        <nav class="flex text-xs text-damian-gray_mid mb-8 font-medium">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="/" class="hover:text-damian-green transition-colors">Inicio</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="/tienda" class="hover:text-damian-green transition-colors">Tienda</a></li>
                <li><span class="mx-2">/</span></li>
                @if($producto->categoria)
                    <li><a href="/tienda?cat={{ $producto->categoria->id }}" class="hover:text-damian-green transition-colors">{{ $producto->categoria->nombre }}</a></li>
                    <li><span class="mx-2">/</span></li>
                @endif
                <li class="text-white truncate max-w-[200px]">{{ $producto->nombre }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 bg-damian-card border border-white/5 rounded-3xl p-6 md:p-10 shadow-2xl">
            
            <!-- COLUMNA DE LA IMAGEN -->
            <div class="lg:col-span-5 flex flex-col items-center justify-center bg-white rounded-2xl p-8 relative overflow-hidden shadow-inner h-[400px] md:h-[500px]">
                @if($producto->marca)
                    <div class="absolute top-4 left-4 opacity-30 w-24">
                        @if($producto->marca->logo)
                            <img src="{{ Storage::url($producto->marca->logo) }}" alt="{{ $producto->marca->nombre }}" class="max-w-full h-auto filter grayscale">
                        @else
                            <span class="font-black text-gray-300">{{ $producto->marca->nombre }}</span>
                        @endif
                    </div>
                @endif

                @if($producto->imagen)
                    <img src="{{ Storage::url($producto->imagen) }}" alt="{{ $producto->nombre }}" class="max-h-full max-w-full object-contain relative z-10 hover:scale-110 transition-transform duration-500">
                @else
                    <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                @endif
            </div>

            <!-- COLUMNA DE LA INFORMACIÓN -->
            <div class="lg:col-span-7 flex flex-col">
                <div class="mb-6">
                    <span class="inline-block px-3 py-1 bg-damian-blue/10 text-damian-blue text-[10px] font-black uppercase tracking-widest rounded-full border border-damian-blue/20 mb-4">
                        {{ $producto->marca ? $producto->marca->nombre : 'Sin Marca' }} | COD: {{ $producto->codigo }}
                    </span>
                    <h1 class="text-3xl md:text-5xl font-black text-white leading-tight mb-6">
                        {{ $producto->nombre }}
                    </h1>
                </div>

                <!-- DESCRIPCIÓN BREVE -->
                <div class="mb-6 prose prose-invert max-w-none text-damian-gray_light">
                    <h3 class="text-white font-bold mb-2 uppercase tracking-wider text-xs border-b border-white/10 pb-2">Descripción del Equipo</h3>
                    <p class="leading-relaxed whitespace-pre-line">{{ $producto->descripcion ?? 'No hay descripción disponible para este producto.' }}</p>
                </div>

                <!-- NUEVO BLOQUE: ESPECIFICACIONES TÉCNICAS COMPLETAS -->
                @if($producto->especificaciones)
                    <div class="mb-8 bg-white/5 border border-white/10 p-5 rounded-xl prose prose-invert max-w-none text-damian-gray_light">
                        <h3 class="text-damian-green font-bold mb-3 uppercase tracking-wider text-xs border-b border-white/10 pb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Especificaciones Técnicas
                        </h3>
                        <p class="leading-relaxed whitespace-pre-line text-sm">{{ $producto->especificaciones }}</p>
                    </div>
                @endif

                <!-- BOTONES DE ACCIÓN -->
                <div class="mt-auto pt-6 border-t border-white/5 flex flex-col sm:flex-row gap-4">
                    
                    <a href="https://wa.me/51950705734?text={{ urlencode('Hola DAMIAN COMPANY, me interesa cotizar el equipo: ' . $producto->nombre . ' (CÓDIGO: ' . $producto->codigo . ').') }}" target="_blank" class="flex-1 flex items-center justify-center gap-3 bg-[#25D366] hover:bg-[#1EBE57] text-white px-8 py-4 rounded-xl font-black text-lg transition-all shadow-[0_10px_20px_rgba(37,211,102,0.3)] hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Solicitar Cotización
                    </a>

                    @if($producto->ficha_tecnica)
                        <a href="{{ $producto->ficha_tecnica }}" target="_blank" class="flex-1 flex items-center justify-center gap-3 bg-white/5 hover:bg-white/10 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all border border-white/10 hover:-translate-y-1">
                            <svg class="w-6 h-6 text-damian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Ver Ficha Técnica
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-layouts.app>