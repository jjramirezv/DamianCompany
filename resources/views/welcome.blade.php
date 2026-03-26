@php
    $categoriasDb = \App\Models\Categoria::whereNull('parent_id')->take(6)->get();
    $marcasDb = \App\Models\Marca::all();
@endphp

<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damian Company </title>
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
                <a href="tel:98756491" class="hidden sm:flex items-center gap-2 hover:text-damian-green transition-colors">
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
                        <svg class="w-5 h-5 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
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
                    <div class="absolute top-10 -right-10 bg-damian-blue/10 border border-damian-blue/50 text-damian-blue px-2 py-1 text-[8px] font-mono rounded backdrop-blur-sm">SYS_ACTIVE</div>
                    <div class="absolute bottom-24 -left-12 bg-damian-green/10 border border-damian-green/50 text-damian-green px-2 py-1 text-[8px] font-mono rounded backdrop-blur-sm">PWR: 100%</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-damian-darker relative border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-10 md:mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span class="font-mono text-sm tracking-wider uppercase text-damian-blue">Nuestras Soluciones</span>
                    <h2 class="text-3xl md:text-4xl font-black text-white mt-2">¿Qué estás buscando?</h2>
                </div>
                <a href="/tienda" class="inline-flex text-sm font-bold text-damian-green hover:text-white transition-colors">Ver todo el catálogo →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($categoriasDb as $cat)
                    <a href="/tienda?cat={{ $cat->id }}" class="group relative bg-damian-card rounded-2xl md:rounded-3xl overflow-hidden h-64 md:h-80 flex flex-col justify-end text-left hover:-translate-y-2 transition-all duration-500 shadow-2xl border border-white/10">
                        
                        <img src="{{ asset('img/cat-' . $loop->iteration . '.jpg') }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1504307651254-35680f356f58?q=80&w=800&auto=format&fit=crop'" 
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out" 
                             alt="{{ $cat->nombre }}">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0b1524] via-[#0b1524]/60 to-transparent"></div>

                        <div class="relative z-10 p-6 md:p-8">
                            <h3 class="text-2xl font-black text-white mb-3 md:mb-4 drop-shadow-lg leading-tight">{{ $cat->nombre }}</h3>
                            
                            <span class="inline-flex items-center gap-2 text-[10px] font-bold text-damian-green uppercase tracking-widest border border-damian-green/30 bg-damian-green/10 px-4 py-2 rounded-full backdrop-blur-md group-hover:bg-damian-green group-hover:text-white transition-all shadow-lg">
                                Ver Catálogo <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-10 bg-damian-card rounded-2xl border border-white/5">
                        <p class="text-damian-gray_mid">Agrega categorías principales en tu panel de administración.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20 bg-damian-dark relative overflow-hidden border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 mb-8 md:mb-12 text-center relative z-10">
            <span class="font-mono text-sm tracking-widest uppercase text-damian-blue">Confianza Garantizada</span>
            <h2 class="text-2xl md:text-3xl font-black text-white mt-2">Nuestros Partners Oficiales</h2>
            <div class="h-1 w-16 mt-4 mx-auto rounded-full bg-gradient-to-r from-damian-blue to-damian-green"></div>
        </div>
        
        <div class="relative w-full overflow-hidden flex items-center">
            <div class="absolute left-0 top-0 w-16 md:w-32 h-full bg-gradient-to-r from-damian-dark to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 w-16 md:w-32 h-full bg-gradient-to-l from-damian-dark to-transparent z-10 pointer-events-none"></div>
            
            <div class="flex animate-scroll gap-8 md:gap-12 w-max items-center px-4" style="--track-width: calc(-250px * {{ max($marcasDb->count(), 1) }});">
                @if($marcasDb->count() > 0)
                    @for ($i = 0; $i < 8; $i++)
                        @foreach($marcasDb as $marca)
                            <div class="w-[150px] md:w-[200px] h-[60px] md:h-[80px] flex items-center justify-center shrink-0 transition-transform hover:scale-110">
                                @if($marca->logo)
                                    <img src="{{ Storage::url($marca->logo) }}" alt="{{ $marca->nombre }}" class="max-h-full max-w-full object-contain filter  transition-all duration-300">
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

    <section class="py-16 md:py-24 bg-damian-darker border-y border-white/5 relative overflow-hidden">
        <div class="hidden lg:block absolute right-0 top-0 w-1/3 h-full bg-damian-card transform skew-x-12 translate-x-32 opacity-30 z-0"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            
            <div class="order-2 lg:order-1 text-center lg:text-left">
                <span class="font-mono text-sm tracking-wider uppercase text-damian-green">Conócenos</span>
                <h2 class="text-3xl md:text-4xl font-black text-white mt-2 mb-4 md:mb-6">Expertos en fuerza de trabajo desde Chupaca</h2>
                <p class="text-sm md:text-base text-damian-gray_light mb-6 leading-relaxed">En <strong>DAMIAN COMPANY</strong> no solo vendemos máquinas, entregamos soluciones. Entendemos que en el campo, la construcción y la industria, el tiempo es dinero y las herramientas no pueden fallar.</p>
                
                <ul class="space-y-3 md:space-y-4 mb-8 text-left max-w-md mx-auto lg:mx-0">
                    <li class="flex items-center gap-3 text-white font-medium text-sm md:text-base">
                        <svg class="w-5 h-5 text-damian-green shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Garantía Oficial en todas las marcas.
                    </li>
                    <li class="flex items-center gap-3 text-white font-medium text-sm md:text-base">
                        <svg class="w-5 h-5 text-damian-blue shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Amplio stock de repuestos originales.
                    </li>
                    <li class="flex items-center gap-3 text-white font-medium text-sm md:text-base">
                        <svg class="w-5 h-5 text-damian-green shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Taller de servicio técnico propio.
                    </li>
                </ul>

                <a href="/nosotros" class="inline-flex items-center justify-center sm:justify-start gap-2 border border-damian-gray_mid text-white px-6 py-3 rounded-lg hover:bg-white/10 transition-colors font-bold w-full sm:w-auto">
                    Conoce nuestros servicios →
                </a>
            </div>
            
            <div class="order-1 lg:order-2 relative h-[250px] sm:h-[350px] md:h-[400px] w-full rounded-2xl md:rounded-3xl overflow-hidden border border-white/10 shadow-2xl group">
                <div class="absolute inset-0 bg-damian-blue/10 mix-blend-overlay z-10 group-hover:opacity-0 transition-opacity"></div>
                <img src="{{ asset('img/conocenos.jpg') }}" alt="Equipo Damian Company" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" onerror="this.outerHTML='<div class=\'w-full h-full bg-damian-card flex flex-col items-center justify-center text-center p-4 text-damian-gray_mid border-2 border-dashed border-white/20\'><svg class=\'w-10 h-10 mb-2 opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><p class=\'text-xs\'>Sube tu foto a public/img/conocenos.jpg</p></div>'">
            </div>
        </div>
    </section>

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
                <p class="text-sm text-damian-gray_light mb-6 leading-relaxed">El mejor equipamiento forestal, agrícola y de construcción. Fuerza y precisión que respaldan tu inversión en el Valle del Mantaro.</p>
                
                <div class="flex gap-4 justify-center sm:justify-start">
                    <a href="https://www.facebook.com/share/1KyNPdbXe9/" class="text-damian-gray_mid hover:text-[#1877F2] transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                    <a href="https://www.instagram.com/damiancompany.pe?igsh=OGdjZGJieW5ycW41" class="text-damian-gray_mid hover:text-[#E4405F] transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.476 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg></a>
                    <a href="https://www.tiktok.com/@damian.company8?_r=1&_t=ZS-94T2UQTxdcD" class="text-damian-gray_mid hover:text-white transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 2.23-.9 4.45-2.46 5.96-1.25 1.23-2.92 2.01-4.73 2.13-1.8.1-3.64-.26-5.18-1.21-1.64-1.02-2.79-2.75-3.14-4.66-.36-1.95.03-4 .14-5.83 1.1-1.6 2.87-2.67 4.8-3.03 1.83-.34 3.76-.08 5.4.78.34.18.66.4.96.65v-4.14c-1.39-.42-2.88-.57-4.34-.41-1.81.18-3.56.96-4.94 2.18-1.57 1.39-2.54 3.4-2.71 5.51-.15 1.93.18 3.9 1.11 5.59 1.12 2.02 3.16 3.47 5.46 3.86 2.13.36 4.38-.05 6.13-1.32 1.67-1.22 2.72-3.14 2.95-5.22.25-2.22.11-4.46.16-6.69z" clip-rule="evenodd" /></svg></a>
                    <a href="https://www.linkedin.com/company/damian-company-s-a-c/about/" class="text-damian-gray_mid hover:text-[#0A66C2] transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" /></svg></a>
                </div>
            </div>

            <div class="text-center sm:text-left">
                <h4 class="text-white font-bold mb-4 md:mb-6 uppercase tracking-wider text-sm">Navegación</h4>
                <ul class="space-y-4">
                    <li><a href="/tienda" class="text-sm text-damian-gray_light hover:text-damian-green transition-colors inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-green"></span> Catálogo de Productos</a></li>
                    <li><a href="/servicios" class="text-sm text-damian-gray_light hover:text-damian-green transition-colors inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-green"></span> Servicio Técnico</a></li>
                    <li><a href="/nosotros" class="text-sm text-damian-gray_light hover:text-damian-green transition-colors inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-green"></span> Quiénes Somos</a></li>
                    <li><a href="/contacto" class="text-sm text-damian-gray_light hover:text-damian-green transition-colors inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-damian-green"></span> Contacto</a></li>    
                    <li class="pt-3">
                        <a href="https://forms.gle/a1UfnTH966vMBHsb6" target="_blank" class="inline-flex w-full sm:w-auto justify-center sm:justify-start items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-damian-green p-3 rounded-xl transition-all duration-300 group">
                            <svg class="w-6 h-6 text-damian-green group-hover:scale-110 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <div class="flex flex-col text-left">
                                <span class="text-white font-bold text-xs tracking-wide group-hover:text-damian-green transition-colors">Libro de Reclamaciones</span>
                                <span class="text-[9px] text-damian-gray_light uppercase tracking-wider">Atención al cliente</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="text-center sm:text-left">
                <h4 class="text-white font-bold mb-4 md:mb-6 uppercase tracking-wider text-sm">Contacto</h4>
                <ul class="space-y-4 text-sm text-damian-gray_light inline-block sm:block text-left">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-damian-blue shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Av. Argentina S/N,<br>Chupaca 12455 - Junín</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-3">
                        <svg class="w-5 h-5 text-damian-green shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                            <span>964 493 400</span>
                            <span class="hidden sm:inline">-</span>
                            <span>987 564 941</span>
                            <span class="hidden sm:inline">-</span>
                            <span>950 705 734</span>
                        </div>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-damian-blue shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Lun - Sáb: 8:00 am - 7:00 pm</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="text-center py-4 md:py-6 border-t border-white/5 text-[10px] md:text-xs text-damian-gray_mid pb-20 md:pb-6">
            © 2026 Damian Company S.A.C. Todos los derechos reservados.
        </div>
    </footer>

    <section class="w-full h-[300px] md:h-[400px] border-t border-white/5 relative z-10">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3708.794648645817!2d-75.28748982517465!3d-12.053482788183869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x730a19b859bfa2d%3A0x790001df47aedd8b!2sDAMIAN%20COMPANY!5e1!3m2!1ses-419!2spe!4v1772727565031!5m2!1ses-419!2spe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <a href="https://wa.me/51964493400" target="_blank" class="fixed bottom-4 right-4 md:bottom-6 md:right-6 bg-[#25D366] text-white p-3 md:p-4 rounded-full shadow-[0_0_20px_rgba(37,211,102,0.5)] hover:scale-110 transition-transform z-50">
        <svg class="w-6 h-6 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
    </a>
</body>
</html>