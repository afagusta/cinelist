<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen" x-data="{ loading: false }"
         x-on:click="
            let el = $event.target.closest('a');
            if (el && el.href) {
                $event.preventDefault();
                loading = true;
                $nextTick(() => window.location = el.href);
            }
         ">
        <x-loading-overlay />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 px-4 sm:px-0">
                <h2 class="font-bold text-3xl text-white leading-tight">
                    {{ __('Daftar Tontonan Saya') }}
                </h2>
            </div>
            
            @if(session('success'))
                <div class="mb-8 px-4 py-3 bg-green-900/40 border border-green-800 text-green-400 rounded-xl font-medium flex items-center shadow-sm mx-4 sm:mx-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 px-4 sm:px-0 flex flex-wrap items-center justify-between gap-4">
                <p class="text-gray-400 text-lg">
                    Kamu memiliki <span class="font-bold text-indigo-400">{{ count($watchlists) }} film/series</span> yang tersimpan di daftar pantauan.
                </p>
            </div>

            <div class="mb-8 px-4 sm:px-0">
                <form action="{{ route('watchlists.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <div class="relative flex-1 min-w-[200px]">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul di watchlist kamu..." 
                            class="w-full pl-12 pr-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                    @if($type)
                        <input type="hidden" name="type" value="{{ $type }}">
                    @endif
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition">Cari</button>
                    @if($search)
                        <a href="{{ route('watchlists.index', array_filter(['type' => $type])) }}" class="px-6 py-3 bg-gray-800 text-gray-400 font-bold rounded-xl hover:text-white hover:bg-gray-700 transition border border-gray-700">Reset</a>
                    @endif
                </form>
            </div>

            <div class="mb-8 px-4 sm:px-0 flex flex-wrap gap-2">
                <a href="{{ route('watchlists.index', array_filter(['search' => $search])) }}" class="px-5 py-2 rounded-xl font-bold text-sm transition border {{ !$type && !$search ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-gray-900 text-gray-400 border-gray-700 hover:text-white hover:border-gray-500' }}">
                    Semua
                </a>
                <a href="{{ route('watchlists.index', array_filter(['type' => 'movie', 'search' => $search])) }}" class="px-5 py-2 rounded-xl font-bold text-sm transition border {{ $type === 'movie' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-gray-900 text-gray-400 border-gray-700 hover:text-white hover:border-gray-500' }}">
                    Movie
                </a>
                <a href="{{ route('watchlists.index', array_filter(['type' => 'tv', 'search' => $search])) }}" class="px-5 py-2 rounded-xl font-bold text-sm transition border {{ $type === 'tv' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-gray-900 text-gray-400 border-gray-700 hover:text-white hover:border-gray-500' }}">
                    Series
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4 sm:px-0">
                @forelse($watchlists as $watchlist)
                    <div class="bg-gray-900 rounded-2xl shadow-xl border border-gray-800 overflow-hidden hover:shadow-2xl hover:border-indigo-500 transition-all duration-300 transform hover:-translate-y-2 group flex flex-col h-full relative">

                        <div class="relative h-[280px] sm:h-[400px] overflow-hidden bg-gray-800">

                            <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5">
                                <span class="px-3 py-1 text-xs font-extrabold uppercase rounded-lg border {{ $watchlist->type === 'tv' ? 'bg-pink-900/30 text-pink-400 border-pink-800/30' : 'bg-blue-900/30 text-blue-400 border-blue-800/30' }}">
                                    {{ $watchlist->type === 'tv' ? 'SERIES' : 'MOVIE' }}
                                </span>
                                @if($watchlist->is_watched)
                                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-green-900/40 text-green-400 border border-green-800/40">
                                        ✓ Sudah Ditonton
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold rounded-lg bg-yellow-900/30 text-yellow-400 border border-yellow-800/30">
                                        ● Belum Ditonton
                                    </span>
                                @endif
                            </div>

                            @php
                                $wlocal = $localRatings[$watchlist->tmdb_movie_id] ?? null;
                            @endphp
                            @if($wlocal && $wlocal['total_reviews'] > 0)
                                <span class="absolute top-3 right-3 z-10 bg-green-900/50 text-green-400 font-bold px-2 py-1 rounded-lg flex items-center text-xs backdrop-blur-md border border-green-800/50" title="Rating dari Pengguna CineList">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ $wlocal['avg_rating'] }}
                                </span>
                            @endif
                            <a href="{{ route('movies.show', ['id' => $watchlist->tmdb_movie_id, 'type' => $watchlist->type ?? 'movie']) }}">
                                @if(!empty($watchlist->poster_path))
                                    <img src="https://image.tmdb.org/t/p/w500{{ $watchlist->poster_path }}" alt="{{ $watchlist->title }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500 flex-col">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </a>
                        </div>

                        <div class="p-5 flex flex-col flex-grow bg-gray-900 border-t border-gray-800 relative z-10">
                            <a href="{{ route('movies.show', ['id' => $watchlist->tmdb_movie_id, 'type' => $watchlist->type ?? 'movie']) }}" class="hover:text-indigo-400 transition">
                                <h3 class="font-bold text-white text-lg line-clamp-2 text-center leading-snug" title="{{ $watchlist->title }}">
                                    {{ $watchlist->title }}
                                </h3>
                            </a>

                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <form action="{{ route('watchlists.toggle-watched', $watchlist->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full flex items-center justify-center gap-1 py-2.5 px-1 rounded-lg font-bold transition-colors shadow-lg {{ $watchlist->is_watched ? 'bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-emerald-500/20' : 'bg-rose-500 hover:bg-rose-400 text-white shadow-rose-500/20' }}">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-[11px] sm:text-xs whitespace-nowrap">{{ $watchlist->is_watched ? 'Tandai Belum' : 'Tandai Ditonton' }}</span>
                                    </button>
                                </form>
                                <form action="{{ route('watchlists.destroy', $watchlist->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full flex items-center justify-center gap-1 py-2.5 px-1 rounded-lg bg-rose-500 hover:bg-rose-400 text-white font-bold transition-colors shadow-lg shadow-rose-500/20"
                                        onclick="return confirm('Hapus {{ addslashes($watchlist->title) }} dari daftar tontonan kamu?')">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <span class="text-[11px] sm:text-xs whitespace-nowrap">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-gray-900 rounded-3xl p-16 text-center shadow-xl border border-gray-800 max-w-2xl mx-auto mt-6">
                        <div class="w-24 h-24 bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-6 border border-indigo-800/50">
                            <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">
                            @if($search)
                                Hasil Tidak Ditemukan
                            @elseif($type === 'movie')
                                Belum Ada Movie di Watchlist
                            @elseif($type === 'tv')
                                Belum Ada Series di Watchlist
                            @else
                                Watchlist Masih Kosong
                            @endif
                        </h3>
                        <p class="text-gray-400 mb-8 text-lg">
                            @if($search)
                                Tidak ada judul "<strong class="text-white">{{ $search }}</strong>" di watchlist kamu.
                            @elseif($type)
                                Kamu belum menyimpan {{ $type === 'tv' ? 'tv series' : 'film' }} apapun ke dalam daftar tontonan.
                            @else
                                Kamu belum menyimpan film atau tv series apapun ke dalam daftar tontonan. Yuk cari film favoritmu sekarang!
                            @endif
                        </p>
                        @if(!$search)
                            <a href="{{ route('movies.index') }}" class="inline-block px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition shadow-lg transform hover:-translate-y-1">
                                Mulai Eksplorasi Film
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>