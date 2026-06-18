<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CreditosHerrera') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-serif-display:400,400i|inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['DM Serif Display', 'serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        credit: {
                            50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a',
                            300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b',
                            600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f',
                        }
                    },
                }
            }
        }
    </script>
    <style>
        .input-field {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .input-field:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            outline: none;
        }
    </style>
</head>
<body class="font-body antialiased text-slate-700 bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-8">
        <div class="w-full sm:max-w-md">
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <img src="{{ asset('logosinfondo2.png') }}" alt="CreditosHerrera" class="h-14 w-auto mx-auto">
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 sm:p-10">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>