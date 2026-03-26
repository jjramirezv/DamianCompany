<div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <span class="font-mono text-sm tracking-wider uppercase text-damian-green">Catálogo</span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-2">Equipos Destacados</h2>
            <div class="h-1 w-24 mt-4 rounded-full bg-gradient-to-r from-damian-green to-damian-blue"></div>
        </div>
        <a href="/tienda" class="hidden md:flex items-center gap-2 text-damian-gray_light hover:text-white transition-colors font-bold">
            Ver todo el catálogo 
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </a>
    </div>

    @if($productos->isEmpty())
        <div class="text-center py-20 bg-damian-card/30 rounded-3xl border border-white/5 backdrop-blur-sm">
            <svg class="w-16 h-16 text-damian-gray_mid mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-damian-gray_light font-medium">Próximamente nuevos equipos destacados.</p>
        </div>
    @else
        <div x-data="{
                skip: 320,
                next() { this.$refs.slider.scrollBy({ left: this.skip, behavior: 'smooth' }) },
                prev() { this.$refs.slider.scrollBy({ left: -this.skip, behavior: 'smooth' }) }
             }" 
             class="relative w-full group/carousel">
            
            <button @click="prev()" class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-5 z-20 bg-damian-darker border border-damian-green/50 text-damian-green w-12 h-12 rounded-full items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-all hover:bg-damian-green hover:text-white shadow-[0_0_15px_rgba(34,161,94,0.3)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button @click="next()" class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-5 z-20 bg-damian-darker border border-damian-green/50 text-damian-green w-12 h-12 rounded-full items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-all hover:bg-damian-green hover:text-white shadow-[0_0_15px_rgba(34,161,94,0.3)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div x-ref="slider" class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-8" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    div::-webkit-scrollbar { display: none; }
                </style>

                @foreach($productos as $producto)
                    <div class="snap-always snap-center shrink-0 w-[280px] sm:w-[320px] bg-damian-card rounded-2xl overflow-hidden border border-white/5 hover:border-damian-green/40 transition-all duration-500 shadow-lg hover:shadow-[0_0_30px_rgba(34,161,94,0.1)] flex flex-col h-full">
                        
                        <div class="relative h-56 bg-white flex items-center justify-center p-6 overflow-hidden">
                            @if($producto->imagen)
                                <img src="{{ Storage::url($producto->imagen) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="text-gray-200 flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] uppercase font-bold opacity-50">Sin Imagen</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-3 left-3 bg-damian-darker/90 backdrop-blur-md text-white text-[9px] font-black px-3 py-1 rounded-full border border-white/10 uppercase tracking-widest z-10">
                                {{ $producto->categoria?->nombre ?? 'General' }}
                            </div>

                            @if($producto->stock <= $producto->stock_min && $producto->stock > 0)
                                <div class="absolute top-3 right-3 bg-amber-500 text-white text-[9px] font-black px-2 py-1 rounded shadow-lg animate-pulse z-10">
                                    ÚLTIMAS UNIDADES
                                </div>
                            @endif
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="mb-4">
                                <span class="text-[10px] font-black text-damian-blue uppercase tracking-[0.2em] mb-1 block">
                                    {{ $producto->marca?->nombre ?? 'DAMIAN' }}
                                </span>
                                <h3 class="text-lg font-bold text-white leading-snug group-hover:text-damian-green transition-colors line-clamp-2">
                                    {{ $producto->nombre }}
                                </h3>
                            </div>

                            @if($producto->precio)
                                <div class="mb-6">
                                    <span class="text-damian-gray_mid text-[10px] uppercase font-bold block mb-1">Precio Sugerido</span>
                                    <span class="text-2xl font-black text-white">S/ {{ number_format($producto->precio, 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="mt-auto">
                                <a href="https://wa.me/51964493400?text={{ urlencode('Hola Damian Company, me interesa el equipo destacado: ' . $producto->nombre) }}" 
                                   target="_blank" 
                                   class="w-full bg-[#25D366]/10 hover:bg-[#25D366] text-[#25D366] hover:text-white py-3 rounded-xl transition-all duration-300 border border-[#25D366]/30 hover:border-transparent flex items-center justify-center gap-2 group/btn">
                                    <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    <span class="text-[11px] font-black tracking-widest uppercase">Cotizar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="flex md:hidden justify-center mt-4">
            <span class="text-xs text-damian-gray_mid flex items-center gap-2">
                <svg class="w-4 h-4 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                Desliza para ver más
            </span>
        </div>
    @endif
</div>