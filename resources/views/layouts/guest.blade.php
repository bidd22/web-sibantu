<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIBANTU') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .hero-gradient {
                background: 
                    radial-gradient(circle at 50% 50%, rgba(79, 70, 229, 0.08) 0%, rgba(255, 255, 255, 0) 100%),
                    linear-gradient(to right, rgba(99, 102, 241, 0.04) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(99, 102, 241, 0.04) 1px, transparent 1px),
                    #f8fafc;
                background-size: 100% 100%, 24px 24px, 24px 24px;
            }
        </style>
    </head>
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .hero-gradient {
                background: 
                    radial-gradient(circle at 50% 50%, rgba(79, 70, 229, 0.08) 0%, rgba(255, 255, 255, 0) 100%),
                    linear-gradient(to right, rgba(99, 102, 241, 0.03) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(99, 102, 241, 0.03) 1px, transparent 1px),
                    #f8fafc;
                background-size: 100% 100%, 24px 24px, 24px 24px;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased hero-gradient min-h-screen relative overflow-x-hidden flex items-center justify-center py-12 md:py-20">
        <!-- Floating decorative blurs in background -->
        <div class="absolute top-0 left-1/4 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-indigo-300/10 to-indigo-500/10 rounded-full blur-[120px] pointer-events-none animate-pulse" style="animation-duration: 10s;"></div>
        <div class="absolute bottom-0 right-1/4 translate-x-1/2 translate-y-1/2 w-[700px] h-[700px] bg-gradient-to-tr from-purple-300/10 to-purple-500/10 rounded-full blur-[140px] pointer-events-none animate-pulse" style="animation-duration: 15s;"></div>

        <div class="w-full max-w-4xl px-4 z-10">
            <!-- Modern Dual-Pane Container Card -->
            <div class="w-full bg-white/80 backdrop-blur-xl border border-white/75 shadow-[0_30px_70px_rgba(79,70,229,0.08)] rounded-[28px] overflow-hidden grid md:grid-cols-12 min-h-[580px] transition-all duration-500 hover:shadow-[0_35px_80px_rgba(79,70,229,0.12)]">
                
                <!-- Left Pane: Elegant Brand Showcase (Hidden on Mobile) -->
                <div class="hidden md:flex md:col-span-5 bg-gradient-to-br from-indigo-600 via-indigo-650 to-purple-600 p-10 flex-col justify-between relative overflow-hidden text-white border-r border-indigo-500/10">
                    <!-- Glowing circular shapes inside left pane -->
                    <div class="absolute -top-10 -left-10 w-44 h-44 bg-white/10 rounded-full blur-2xl pointer-events-none animate-pulse" style="animation-duration: 6s;"></div>
                    <div class="absolute -bottom-20 -right-10 w-60 h-60 bg-purple-500/20 rounded-full blur-3xl pointer-events-none animate-pulse" style="animation-duration: 9s;"></div>
                    
                    <!-- Top: Brand Logo -->
                    <div class="flex flex-col gap-1.5 z-10 relative">
                        <a href="/" class="inline-block">
                            <span class="text-3xl font-extrabold tracking-wider bg-gradient-to-r from-white to-indigo-100 bg-clip-text text-transparent">SIBANTU</span>
                        </a>
                        <span class="text-[9px] font-bold tracking-widest text-indigo-200/90 uppercase">Bantuan Sosial Modern</span>
                    </div>

                    <!-- Middle: Core Highlights -->
                    <div class="space-y-8 z-10 relative py-8">
                        <div class="flex items-start gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-lg shadow-sm border border-white/10 group-hover:scale-110 transition duration-300">📋</div>
                            <div>
                                <h4 class="font-bold text-xs text-white uppercase tracking-wider">Ajukan Bantuan</h4>
                                <p class="text-[11px] text-indigo-100/80 mt-1 leading-relaxed">Formulir digital cepat, ringkas, dan dapat dilakukan kapan saja.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-lg shadow-sm border border-white/10 group-hover:scale-110 transition duration-300">📊</div>
                            <div>
                                <h4 class="font-bold text-xs text-white uppercase tracking-wider">Lacak Real-Time</h4>
                                <p class="text-[11px] text-indigo-100/80 mt-1 leading-relaxed">Transparan. Pantau langsung setiap tahap verifikasi berkas Anda.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-lg shadow-sm border border-white/10 group-hover:scale-110 transition duration-300">💬</div>
                            <div>
                                <h4 class="font-bold text-xs text-white uppercase tracking-wider">Aduan Langsung</h4>
                                <p class="text-[11px] text-indigo-100/80 mt-1 leading-relaxed">Laporkan kendala, kritik, atau saran langsung ke admin sistem.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom: Warm Footer Message -->
                    <div class="z-10 relative">
                        <p class="text-[10px] text-indigo-200/70 font-medium leading-relaxed">
                            © {{ date('Y') }} SIBANTU. Membangun kepedulian bersama dengan transparansi penuh.
                        </p>
                    </div>
                </div>

                <!-- Right Pane: The Form Slot -->
                <div class="col-span-12 md:col-span-7 px-8 py-12 md:px-12 md:py-14 flex flex-col justify-center">
                    {{ $slot }}
                </div>

            </div>
        </div>
    </body>
</html>
