<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->name }} — CreditosHerrera</title>
    <meta name="theme-color" content="#0f172a">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                            50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a',
                            300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b',
                            600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .product-img { aspect-ratio: 4/3; object-fit: contain; background: #f8fafc; padding: 1rem; }
    </style>
</head>
<body class="font-body antialiased bg-slate-50 text-slate-700">

    <header class="sticky top-0 z-50 bg-slate-900 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-white shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span class="text-sm font-medium">Volver</span>
                </a>
                <img src="{{ asset('logosinfondo.png') }}" alt="CreditosHerrera" class="h-10 w-auto">
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            {{-- Galería --}}
            <div x-data="{ i: 0, imgs: @js($producto->images->map(fn($img) => Storage::disk('s3')->url($img->path))->values()) }">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <template x-if="imgs.length">
                        <img :src="imgs[i]" alt="{{ $producto->name }}" class="w-full aspect-square object-contain bg-slate-50 p-4">
                    </template>
                    <template x-if="!imgs.length">
                        <div class="w-full aspect-square bg-slate-100 flex items-center justify-center text-slate-400">Sin imagen</div>
                    </template>
                </div>
                <template x-if="imgs.length > 1">
                    <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                        <template x-for="(url, idx) in imgs" :key="idx">
                            <button @click="i = idx"
                                    :class="i === idx ? 'ring-2 ring-amber-400' : 'ring-1 ring-slate-200 opacity-60 hover:opacity-100'"
                                    class="w-16 h-16 rounded-lg overflow-hidden shrink-0 transition-all">
                                <img :src="url" alt="" class="w-full h-full object-contain bg-slate-50 p-1">
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Info --}}
            <div class="flex flex-col">
                <span class="text-xs text-slate-400 uppercase tracking-wide font-medium">{{ $producto->category->name }}</span>
                <h1 class="font-display text-2xl sm:text-3xl text-slate-900 mt-1 mb-4">{{ $producto->name }}</h1>

                @if($producto->description)
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">{{ $producto->description }}</p>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                    <div>
                        <span class="text-xs text-slate-400 font-medium">Precio de contado</span>
                        <div class="font-display text-3xl text-slate-900">$ {{ number_format($producto->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex items-center gap-2 text-credit-600 font-medium">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-lg">$ {{ number_format($producto->monthly_payment, 0, ',', '.') }}/mes</span>
                    </div>

                    @if($producto->stock > 0)
                        <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Disponible
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 text-xs text-red-500 font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Agotado
                        </div>
                    @endif
                </div>

                <a href="https://wa.me/573127382163?text={{ urlencode('¡Hola! Me interesa el producto ' . $producto->name . ' (' . $producto->category->name . ') — $' . number_format($producto->price, 0, ',', '.') . ' contado / $' . number_format($producto->monthly_payment, 0, ',', '.') . ' mes. ¿Me das más información?') }}"
                   target="_blank"
                   class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-500 active:bg-emerald-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Lo quiero a crédito
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-400 py-10 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} CreditosHerrera. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>