@php
    $categoriasDb = \App\Models\Categoria::whereNull('parent_id')->take(6)->get();
    $marcasDbRaw = \App\Models\Marca::all();

    // 🚀 OPTIMIZACIÓN CLOUDINARY: Pre-procesamos las URLs de los logos
    $marcasOptimizadas = $marcasDbRaw->map(function($marca) {
        return (object) [
            'nombre' => $marca->nombre,
            'logo_url' => $marca->logo ? Storage::url($marca->logo) : null
        ];
    });
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
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes flicker {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% { opacity: 1; text-shadow: 0 0 15px #1bb1e3, 0 0 30px #1bb1e3; filter: drop-shadow(0 0 15px rgba(27,177,227,0.8)); }
            20%, 24%, 55% { opacity: 0.5; text-shadow: none; filter: none; }
        }
        .scanlines { background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,0) 50%, rgba(27, 177, 227, 0.1) 50%, rgba(27, 177, 227, 0.1)); background-size: 100% 4px; pointer-events: none; }
        .hologram-glow { animation: float 4s ease-in-out infinite, flicker 5s infinite; }
        
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(var(--track-width, -1000px)); }
        }
        .animate-scroll { animation: scroll 30s linear infinite; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #152036; }
        ::-webkit-scrollbar-thumb { background: #1a4e5c; border-radius: 4px; }
    </style>
</head>
<body class="bg-damian-dark text-damian-gray_light font-sans antialiased selection:bg-damian-green selection:text-white overflow-x-hidden">

    <header x-data="{ scrolled: false, megaMenu: false, mobileMenu: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'bg-damian-dark/95 backdrop-blur-xl border-b border-damian-blue/20 shadow-[0_10px_30px_-10px_rgba(0,0,0,0.7)] py-2 md:py-3' : 'bg-transparent py-4'"
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
                        <button class="px-5 py-2 rounded-full text-sm font-bold text-damian-gray_light hover:text-white flex items-center gap-1 transition-all">
                            Tienda <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="megaMenu" x-transition.opacity.duration.300ms class="absolute left-1/2 -translate-x-1/2 top-[100%] w-48 mt-4 bg-damian-darker/95 backdrop-blur-xl border border-damian-blue/30 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.8)] py-2 flex flex-col overflow-hidden" style="display: none;">
                            <a href="/tienda?cat=agro-forestal" class="px-5 py-3 text-[11px] font-bold text-damian-gray_light hover:text-white hover:bg-white/5 uppercase tracking-wider transition-colors border-l-2 border-transparent hover:border-damian-green">Agro-Forestal</a>
                            <a href="/tienda?cat=maquinarias" class="px-5 py-3 text-[11px] font-bold text-damian-gray_light hover:text-white hover:bg-white/5 uppercase tracking-wider transition-colors border-l-2 border-transparent hover:border-damian-blue">Maquinarias</a>
                            <a href="/tienda?cat=construccion" class="px-5 py-3 text-[11px] font-bold text-damian-gray_light hover:text-white hover:bg-white/5 uppercase tracking-wider transition-colors border-l-2 border-transparent hover:border-damian-green">Construcción</a>
                            <a href="/tienda?cat=especializados" class="px-5 py-3 text-[11px] font-bold text-damian-gray_light hover:text-white hover:bg-white/5 uppercase tracking-wider transition-colors border-l-2 border-transparent hover:border-damian-blue">Electrónica</a>
                        </div>
                    </div>
                    
                    <a href="/servicios" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request()->is('servicios') ? 'bg-damian-blue/20 text-damian-blue' : 'text-damian-gray_light hover:text-white' }}">Servicios</a>
                    <a href="/proyectos" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request()->is('proyectos') ? 'bg-damian-blue/20 text-damian-blue' : 'text-damian-gray_light hover:text-white' }}">Proyectos</a>
                    
                    {{-- ACADEMIA DESKTOP --}}
                    <a href="https://academia.damiancompany.com.pe" 
                       target="_blank" 
                       class="px-5 py-2 rounded-full text-sm font-bold text-damian-gray_light hover:text-damian-blue hover:bg-damian-blue/10 transition-all flex items-center gap-2">
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
                <button @click="tiendaMobile = !tiendaMobile" class="w-full flex justify-between items-center text-white font-bold text-lg">
                    Catálogo
                    <svg :class="tiendaMobile ? 'rotate-180 text-damian-green' : ''" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="tiendaMobile" x-collapse class="flex flex-col gap-3 pl-4 mt-4">
                    <a href="/tienda?cat=agro-forestal" class="text-damian-gray_light hover:text-damian-green text-sm flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-green"></span> Agro-Forestal</a>
                    <a href="/tienda?cat=maquinarias" class="text-damian-gray_light hover:text-damian-blue text-sm flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-blue"></span> Maquinarias</a>
                    <a href="/tienda?cat=construccion" class="text-damian-gray_light hover:text-damian-green text-sm flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-green"></span> Construcción</a>
                    <a href="/tienda?cat=especializados" class="text-damian-gray_light hover:text-damian-blue text-sm flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-blue"></span> Electrónica</a>
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

    <section class="relative min-h-[90vh] md:min-h-screen flex items-center pt-32 pb-12 md:pt-24 md:pb-12 overflow-hidden bg-damian-dark">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: linear-gradient(#0f404f 1px, transparent 1px), linear-gradient(90deg, #0f404f 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="absolute inset-0 scanlines z-0"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full grid lg:grid-cols-2 gap-12 items-center text-center lg:text-left">
            <div class="relative z-20 flex flex-col items-center lg:items-start">
                <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-6 md:mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 border rounded-full backdrop-blur-md bg-damian-darker/50 border-damian-green/30">
                        <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-damian-green opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-damian-green"></span></span>
                        <span class="text-[10px] font-mono tracking-widest uppercase text-damian-green">Garantía Real</span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 border rounded-full backdrop-blur-md bg-damian-darker/50 border-damian-blue/30">
                        <svg class="w-3 h-3 text-damian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        <span class="text-[10px] font-mono tracking-widest uppercase text-damian-blue">Soporte Técnico</span>
                    </div>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white leading-[1.1] mb-6 tracking-tight">
                    Equipamiento de <br class="hidden sm:block"/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-damian-blue to-damian-green">Alto Rendimiento.</span>
                </h1>
                <p class="text-base md:text-lg text-damian-gray_light mb-8 md:mb-10 leading-relaxed font-light border-l-2 pl-4 md:pl-6 border-damian-blue max-w-lg mx-auto lg:mx-0">
                    Maquinaria agrícola, forestal y herramientas de construcción con el respaldo que tu proyecto exige.
                </p>
                <div class="flex flex-col sm:flex-row flex-wrap gap-4 w-full sm:w-auto justify-center lg:justify-start">
                    <a href="/tienda" class="group relative px-6 md:px-8 py-3 md:py-4 text-white font-bold rounded-xl overflow-hidden shadow-lg transition-all hover:scale-105 bg-damian-green shadow-[0_0_15px_rgba(34,161,94,0.4)] text-center w-full sm:w-auto">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <span class="relative flex items-center justify-center gap-2">Ver Maquinarias <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>
                    </a>
                    <a href="https://wa.me/51964493400" target="_blank" class="px-6 md:px-8 py-3 md:py-4 rounded-xl border border-white/20 text-white font-bold hover:bg-white/5 transition-all flex items-center justify-center gap-2 w-full sm:w-auto">
                        Cotizar
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex relative h-[500px] items-center justify-center">
                <div class="absolute bottom-10 w-[300px] h-[300px] bg-damian-blue/20 rounded-full blur-[80px] pointer-events-none z-0 mix-blend-screen"></div>
                <div class="absolute bottom-16 w-64 h-16 rounded-[100%] border-2 border-damian-blue/30 shadow-[0_0_50px_rgba(27,177,227,0.3)] bg-damian-darker/80 z-10 flex items-center justify-center">
                    <div class="w-48 h-10 rounded-[100%] border border-damian-blue/50 bg-damian-blue/10 animate-pulse"></div>
                </div>
                <div class="relative z-20 hologram-glow pb-20">
                    <svg class="w-64 h-64 text-damian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN PARTNERS OPTIMIZADA --}}
    <section class="py-16 md:py-20 bg-damian-dark relative overflow-hidden border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 mb-8 md:mb-12 text-center relative z-10">
            <span class="font-mono text-sm tracking-widest uppercase text-damian-blue">Confianza Garantizada</span>
            <h2 class="text-2xl md:text-3xl font-black text-white mt-2">Nuestros Partners Oficiales</h2>
            <div class="h-1 w-16 mt-4 mx-auto rounded-full bg-gradient-to-r from-damian-blue to-damian-green"></div>
        </div>
        
        <div class="relative w-full overflow-hidden flex items-center">
            <div class="absolute left-0 top-0 w-16 md:w-32 h-full bg-gradient-to-r from-damian-dark to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 w-16 md:w-32 h-full bg-gradient-to-l from-damian-dark to-transparent z-10 pointer-events-none"></div>
            
            <div class="flex animate-scroll gap-8 md:gap-12 w-max items-center px-4" style="--track-width: calc(-250px * {{ max($marcasOptimizadas->count(), 1) }});">
                @if($marcasOptimizadas->count() > 0)
                    @for ($i = 0; $i < 8; $i++)
                        @foreach($marcasOptimizadas as $marca)
                            <div class="w-[150px] md:w-[200px] h-[60px] md:h-[80px] flex items-center justify-center shrink-0 transition-transform hover:scale-110">
                                @if($marca->logo_url)
                                    <img src="{{ $marca->logo_url }}" alt="{{ $marca->nombre }}" class="max-h-full max-w-full object-contain filter transition-all duration-300">
                                @else
                                    <span class="text-lg md:text-xl font-black text-white/50 hover:text-white tracking-widest uppercase transition-colors">{{ $marca->nombre }}</span>
                                @endif
                            </div>
                        @endforeach
                    @endfor
                @else
                    <p class="text-damian-gray_mid ml-10">Agrega marcas con sus logos en el panel de administrador.</p>
                @endif
            </div>
        </div>
    </section>

    <livewire:productos-destacados />

    <footer class="bg-damian-darker pt-12 md:pt-16 pb-8 border-t border-white/5 relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 md:gap-12 mb-10 md:mb-12">
            
            <div class="text-center sm:text-left">
                <a href="/" class="flex items-center justify-center sm:justify-start gap-3 mb-6">
                    <img src="{{ asset('img/logo.png') }}" alt="Damian Company Logo" class="h-10 w-auto object-contain">
                    <div class="flex flex-col text-left">
                        <span class="font-bold tracking-tight text-xl text-white leading-none">DAMIAN</span>
                        <span class="text-[9px] tracking-[0.25em] font-bold uppercase text-damian-green">COMPANY</span>
                    </div>
                </a>
                <p class="text-sm text-damian-gray_light mb-6 leading-relaxed">El mejor equipamiento forestal, agrícola y de construcción.</p>
            </div>

            <div class="text-center sm:text-left">
                <h4 class="text-white font-bold mb-4 md:mb-6 uppercase tracking-wider text-sm">Navegación</h4>
                <ul class="space-y-4">
                    <li><a href="/tienda" class="text-sm text-damian-gray_light hover:text-damian-green transition-colors inline-flex items-center gap-2">Catálogo</a></li>
                    <li><a href="/servicios" class="text-sm text-damian-gray_light hover:text-damian-green transition-colors inline-flex items-center gap-2">Servicios</a></li>
                    
                    {{-- ACADEMIA FOOTER --}}
                    <li><a href="https://academia.damiancompany.com.pe" target="_blank" class="text-sm text-damian-gray_light hover:text-damian-blue transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-blue"></span> Plataforma Academia</a></li>

                    <li><a href="/nosotros" class="text-sm text-damian-gray_light hover:text-damian-green transition-colors inline-flex items-center gap-2">Nosotros</a></li>
                </ul>
            </div>

            <div class="text-center sm:text-left">
                <h4 class="text-white font-bold mb-4 md:mb-6 uppercase tracking-wider text-sm">Contacto</h4>
                <ul class="space-y-4 text-sm text-damian-gray_light inline-block sm:block text-left">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-damian-blue shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        <span>Av. Argentina S/N, Chupaca</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="text-center py-4 md:py-6 border-t border-white/5 text-[10px] md:text-xs text-damian-gray_mid pb-20 md:pb-6">
            © 2026 Damian Company S.A.C.
        </div>
    </footer>

    <a href="https://wa.me/51964493400" target="_blank" class="fixed bottom-4 right-4 md:bottom-6 md:right-6 bg-[#25D366] text-white p-3 md:p-4 rounded-full shadow-[0_0_20px_rgba(37,211,102,0.5)] hover:scale-110 transition-transform z-50">
        <svg class="w-6 h-6 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
    </a>
</body>
</html>