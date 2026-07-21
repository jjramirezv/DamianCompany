@php
    $categoriasNavbar = \App\Models\Categoria::with([
        'subCategorias' => fn ($query) => $query->orderBy('nombre'),
    ])->whereNull('parent_id')->orderBy('nombre')->get();
@endphp

<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damian Company</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #152036; }
        ::-webkit-scrollbar-thumb { background: #1a4e5c; border-radius: 4px; }
    </style>
</head>
<body class="bg-damian-dark text-damian-gray_light font-sans antialiased selection:bg-damian-green selection:text-white overflow-x-hidden flex flex-col min-h-screen">

    <header x-data="{ scrolled: false, megaMenu: false, mobileMenu: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'bg-damian-dark/95 backdrop-blur-xl border-b border-damian-blue/20 shadow-[0_10px_30px_-10px_rgba(0,0,0,0.7)] py-2' : 'bg-transparent py-3 md:py-4'"
            class="fixed top-0 w-full z-[9999] transition-all duration-500">
        
        <div x-show="!scrolled" x-transition.opacity class="max-w-7xl mx-auto px-4 md:px-6 flex justify-between items-center border-b border-white/5 pb-2 md:pb-3 mb-2 md:mb-3">
            <div class="flex items-center gap-3 md:gap-6 text-[9px] md:text-[11px] uppercase tracking-widest font-bold text-damian-gray_mid">
                <a href="tel:964493400" class="flex items-center gap-1.5 hover:text-damian-green transition-colors">
                    <svg class="w-3 h-3 text-damian-green shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> 
                    <span>964 493 400</span>
                </a>
                <a href="tel:987564941" class="hidden sm:flex items-center gap-2 hover:text-damian-green transition-colors">
                    <span>987 564 941</span>
                </a>
                <a href="tel:950705734" class="hidden md:flex items-center gap-2 hover:text-damian-green transition-colors">
                    <span>950 705 734</span>
                </a>
                <span class="hidden lg:flex items-center gap-2">
                    <svg class="w-3 h-3 text-damian-blue shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                    Chupaca - Huancayo
                </span>
            </div>
            
            <a href="/admin" class="hidden md:flex text-[10px] uppercase tracking-widest font-bold text-damian-gray_mid hover:text-white transition-colors items-center gap-1 bg-white/5 px-3 py-1 rounded-full border border-white/10">
                <svg class="w-3 h-3 text-damian-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> 
                Admin
            </a>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 flex justify-between items-center relative">
            
            <a href="/" class="flex items-center gap-2 md:gap-3 group z-50">
                <img src="{{ asset('img/logo.png') }}" alt="Damian Company Logo" class="h-8 md:h-11 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <div class="flex flex-col">
                    <span class="font-bold tracking-tight text-lg md:text-xl leading-none text-white drop-shadow-md">DAMIAN</span>
                    <span class="text-[7px] md:text-[9px] tracking-[0.25em] font-bold uppercase text-damian-green">COMPANY</span>
                </div>
            </a>
            
            <div class="hidden lg:flex items-center gap-6">
                <nav class="flex items-center gap-1 bg-damian-card/40 p-1.5 rounded-full border border-white/10 backdrop-blur-md shadow-lg">
                    <a href="/" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request()->is('/') ? 'bg-damian-blue/20 text-damian-blue' : 'text-damian-gray_light hover:text-white' }}">Inicio</a>
                    
                    <div @mouseenter="megaMenu = true" @mouseleave="megaMenu = false" class="relative z-50">
                        <button type="button" @click="megaMenu = !megaMenu" :aria-expanded="megaMenu" aria-controls="tienda-menu-desktop" class="px-5 py-2 rounded-full text-sm font-bold text-damian-gray_light hover:text-white flex items-center gap-1 transition-all">
                            Tienda <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div id="tienda-menu-desktop" x-show="megaMenu" x-transition.opacity.duration.300ms @click.outside="megaMenu = false" class="absolute left-1/2 -translate-x-1/2 top-[100%] w-[min(760px,calc(100vw-3rem))] mt-4 bg-damian-darker/95 backdrop-blur-xl border border-damian-blue/30 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.8)] p-5 overflow-hidden" style="display: none;">
                            <div class="mb-4 flex items-center justify-between border-b border-white/10 pb-4">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.18em] text-white">Categorías de productos</p>
                                    <p class="mt-1 text-[11px] text-damian-gray_mid">Selecciona una categoría o especialidad</p>
                                </div>
                                <a href="{{ route('tienda') }}" class="text-xs font-bold text-damian-blue transition-colors hover:text-white">Ver toda la tienda →</a>
                            </div>

                            @if($categoriasNavbar->isNotEmpty())
                                <div class="grid grid-cols-2 gap-x-5 gap-y-6 xl:grid-cols-4">
                                    @foreach($categoriasNavbar as $categoria)
                                        <div class="min-w-0">
                                            <a href="{{ route('tienda', ['cat' => \Illuminate\Support\Str::slug($categoria->nombre)]) }}" class="group flex items-center gap-2 border-l-2 border-damian-green pl-3 text-xs font-black uppercase tracking-wider text-white transition-colors hover:text-damian-green">
                                                <span class="truncate">{{ $categoria->nombre }}</span>
                                                <svg class="h-3.5 w-3.5 shrink-0 opacity-50 transition-transform group-hover:translate-x-0.5 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>

                                            @if($categoria->subCategorias->isNotEmpty())
                                                <ul class="mt-3 space-y-1">
                                                    @foreach($categoria->subCategorias as $subcategoria)
                                                        <li>
                                                            <a href="{{ route('tienda', ['cat' => \Illuminate\Support\Str::slug($subcategoria->nombre)]) }}" class="block rounded-lg px-3 py-2 text-xs text-damian-gray_light transition-all hover:bg-white/5 hover:pl-4 hover:text-damian-blue">
                                                                {{ $subcategoria->nombre }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="mt-3 pl-3 text-[11px] italic text-damian-gray_mid">Ver productos</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="py-4 text-center text-sm text-damian-gray_mid">Aún no hay categorías disponibles.</p>
                            @endif
                        </div>
                    </div>
                    
                    <a href="/servicios" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request()->is('servicios') ? 'bg-damian-blue/20 text-damian-blue' : 'text-damian-gray_light hover:text-white' }}">Servicios</a>
                    <a href="/proyectos" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request()->is('proyectos') ? 'bg-damian-blue/20 text-damian-blue' : 'text-damian-gray_light hover:text-white' }}">Proyectos</a>
                    
                    {{-- ACADEMIA DESKTOP --}}
                    <a href="https://academia.damiancompany.com.pe" 
                       target="_blank" 
                       class="px-5 py-2 rounded-full text-sm font-bold text-damian-gray_light hover:text-damian-blue hover:bg-damian-blue/10 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-damian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Academia
                    </a>

                    <a href="/nosotros" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request()->is('nosotros') ? 'bg-damian-blue/20 text-damian-blue' : 'text-damian-gray_light hover:text-white' }}">Nosotros</a>
                </nav>

                <form action="/tienda" method="GET" class="relative group">
                    <input type="text" name="q" placeholder="Búsqueda..." class="bg-damian-darker border border-white/10 text-white pl-4 pr-10 py-2 rounded-full outline-none text-sm w-48 focus:w-64 focus:border-damian-blue focus:ring-1 focus:ring-damian-blue transition-all duration-300 shadow-inner">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-damian-gray_mid group-focus-within:text-damian-blue transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                </form>
            </div>

            <button @click="mobileMenu = !mobileMenu" class="lg:hidden text-white p-2 z-50 focus:outline-none">
                <svg x-show="!mobileMenu" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenu" x-cloak class="w-7 h-7 text-damian-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- MENÚ MÓVIL CORREGIDO --}}
        <div x-show="mobileMenu" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             x-cloak
             class="lg:hidden absolute top-full left-0 w-full bg-damian-dark border-b border-damian-blue/20 shadow-2xl py-4 px-6 flex flex-col gap-4 max-h-[85vh] overflow-y-auto">
            
            <form action="/tienda" method="GET" class="relative mb-2">
                <input type="text" name="q" placeholder="Buscar producto..." class="w-full bg-damian-darker border border-white/10 text-white pl-4 pr-10 py-3 rounded-xl outline-none text-sm focus:border-damian-blue">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-damian-gray_mid"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
            </form>

            <a href="/" class="text-white font-bold text-lg py-2 border-b border-white/5">Inicio</a>
            
            <div x-data="{ tiendaMobile: false }" class="border-b border-white/5 py-2">
                <button type="button" @click="tiendaMobile = !tiendaMobile" :aria-expanded="tiendaMobile" aria-controls="tienda-menu-mobile" class="w-full flex justify-between items-center text-white font-bold text-lg">
                    Tienda
                    <svg :class="tiendaMobile ? 'rotate-180 text-damian-green' : ''" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="tienda-menu-mobile" x-show="tiendaMobile" x-collapse class="mt-4 rounded-xl border border-white/10 bg-damian-darker/60 p-3">
                    <a href="{{ route('tienda') }}" class="mb-3 flex items-center justify-between rounded-lg bg-damian-blue/10 px-3 py-2.5 text-sm font-bold text-damian-blue">
                        Ver todos los productos <span aria-hidden="true">→</span>
                    </a>

                    @foreach($categoriasNavbar as $categoria)
                        <div class="border-t border-white/5 py-3 first:border-t-0">
                            <a href="{{ route('tienda', ['cat' => \Illuminate\Support\Str::slug($categoria->nombre)]) }}" class="flex items-center gap-2 text-sm font-black uppercase tracking-wider text-white transition-colors hover:text-damian-green">
                                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-damian-green"></span>
                                {{ $categoria->nombre }}
                            </a>

                            @if($categoria->subCategorias->isNotEmpty())
                                <div class="ml-3 mt-2 flex flex-col border-l border-white/10 pl-4">
                                    @foreach($categoria->subCategorias as $subcategoria)
                                        <a href="{{ route('tienda', ['cat' => \Illuminate\Support\Str::slug($subcategoria->nombre)]) }}" class="py-2 text-sm text-damian-gray_light transition-colors hover:text-damian-blue">
                                            {{ $subcategoria->nombre }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <a href="/servicios" class="text-white font-bold text-lg py-2 border-b border-white/5">Servicios</a>
            <a href="/proyectos" class="text-white font-bold text-lg py-2 border-b border-white/5">Proyectos</a>
            
            {{-- ACADEMIA MÓVIL --}}
            <a href="https://academia.damiancompany.com.pe" 
               target="_blank" 
               class="text-damian-blue font-bold text-lg py-3 border-b border-white/5 flex justify-between items-center group">
                Academia 
                <span class="bg-damian-blue/10 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-tighter">Nuevo</span>
            </a>

            <a href="/nosotros" class="text-white font-bold text-lg py-2">Nosotros</a>
        </div>
    </header>

    <main class="flex-grow pt-[90px] md:pt-[110px]">  
        {{ $slot }}
    </main>

    <footer class="bg-damian-darker pt-12 md:pt-16 pb-8 border-t border-white/5 relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 md:gap-12 mb-8 md:mb-12">
            
            <div class="text-center sm:text-left">
                <a href="/" class="flex items-center justify-center sm:justify-start gap-3 mb-6">
                    <img src="{{ asset('img/logo.png') }}" alt="Damian Company Logo" class="h-10 w-auto object-contain">
                    <div class="flex flex-col text-left">
                        <span class="font-bold tracking-tight text-xl text-white leading-none">DAMIAN</span>
                        <span class="text-[9px] tracking-[0.25em] font-bold uppercase text-damian-green">COMPANY</span>
                    </div>
                </a>
                <p class="text-sm text-damian-gray_light mb-6 leading-relaxed">Fuerza y precisión que respaldan tu inversión en el Valle del Mantaro.</p>
            </div>
            
            <div class="text-center sm:text-left">
                <h4 class="text-white font-bold mb-4 md:mb-6 uppercase tracking-wider text-sm">Navegación</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="/tienda" class="text-damian-gray_light hover:text-damian-green transition-colors">Catálogo de Productos</a></li>
                    <li><a href="/servicios" class="text-damian-gray_light hover:text-damian-green transition-colors">Servicio Técnico</a></li>
                    <li><a href="/nosotros" class="text-damian-gray_light hover:text-damian-green transition-colors">Nosotros</a></li>
                    
                    {{-- ACADEMIA FOOTER --}}
                    <li><a href="https://academia.damiancompany.com.pe" target="_blank" class="text-damian-gray_light hover:text-damian-blue transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-blue"></span> Plataforma Academia</a></li>

                    <li class="pt-3">
                        <a href="https://forms.gle/a1UfnTH966vMBHsb6" target="_blank" class="inline-flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-damian-green p-3 rounded-xl transition-all duration-300 group w-full sm:w-auto justify-center sm:justify-start">
                            <svg class="w-6 h-6 text-damian-green group-hover:scale-110 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <div class="flex flex-col text-left">
                                <span class="text-white font-bold text-xs md:text-sm tracking-wide group-hover:text-damian-green transition-colors">Libro de Reclamaciones</span>
                                <span class="text-[9px] md:text-[10px] text-damian-gray_light uppercase tracking-wider">Atención al cliente</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="text-center sm:text-left">
                <h4 class="text-white font-bold mb-4 md:mb-6 uppercase tracking-wider text-sm">Contacto</h4>
                <ul class="space-y-4 text-sm text-damian-gray_light inline-block sm:block text-left">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-damian-blue shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> 
                        <span>Av. Argentina S/N,<br>Chupaca 12455</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-3">
                        <svg class="w-4 h-4 text-damian-green shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> 
                        <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                            <span>964 493 400</span>
                            <span class="hidden sm:inline">-</span>
                            <span>987 564 941</span>
                            <span class="hidden sm:inline">-</span>
                            <span>950 705 734</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="text-center py-4 md:py-6 border-t border-white/5 text-[10px] md:text-xs text-damian-gray_mid pb-20 md:pb-6">
            © 2026 Damian Company S.A.C.
        </div>
    </footer>

    <a href="https://wa.me/51964493400" target="_blank" class="fixed bottom-4 right-4 md:bottom-6 md:right-6 bg-[#25D366] text-white p-3 md:p-4 rounded-full shadow-[0_0_20px_rgba(37,211,102,0.4)] hover:scale-110 transition-transform z-[99]">
        <svg class="w-6 h-6 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
    </a>
</body>
</html>
