<div class="pt-32 pb-24 max-w-7xl mx-auto px-6 relative z-10">
    
    <div class="mb-10">
        <h1 class="text-4xl font-black text-white">Catálogo de Productos</h1>
        <div class="h-1 w-20 mt-4 rounded-full bg-gradient-to-r from-damian-blue to-damian-green"></div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">
        
        <div class="w-full lg:w-1/4">
            <div class="bg-damian-card border border-white/5 rounded-2xl p-6 sticky top-28 shadow-lg">
                
                <div class="mb-8">
                    <h3 class="text-white font-bold mb-4 uppercase tracking-wider text-xs">Buscar</h3>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Ej. Motosierra..." class="w-full bg-damian-darker border border-white/10 text-white pl-10 pr-4 py-2.5 rounded-lg outline-none text-sm focus:border-damian-green transition-colors placeholder-damian-gray_mid">
                        <svg class="w-4 h-4 text-damian-gray_mid absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-white font-bold mb-4 uppercase tracking-wider text-xs">Categorías</h3>
                    <div class="flex flex-col space-y-2">
                        
                        @if($activeParentId)
                            @php
                                $padre = $categoriasDb->where('id', $activeParentId)->first();
                                $hijos = $categoriasDb->where('parent_id', $activeParentId);
                            @endphp
                            
                            <button wire:click="$set('categoria', '')" class="w-full flex items-center justify-start gap-2 px-3 py-2 rounded-lg text-xs font-bold text-damian-gray_mid hover:text-white hover:bg-white/5 transition-all text-left mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Volver a todas
                            </button>

                            <button wire:click="$set('categoria', '{{ $padre->id }}')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm font-black tracking-wide uppercase transition-all text-left shadow-md {{ $categoria == $padre->id ? 'bg-damian-green text-white shadow-damian-green/20' : 'bg-white/5 text-white hover:bg-white/10 border border-white/5' }}">
                                <span>{{ $padre->nombre }}</span>
                                @if($categoria == $padre->id)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </button>

                            @if($hijos->count() > 0)
                                <div class="mt-2 flex flex-col space-y-1 relative">
                                    <div class="absolute left-6 top-0 bottom-4 w-px bg-white/10"></div>
                                    @foreach($hijos as $hijo)
                                        <button wire:click="$set('categoria', '{{ $hijo->id }}')" class="relative w-full flex items-center pl-12 pr-4 py-3 rounded-lg text-sm font-medium transition-all text-left group {{ $categoria == $hijo->id ? 'text-damian-blue bg-damian-blue/10' : 'text-damian-gray_light hover:text-white hover:bg-white/5' }}">
                                            <div class="absolute left-6 top-1/2 w-4 h-px transition-colors {{ $categoria == $hijo->id ? 'bg-damian-blue' : 'bg-white/10 group-hover:bg-white/30' }}"></div>
                                            {{ $hijo->nombre }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                        @else
                            <button wire:click="$set('categoria', '')" class="w-full flex items-center justify-start px-4 py-3 rounded-xl text-sm font-bold bg-white/5 text-white transition-all text-left mb-2 shadow-sm">
                                Todas las Categorías
                            </button>
                            @foreach($categoriasDb->whereNull('parent_id') as $cat)
                                <button wire:click="$set('categoria', '{{ $cat->id }}')" class="group w-full flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium text-damian-gray_light hover:text-white hover:bg-white/5 transition-all text-left">
                                    <span>{{ $cat->nombre }}</span>
                                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity text-damian-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-white font-bold mb-4 uppercase tracking-wider text-xs">Marcas</h3>
                    <div class="flex flex-col space-y-1">
                        <button wire:click="$set('marca', '')" class="w-full flex items-center justify-start px-4 py-2.5 rounded-lg text-sm transition-all text-left {{ empty($marca) ? 'bg-damian-blue/10 text-damian-blue font-bold border border-damian-blue/20' : 'text-damian-gray_light hover:bg-white/5 hover:text-white border border-transparent' }}">
                            Todas las Marcas
                        </button>
                        @foreach($marcasDb as $m)
                            <button wire:click="$set('marca', '{{ $m->id }}')" class="w-full flex items-center justify-start px-4 py-2.5 rounded-lg text-sm transition-all text-left {{ $marca == $m->id ? 'bg-damian-blue/10 text-damian-blue font-bold border border-damian-blue/20' : 'text-damian-gray_light hover:bg-white/5 hover:text-white border border-transparent' }}">
                                {{ $m->nombre }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <button wire:click="limpiarFiltros" class="w-full border border-damian-gray_dark text-damian-gray_mid hover:bg-white/5 hover:text-white hover:border-white/20 py-3 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-sm">
                    Limpiar Filtros
                </button>
            </div>
        </div>

        <div class="w-full lg:w-3/4">
            <div class="flex justify-between items-center mb-6 text-sm text-damian-gray_mid pb-4 border-b border-white/5">
                <p>Mostrando <span class="text-white font-bold">{{ $productos->total() }}</span> resultados</p>
            </div>

            @if($productos->isEmpty())
                <div class="text-center py-20 bg-damian-card rounded-2xl border border-white/5 shadow-lg">
                    <svg class="w-16 h-16 text-damian-gray_dark mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <h3 class="text-xl font-bold text-white mb-2">No se encontraron productos</h3>
                    <p class="text-damian-gray_mid mb-6">Ajusta los filtros o intenta con otra búsqueda.</p>
                    <button wire:click="limpiarFiltros" class="bg-damian-green text-white px-6 py-3 rounded-xl font-bold hover:bg-damian-green_light transition-colors shadow-lg">Quitar filtros</button>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
                    @foreach($productos as $producto)
                        <div class="group bg-damian-card rounded-2xl overflow-hidden border border-white/5 hover:border-damian-green/50 transition-all duration-300 shadow-lg flex flex-col">
                            
                            <a href="{{ route('producto.show', $producto->id) }}" class="relative h-56 bg-white flex items-center justify-center p-4 overflow-hidden block">
                                @if($producto->imagen)
                                    <img src="{{ Storage::url($producto->imagen) }}" alt="{{ $producto->nombre }}" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
                                @endif
                                
                                <div class="absolute top-3 left-3 bg-damian-darker/90 backdrop-blur-sm text-white text-[10px] font-bold px-3 py-1 rounded-full border border-white/10 uppercase tracking-wider z-10">
                                    {{ $producto->categoria ? $producto->categoria->nombre : 'General' }}
                                </div>
                            </a>

                            <div class="p-5 flex flex-col flex-grow">
                                <span class="text-[10px] font-bold text-damian-blue uppercase tracking-wider mb-1">
                                    {{ $producto->marca ? $producto->marca->nombre : 'Sin Marca' }}
                                </span>
                                
                                <a href="{{ route('producto.show', $producto->id) }}" class="text-base font-bold text-white mb-2 leading-tight flex-grow hover:text-damian-green transition-colors block">
                                    {{ $producto->nombre }}
                                </a>

                                <div class="mt-4 pt-4 border-t border-white/5">
                                    <a href="https://wa.me/51964493400?text={{ urlencode('Hola, deseo cotizar el producto: ' . $producto->nombre) }}" target="_blank" class="w-full bg-[#25D366]/10 hover:bg-[#25D366] text-[#25D366] hover:text-white px-3 py-2.5 rounded-lg transition-all border border-[#25D366]/30 hover:border-transparent flex items-center justify-center gap-2 group/wa">
                                        <svg class="w-4 h-4 group-hover/wa:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        <span class="text-xs font-bold tracking-wider uppercase">Cotizar Equipo</span>
                                    </a>
                                </div>
                            </div>  
                        </div>
                    @endforeach
                </div>
                <div class="mt-12 text-white">{{ $productos->links() }}</div>
            @endif
        </div>
    </div>
</div>