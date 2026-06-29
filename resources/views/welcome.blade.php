<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CineList - Temukan & Simpan Film Favoritmu</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white antialiased">

    <nav class="absolute top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="text-white font-black text-2xl tracking-tighter">
                    CINE<span class="text-indigo-600">LIST</span>
                </a>
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition shadow-lg">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 text-gray-300 hover:text-white font-semibold transition">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition shadow-lg">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/40 via-gray-950 to-gray-950"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-[128px]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-600/10 rounded-full blur-[100px]"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600/10 border border-indigo-600/30 rounded-full text-indigo-400 text-sm font-semibold mb-8">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                Platform Database Film & Series
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-8xl font-black tracking-tight leading-none mb-6">
                Temukan & Simpan
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">
                    Film Favoritmu
                </span>
            </h1>

            <p class="text-gray-400 text-lg sm:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
                Jelajahi ribuan film dan series dari seluruh dunia. Simpan ke watchlist, 
                beri rating, dan bagikan ulasanmu bersama komunitas CineList.
            </p>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-lg rounded-2xl transition-all shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-1">
                        Mulai Jelajahi
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-lg rounded-2xl transition-all shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-1">
                        Mulai Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                @endauth
            @endif
        </div>
    </div>

    <div class="bg-gray-950 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight mb-4">
                    Kenapa CineList?
                </h2>
                <p class="text-gray-400 text-lg">Semua yang kamu butuhkan untuk mengelola tontonanmu</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 hover:border-indigo-600/50 transition">
                    <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center mb-6 border border-indigo-600/20">
                        <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Jelajahi Katalog</h3>
                    <p class="text-gray-400 leading-relaxed">Cari ribuan film dan series dari database TMDB. Filter berdasarkan genre atau kata kunci.</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 hover:border-indigo-600/50 transition">
                    <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center mb-6 border border-indigo-600/20">
                        <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Watchlist Pintar</h3>
                    <p class="text-gray-400 leading-relaxed">Simpan film dan series favoritmu ke dalam daftar tontonan pribadi. Akses kapan saja.</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 hover:border-indigo-600/50 transition">
                    <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center mb-6 border border-indigo-600/20">
                        <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Rating & Ulasan</h3>
                    <p class="text-gray-400 leading-relaxed">Beri rating bintang dan tulis ulasan untuk setiap film. Lihat pendapat pengguna lain.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-950 border-t border-gray-800 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 sm:p-12">
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight mb-4">
                    Siap Menemukan Tontonan Baru?
                </h2>
                <p class="text-gray-400 text-lg mb-8">Gabung gratis dan mulai jelajahi ribuan film & series sekarang.</p>
                @if (Route::has('register'))
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-lg rounded-2xl transition-all shadow-lg hover:-translate-y-1">
                            Daftar Gratis
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    @endguest
                @endif
            </div>
        </div>
    </div>

    <footer class="bg-gray-950 border-t border-gray-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} CineList. Dibangun dengan Laravel & TMDB API.</p>
        </div>
    </footer>

</body>
</html>
