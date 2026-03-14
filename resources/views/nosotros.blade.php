<x-layouts.app>
    <style> 
        [x-cloak] { display: none !important; } 

        /* Animación de marquesina infinita - Flujo constante */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 50s linear infinite; /* Un poco más lento para que sea elegante */
        }
        /* Eliminamos el pause on hover como pediste */
    </style>

    <section class="relative pt-32 pb-20 overflow-hidden bg-damian-dark border-b border-white/5">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: linear-gradient(#0f404f 1px, transparent 1px), linear-gradient(90deg, #0f404f 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center flex flex-col items-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-damian-blue/10 border border-damian-blue/20 text-damian-blue text-xs font-black tracking-widest uppercase mb-6">
                <span class="w-2 h-2 rounded-full bg-damian-blue animate-pulse"></span>
                El Motor de Damian Company
            </span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-tight mb-6 tracking-tight max-w-4xl">
                Forjando el desarrollo <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-damian-blue to-damian-green">desde adentro.</span>
            </h1>
            <p class="text-base md:text-lg text-damian-gray_light max-w-2xl leading-relaxed">
                Nacimos con un propósito claro: dotar al agricultor, constructor y empresario del Valle del Mantaro con la fuerza que necesitan para no detenerse nunca.
            </p>
        </div>
    </section>

    <section class="py-24 bg-damian-darker relative z-10 border-b border-white/5 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 mb-12">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                <div>
                    <span class="text-[10px] font-bold text-damian-green uppercase tracking-[0.2em] mb-2 block">Nuestra Trayectoria</span>
                    <h2 class="text-3xl md:text-4xl font-black text-white">Años de experiencia en el campo</h2>
                </div>
                <p class="text-damian-gray_mid max-w-md text-sm leading-relaxed md:text-right">
                    Un vistazo a nuestro trabajo diario, nuestro equipo y la confianza que hemos construido.
                </p>
            </div>
        </div>

        <div class="relative flex overflow-hidden">
            <div class="absolute inset-y-0 left-0 w-20 md:w-40 bg-gradient-to-r from-damian-darker to-transparent z-10"></div>
            <div class="absolute inset-y-0 right-0 w-20 md:w-40 bg-gradient-to-l from-damian-darker to-transparent z-10"></div>

            <div class="flex gap-6 animate-marquee whitespace-nowrap">
                <div class="flex ">
                    <img src="img/nosotros4.jpg" class="w-[300px] md:w-[450px] h-[200px] md:h-[300px] rounded-[30px] object-cover border border-white/5 shadow-2xl" alt="1">
                    <img src="img/nosotros2.jpg" class="w-[300px] md:w-[450px] h-[200px] md:h-[300px] rounded-[30px] object-cover border border-white/5 shadow-2xl" alt="2">
                    <img src="img/nosotros.jpg" class="w-[300px] md:w-[450px] h-[200px] md:h-[300px] rounded-[30px] object-cover border border-white/5 shadow-2xl" alt="3">
                    <img src="img/nosotros3.jpg" class="w-[300px] md:w-[450px] h-[200px] md:h-[300px] rounded-[30px] object-cover border border-white/5 shadow-2xl" alt="4">
                    <img src="img/nosotros.jpg" class="w-[300px] md:w-[450px] h-[200px] md:h-[300px] rounded-[30px] object-cover border border-white/5 shadow-2xl" alt="5">
                    <img src="img/nosotros2.jpg" class="w-[300px] md:w-[450px] h-[200px] md:h-[300px] rounded-[30px] object-cover border border-white/5 shadow-2xl" alt="6">
                </div>
               
            </div>
        </div>
    </section>

    <section class="py-20 lg:py-32 bg-damian-dark relative z-10 overflow-hidden">
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-damian-blue/5 rounded-full blur-[150px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-16 text-center relative z-20">
                <span class="text-[10px] font-bold text-damian-blue uppercase tracking-[0.2em] mb-4 block">Nuestro ADN Corporativo</span>
                <h2 class="text-4xl md:text-5xl font-black text-white">Nuestra Filosofía</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-20 items-stretch">
                
                <div class="group bg-damian-darker border border-white/5 p-10 rounded-[2rem] hover:border-damian-blue/40 transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_20px_50px_-15px_rgba(27,177,227,0.25)] relative overflow-hidden flex flex-col">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-damian-blue/20 blur-[60px] rounded-full group-hover:scale-150 transition-transform duration-700 ease-out opacity-0 group-hover:opacity-100 pointer-events-none"></div>
                    
                    <div class="w-16 h-16 bg-damian-blue/10 rounded-2xl flex items-center justify-center mb-8 border border-damian-blue/20 relative z-10 group-hover:scale-110 group-hover:bg-damian-blue/20 transition-all duration-500">
                        <svg class="w-8 h-8 text-damian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    
                    <h3 class="text-3xl font-black text-white mb-6 relative z-10 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-damian-blue transition-all duration-300">Misión</h3>
                    
                    <p class="text-damian-gray_light leading-relaxed text-base relative z-10 group-hover:text-white transition-colors duration-300 flex-grow">
                        "Impulsar la transformación tecnológica de empresas, instituciones y emprendedores mediante <strong class="font-bold text-white group-hover:text-damian-blue transition-colors">soluciones innovadoras</strong> en fabricación digital, automatización, inteligencia artificial y desarrollo de maquinaria, ofreciendo calidad, confianza y valor en cada proyecto."
                    </p>
                </div>

                <div class="group bg-damian-darker border border-white/5 p-10 rounded-[2rem] hover:border-damian-green/40 transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_20px_50px_-15px_rgba(34,161,94,0.25)] relative overflow-hidden flex flex-col">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-damian-green/20 blur-[60px] rounded-full group-hover:scale-150 transition-transform duration-700 ease-out opacity-0 group-hover:opacity-100 pointer-events-none"></div>

                    <div class="w-16 h-16 bg-damian-green/10 rounded-2xl flex items-center justify-center mb-8 border border-damian-green/20 relative z-10 group-hover:scale-110 group-hover:bg-damian-green/20 transition-all duration-500">
                        <svg class="w-8 h-8 text-damian-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <h3 class="text-3xl font-black text-white mb-6 relative z-10 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-damian-green transition-all duration-300">Visión</h3>
                    
                    <p class="text-damian-gray_light leading-relaxed text-base relative z-10 group-hover:text-white transition-colors duration-300 flex-grow">
                        "Consolidarnos como una <strong class="font-bold text-white group-hover:text-damian-green transition-colors">referencia en el Perú en innovación tecnológica y fabricación avanzada</strong>, destacando por nuestra capacidad de diseñar, desarrollar e implementar soluciones que integren ingeniería, creatividad y tecnología para construir el futuro."
                    </p>
                </div>

                <div class="group bg-damian-darker border border-white/5 p-10 rounded-[2rem] hover:border-white/30 transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_20px_50px_-15px_rgba(255,255,255,0.15)] relative overflow-hidden flex flex-col">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 blur-[60px] rounded-full group-hover:scale-150 transition-transform duration-700 ease-out opacity-0 group-hover:opacity-100 pointer-events-none"></div>

                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-8 border border-white/10 relative z-10 group-hover:scale-110 group-hover:bg-white/10 transition-all duration-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <h3 class="text-3xl font-black text-white mb-8 relative z-10 group-hover:text-white transition-all duration-300">Valores</h3>
                    
                    <ul class="space-y-6 text-xl font-bold text-damian-gray_light relative z-10 flex-grow">
                        <li class="flex items-center gap-4 transition-transform duration-500 group-hover:translate-x-2"><div class="w-2.5 h-2.5 bg-damian-blue rounded-full shadow-[0_0_10px_rgba(27,177,227,0.8)] group-hover:scale-150 transition-transform duration-300"></div> Innovación</li>
                        <li class="flex items-center gap-4 transition-transform duration-500 delay-75 group-hover:translate-x-2"><div class="w-2.5 h-2.5 bg-damian-green rounded-full shadow-[0_0_10px_rgba(34,161,94,0.8)] group-hover:scale-150 transition-transform duration-300"></div> Calidad</li>
                        <li class="flex items-center gap-4 transition-transform duration-500 delay-100 group-hover:translate-x-2"><div class="w-2.5 h-2.5 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,0.8)] group-hover:scale-150 transition-transform duration-300"></div> Disciplina</li>
                        <li class="flex items-center gap-4 transition-transform duration-500 delay-150 group-hover:translate-x-2"><div class="w-2.5 h-2.5 bg-[#25D366] rounded-full shadow-[0_0_10px_rgba(37,211,102,0.8)] group-hover:scale-150 transition-transform duration-300"></div> Compromiso</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <section class="py-16 md:py-20 bg-damian-darker border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <span class="text-4xl md:text-6xl font-black text-white block mb-2">+5</span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-damian-green">Años de Experiencia</span>
            </div>
            <div>
                <span class="text-4xl md:text-6xl font-black text-white block mb-2">100%</span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-damian-blue">Garantía Oficial</span>
            </div>
            <div>
                <span class="text-4xl md:text-6xl font-black text-white block mb-2">+200</span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-white">Equipos Entregados</span>
            </div>
            <div>
                <span class="text-4xl md:text-6xl font-black text-white block mb-2">24/7</span>
                <span class="text-[10px] uppercase tracking-widest font-bold text-damian-gray_mid">Asesoramiento</span>
            </div>
        </div>
    </section>
</x-layouts.app>