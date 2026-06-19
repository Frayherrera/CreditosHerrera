<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CreditosHerrera — Artículos para tu hogar a crédito</title>
    <meta name="theme-color" content="#0f172a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="apple-touch-icon" sizes="180x180" href="/pwa/icons/ios/180.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/pwa/icons/ios/192.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Outfit', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        credit: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        }
                    },
                    animation: {
                        'slide-up': 'slide-up 0.5s ease-out forwards',
                        'fade-in': 'fade-in 0.6s ease-out forwards',
                    },
                    keyframes: {
                        'slide-up': {
                            from: { opacity: '0', transform: 'translateY(16px)' },
                            to: { opacity: '1', transform: 'translateY(0)' },
                        },
                        'fade-in': {
                            from: { opacity: '0' },
                            to: { opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }

        .hover-lift {
            transition: transform 0.25s cubic-bezier(.4,0,.2,1), box-shadow 0.25s cubic-bezier(.4,0,.2,1);
        }
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -8px rgba(0,0,0,0.12);
        }

        .product-img {
            aspect-ratio: 4/3;
            object-fit: cover;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>

    <script>
        function filterProducts(slug) {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                const isActive = btn.dataset.slug === slug;
                btn.className = `filter-btn px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap ${isActive ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'} transition-colors`;
            });
            document.querySelectorAll('[data-category]').forEach(card => {
                card.style.display = slug === 'all' || card.dataset.category === slug ? '' : 'none';
            });
        }
    </script>
</head>

<body class="font-body antialiased bg-slate-50 text-slate-700">


    <!-- Header -->
    <header class="sticky top-0 z-50 bg-slate-900 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center shrink-0">
                    <img src="{{ asset('logosinfondo.png') }}" alt="CreditosHerrera" class="h-12 w-auto">
                </a>

                <nav class="hidden md:flex items-center gap-6">
                    <a href="#productos" onclick="filterProducts('all')" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Todos</a>
                    @foreach($categories as $cat)
                        <a href="#productos" onclick="filterProducts('{{ $cat->slug }}')" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">{{ $cat->name }}</a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-3">
                    
                    @auth
                        <a href="{{ route('inventario.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 bg-credit-500 text-slate-900 text-sm font-semibold rounded-lg hover:bg-credit-400 transition-colors">
                            Mi cuenta
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors hidden sm:inline">Ingresar</a>
                    @endauth
                    <button id="menu-btn" class="md:hidden p-2 rounded-lg hover:bg-slate-800 transition-colors" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-800 bg-slate-900">
            <div class="px-4 py-4 space-y-3">
                <a href="#productos" onclick="filterProducts('all')" class="block text-sm font-medium text-slate-300">Todos</a>
                @foreach($categories as $cat)
                    <a href="#productos" onclick="filterProducts('{{ $cat->slug }}')" class="block text-sm font-medium text-slate-300">{{ $cat->name }}</a>
                @endforeach
                @auth
                    <a href="{{ route('inventario.dashboard') }}" class="block text-sm font-semibold text-white">Mi cuenta</a>
                @else
                    <a href="{{ route('login') }}" class="block text-sm font-medium text-slate-300">Ingresar</a>
                    <a href="{{ route('register') }}" class="block text-center px-4 py-2.5 bg-credit-500 text-slate-900 text-sm font-semibold rounded-lg">Solicitar crédito</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main -->
    <main>
        <!-- Hero — categorías -->
        <section class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-center">
                    <div class="flex-1 text-center lg:text-left">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-credit-100 text-credit-700 text-sm font-medium mb-4">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Aprobación en minutos
                        </span>
                        <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl text-slate-900 leading-tight mb-4">
                            El hogar que sueñas,<br>
                            <span class="text-credit-500">a crédito hoy</span>
                        </h1>
                        <p class="text-slate-500 text-lg max-w-lg mx-auto lg:mx-0 mb-8">
                            Electrodomésticos, muebles, decoración y más. Llévalo ahora y paga cómodamente en cuotas.
                        </p>
                        <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                            <a href="#productos" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition-colors">
                                Ver productos
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-credit-500 text-credit-600 font-semibold rounded-xl hover:bg-credit-50 transition-colors">
                                Solicitar crédito
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 w-full max-w-lg">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-xl bg-slate-100 p-4 text-center">
                                <div class="w-10 h-10 rounded-lg bg-credit-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-credit-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                    </svg>
                                </div>
                                <div class="font-display text-lg text-slate-900">Tecnología</div>
                                <div class="text-xs text-slate-500">Desde $30,000/mes</div>
                            </div>
                            <div class="rounded-xl bg-slate-100 p-4 text-center">
                                <div class="w-10 h-10 rounded-lg bg-credit-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-credit-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                                    </svg>
                                </div>
                                <div class="font-display text-lg text-slate-900">Electro</div>
                                <div class="text-xs text-slate-500">Desde $50,000/mes</div>
                            </div>
                            <div class="rounded-xl bg-slate-100 p-4 text-center">
                                <div class="w-10 h-10 rounded-lg bg-credit-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-credit-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                </div>
                                <div class="font-display text-lg text-slate-900">Muebles</div>
                                <div class="text-xs text-slate-500">Desde $40,000/mes</div>
                            </div>
                            <div class="rounded-xl bg-slate-100 p-4 text-center">
                                <div class="w-10 h-10 rounded-lg bg-credit-100 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-credit-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V12m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div class="font-display text-lg text-slate-900">Cocina</div>
                                <div class="text-xs text-slate-500">Desde $20,000/mes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filtros rápidos -->
        <section class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
                    <button onclick="filterProducts('all')" class="filter-btn px-4 py-2 rounded-full bg-slate-900 text-white text-sm font-medium whitespace-nowrap" data-slug="all">Todos</button>
                    @foreach($categories as $cat)
                        <button onclick="filterProducts('{{ $cat->slug }}')" class="filter-btn px-4 py-2 rounded-full bg-slate-100 text-slate-600 text-sm font-medium whitespace-nowrap hover:bg-slate-200 transition-colors" data-slug="{{ $cat->slug }}">{{ $cat->name }}</button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Productos -->
        <section id="productos" class="py-8 lg:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="font-display text-2xl sm:text-3xl text-slate-900">Productos destacados</h2>
                        <p class="text-slate-500 text-sm mt-1">Artículos para tu hogar con crédito fácil</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 text-sm text-slate-500">
                        <span>Ordenar por:</span>
                        <select class="bg-slate-100 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-700 border-0 focus:ring-2 focus:ring-credit-500">
                            <option>Más populares</option>
                            <option>Menor precio</option>
                            <option>Mayor precio</option>
                        </select>
                    </div>
                </div>

                @php
                    $formatter = function($amount) {
                        return '$ ' . number_format($amount, 0, ',', '.');
                    };
                @endphp

                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                    @foreach($products as $producto)
                        <div class="group rounded-xl bg-white border border-slate-200 overflow-hidden hover-lift flex flex-col" data-category="{{ $producto->category->slug }}">
                            <div class="relative overflow-hidden">
                                @php
                                    $imgUrl = $producto->images->where('is_primary', true)->first()?->path
                                        ?? $producto->images->first()?->path;
                                @endphp
                                @if($imgUrl)
                                    <img src="{{ asset('storage/' . $imgUrl) }}" alt="{{ $producto->name }}"
                                        class="w-full product-img group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy">
                                @else
                                    <div class="w-full product-img bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                                        Sin imagen
                                    </div>
                                @endif
                                <button class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-white">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-3 sm:p-4 flex flex-col flex-1">
                                <span class="text-xs text-slate-400 uppercase tracking-wide">{{ $producto->category->name }}</span>
                                <h3 class="font-semibold text-slate-900 text-sm sm:text-base mt-0.5 mb-1 leading-tight">{{ $producto->name }}</h3>
                                <div class="mt-auto pt-2">
                                    <div class="text-lg sm:text-xl font-display text-slate-900">{{ $formatter($producto->price) }}</div>
                                    <div class="flex items-center gap-1 text-xs sm:text-sm text-credit-600 font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $formatter($producto->monthly_payment) }}/mes
                                    </div>
                                </div>
                                <button class="mt-3 w-full px-3 py-2 sm:py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-lg hover:bg-slate-800 transition-colors">
                                    Lo quiero a crédito
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
        </section>

        <!-- Cómo funciona el crédito -->
        <section class="py-16 lg:py-20 bg-slate-900 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="inline-block px-3 py-1 rounded-full bg-credit-500/10 text-credit-400 text-sm font-medium mb-4">Cómo funciona</span>
                    <h2 class="font-display text-3xl sm:text-4xl text-white mb-4">Comprar a crédito es muy fácil</h2>
                    <p class="text-slate-400">En 3 pasos llevas lo que necesitas a casa.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 lg:gap-16">
                    <div class="text-center">
                        <div class="w-14 h-14 rounded-xl bg-credit-500/10 border border-credit-500/20 flex items-center justify-center mx-auto mb-5">
                            <span class="font-display text-2xl text-credit-400">1</span>
                        </div>
                        <h3 class="font-display text-lg text-white mb-2">Elige tus productos</h3>
                        <p class="text-sm text-slate-400">Navega nuestro catálogo y agrega al carrito lo que necesites.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-14 h-14 rounded-xl bg-credit-500/10 border border-credit-500/20 flex items-center justify-center mx-auto mb-5">
                            <span class="font-display text-2xl text-credit-400">2</span>
                        </div>
                        <h3 class="font-display text-lg text-white mb-2">Solicita tu crédito</h3>
                        <p class="text-sm text-slate-400">Llena tus datos y te aprobamos en minutos. Sin papeleo.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-14 h-14 rounded-xl bg-credit-500/10 border border-credit-500/20 flex items-center justify-center mx-auto mb-5">
                            <span class="font-display text-2xl text-credit-400">3</span>
                        </div>
                        <h3 class="font-display text-lg text-white mb-2">Recibe y paga en cuotas</h3>
                        <p class="text-sm text-slate-400">Recibes en casa y pagas en cuotas fijas. Sin sorpresas.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Beneficios exprés -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="font-semibold text-slate-900 text-sm">Aprobación rápida</div>
                        <div class="text-xs text-slate-500 mt-0.5">Respuesta en minutos</div>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="font-semibold text-slate-900 text-sm">Sin cuota inicial</div>
                        <div class="text-xs text-slate-500 mt-0.5">Primer pago al mes</div>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-credit-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-credit-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                        <div class="font-semibold text-slate-900 text-sm">Envío gratis</div>
                        <div class="text-xs text-slate-500 mt-0.5">A todo Colombia</div>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <div class="font-semibold text-slate-900 text-sm">Atención personalizada</div>
                        <div class="text-xs text-slate-500 mt-0.5">Te acompañamos</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <img src="{{ asset('logosinfondo.png') }}" alt="CreditosHerrera" class="h-10 w-auto">
                    </div>
                    <p class="text-sm leading-relaxed">Artículos para tu hogar con crédito fácil. Aprobación en minutos, envío a todo Colombia.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Categorías</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Electrodomésticos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Muebles</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cocina</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tecnología</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Hogar</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Crédito</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Solicitar crédito</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Simular cuotas</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Estado de cuenta</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pagar en línea</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Términos y condiciones</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Contacto</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-credit-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            (605) 123-4567
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-credit-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            info@creditosherrera.com
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-credit-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Cra 7 # 12-34, Centro
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
                <p>© {{ date('Y') }} CreditosHerrera. Todos los derechos reservados.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-white transition-colors">Política de privacidad</a>
                    <span class="text-slate-700">·</span>
                    <a href="#" class="hover:text-white transition-colors">Términos del servicio</a>
                </div>
            </div>
        </div>
    </footer>

    @vite(['resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>