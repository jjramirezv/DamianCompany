<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damian Company | Maquinaria y Herramientas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #152036; }
        ::-webkit-scrollbar-thumb { background: #1a4e5c; border-radius: 4px; }
    </style>
</head>
<body class="bg-damian-dark text-damian-gray_light font-sans antialiased selection:bg-damian-green selection:text-white overflow-x-hidden">

    <header x-data="{ scrolled: false, megaMenu: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'bg-damian-dark/95 backdrop-blur-xl border-b border-damian-blue/20 shadow-[0_10px_30px_-10px_rgba(0,0,0,0.7)] py-1' : 'bg-transparent py-4'"
            class="fixed top-0 w-full z-[9999] transition-all duration-500">
        
        <div x-show="!scrolled" x-transition.opacity class="max-w-7xl mx-auto px-6 flex justify-between items-center border-b border-white/5 pb-3 mb-3">
            <div class="flex items-center gap-6 text-[11px] uppercase tracking-widest font-bold text-damian-gray_mid">
                <a href="tel:964493400" class="flex items-center gap-2 hover:text-damian-green transition-colors"><svg class="w-3 h-3 text-damian-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> 
                    <span>964 493 400</span>
                    <span>-</span>
                    <span>987 564 941</span>
                    <span>-</span>
                    <span>950 705 734</span>
                </a>
                <span class="flex items-center gap-2"><svg class="w-3 h-3 text-damian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Chupaca - Huancayo</span>
            </div>
            <a href="/admin" class="text-[10px] uppercase tracking-widest font-bold text-damian-gray_mid hover:text-white transition-colors flex items-center gap-1 bg-white/5 px-3 py-1 rounded-full border border-white/10"><svg class="w-3 h-3 text-damian-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> Admin</a>
        </div>

        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ asset('img/logo.png') }}" alt="Damian Company Logo" class="h-11 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <div class="flex flex-col">
                    <span class="font-bold tracking-tight text-xl leading-none text-white drop-shadow-md">DAMIAN</span>
                    <span class="text-[9px] tracking-[0.25em] font-bold uppercase text-damian-green">COMPANY</span>
                </div>
            </a>
            
            <div class="flex items-center gap-4 lg:gap-6">
                <nav class="hidden lg:flex items-center gap-1 bg-damian-card/40 p-1.5 rounded-full border border-white/10 backdrop-blur-md shadow-lg relative">
                    <a href="/" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ request()->is('/') ? 'bg-damian-blue/20 text-damian-blue' : 'text-damian-gray_light hover:text-white' }}">Inicio</a>
                    
                    <div @mouseenter="megaMenu = true" @mouseleave="megaMenu = false" class="relative z-50">
                        <button class="px-5 py-2 rounded-full text-sm font-bold text-damian-gray_light hover:text-white flex items-center gap-1 transition-all">Tienda <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
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

                <div class="hidden md:flex items-center">
                    <form action="/tienda" method="GET" class="relative group">
                        <input type="text" name="q" placeholder="Búsqueda..." class="bg-damian-darker border border-white/10 text-white pl-4 pr-10 py-2 rounded-full outline-none text-sm w-48 focus:w-64 focus:border-damian-blue focus:ring-1 focus:ring-damian-blue transition-all duration-300 shadow-inner">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-damian-gray_mid group-focus-within:text-damian-blue transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-damian-darker pt-16 pb-8 border-t border-white/5 relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <a href="/" class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('img/logo.png') }}" alt="Damian Company Logo" class="h-10 w-auto object-contain">
                    <div class="flex flex-col"><span class="font-bold tracking-tight text-xl text-white leading-none">DAMIAN</span><span class="text-[9px] tracking-[0.25em] font-bold uppercase text-damian-green">COMPANY</span></div>
                </a>
                <p class="text-sm text-damian-gray_light mb-6 leading-relaxed">Fuerza y precisión que respaldan tu inversión en el Valle del Mantaro.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Navegación</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="/tienda" class="text-damian-gray_light hover:text-damian-green transition-colors">Catálogo de Productos</a></li>
                    <li><a href="/servicios" class="text-damian-gray_light hover:text-damian-green transition-colors">Servicio Técnico</a></li>
                    <li><a href="/nosotros" class="text-damian-gray_light hover:text-damian-green transition-colors">Nosotros</a></li>
                    <li class="pt-2">
                        <a href="#" target="_blank" class="inline-flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-damian-green p-3 rounded-xl transition-all duration-300 group">
                            <svg class="w-7 h-7 text-damian-green group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-sm tracking-wide group-hover:text-damian-green transition-colors">Libro de Reclamaciones</span>
                                <span class="text-[10px] text-damian-gray_light uppercase tracking-wider">Atención al cliente</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Contacto</h4>
                <ul class="space-y-4 text-sm text-damian-gray_light">
                    <li class="flex items-center gap-3"><svg class="w-4 h-4 text-damian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> Av. Argentina S/N, Chupaca</li>
                    <li class="flex items-center gap-3"><svg class="w-4 h-4 text-damian-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> 
                        <span>964 493 400</span>
                        <span>-</span>
                        <span>987 564 941</span>
                        <span>-</span>
                        <span>950 705 734</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="text-center py-6 border-t border-white/5 text-xs text-damian-gray_mid">
            © 2026 Damian Company S.A.C.
        </div>
    </footer>

    <a href="https://wa.me/51964493400" target="_blank" class="fixed bottom-6 right-6 bg-[#25D366] text-white p-4 rounded-full shadow-2xl hover:scale-110 transition-transform z-[9999]">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
    </a>
</body>
</html>