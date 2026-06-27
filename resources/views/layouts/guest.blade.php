<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CineList') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-300 antialiased bg-gray-950 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 relative overflow-hidden">
            
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-indigo-600/20 blur-[120px] rounded-full pointer-events-none z-0"></div>

            <div class="relative z-10 mb-8 mt-6 sm:mt-0">
                <a href="/" class="text-white font-black text-4xl tracking-tighter drop-shadow-lg transition hover:scale-105 inline-block">
                    CINE<span class="text-indigo-600">LIST</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-gray-900 shadow-2xl border border-gray-800 overflow-hidden sm:rounded-3xl relative z-10">
                {{ $slot }}
            </div>
            
        </div>
    </body>
</html>