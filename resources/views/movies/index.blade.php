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
            
            <div class="mb-8 px-4 sm:px-0">
                <h2 class="font-bold text-3xl text-white leading-tight">
                    {{ __('Katalog Film & Series') }}
                </h2>
                <p class="text-gray-400 mt-2 text-lg">Temukan tontonan favoritmu dari berbagai genre.</p>
            </div>
            
            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-900/50 border border-green-800 text-green-400 rounded-xl font-medium flex items-center shadow-sm mx-4 sm:mx-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-900 p-6 rounded-2xl shadow-xl border border-gray-800 mb-10 mx-4 sm:mx-0">
                <form action="{{ route('movies.index') }}" method="GET" x-on:submit.prevent="loading = true; $nextTick(() => $el.submit())" class="flex flex-col md:flex-row gap-4" id="catalog-form">
                    
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $query }}" placeholder="Cari film atau tv series..." 
                            class="w-full pl-11 pr-4 py-3 bg-gray-950 rounded-xl border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm text-white placeholder-gray-500">
                    </div>

                    <div class="w-full md:w-64">
                        <select name="genre" class="w-full py-3 bg-gray-950 rounded-xl border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm text-gray-300 cursor-pointer">
                            <option value="">Semua Genre</option>
                            @foreach($dropdownGenres as $g)
                                <option value="{{ $g['id'] }}" {{ $genreId == $g['id'] ? 'selected' : '' }}>
                                    {{ $g['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3 rounded-xl transition duration-300 shadow-md flex items-center justify-center">
                        Tampilkan
                    </button>
                    
                    @if($query || $genreId)
                        <a href="{{ route('movies.index') }}" class="bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 font-bold px-6 py-3 rounded-xl transition duration-300 text-center flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4 sm:px-0">
                @forelse($movies as $movie)
                    @php
                        $type = isset($movie['title']) ? 'movie' : 'tv';
                        $title = $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul';
                        $date = $movie['release_date'] ?? $movie['first_air_date'] ?? null;
                        $year = $date ? \Carbon\Carbon::parse($date)->format('Y') : '-';
                    @endphp

                    <div class="bg-gray-900 rounded-2xl shadow-xl border border-gray-800 overflow-hidden hover:shadow-2xl hover:border-indigo-500 transition-all duration-300 transform hover:-translate-y-2 group flex flex-col h-full relative">

                        <div class="relative h-[280px] sm:h-[400px] overflow-hidden bg-gray-800">
                            <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => $type]) }}">
                                @if(!empty($movie['poster_path']))
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $title }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500 flex-col">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </a>

                            <div class="absolute top-3 right-3 flex flex-col gap-1.5 items-end">
                                @php
                                    $local = $localRatings[$movie['id']] ?? null;
                                @endphp
                                @if($local && $local['total_reviews'] > 0)
                                    <span class="bg-green-900/50 text-green-400 font-bold px-2 py-1 rounded-lg flex items-center text-xs backdrop-blur-md shadow-sm border border-green-800/50" title="Rating dari Pengguna CineList">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        {{ $local['avg_rating'] }}
                                    </span>
                                @endif
                                <span class="bg-gray-950/80 text-yellow-400 font-bold px-2 py-1 rounded-lg flex items-center text-xs md:text-sm backdrop-blur-md shadow-sm border border-gray-700/50">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ number_format($movie['vote_average'] ?? 0, 1) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow bg-gray-900 relative z-10">
                            <div class="flex justify-between items-start gap-2 mb-2">
                                <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => $type]) }}" class="flex-1 hover:text-indigo-400 transition">
                                    <h3 class="font-bold text-white text-lg line-clamp-1" title="{{ $title }}">
                                        {{ $title }}
                                    </h3>
                                </a>
                                <form action="{{ route('watchlists.store') }}" method="POST" class="shrink-0">
                                    @csrf
                                    <input type="hidden" name="tmdb_movie_id" value="{{ $movie['id'] }}">
                                    <input type="hidden" name="title" value="{{ $title }}">
                                    <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] ?? '' }}">
                                    <input type="hidden" name="type" value="{{ $type }}">
                                    <button type="submit" class="text-slate-400 hover:text-violet-400 transition-colors p-1 rounded-md hover:bg-violet-500/10">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                    </button>
                                </form>
                            </div>

                            <div class="flex flex-wrap gap-1.5 mb-3">
                                @if(isset($movie['genre_ids']))
                                    @foreach(array_slice($movie['genre_ids'], 0, 3) as $gId)
                                        @if(isset($genreMap[$gId]))
                                            <span class="px-2 py-1 bg-indigo-900/40 text-indigo-300 text-[10px] sm:text-xs font-semibold rounded-md border border-indigo-800/50">
                                                {{ $genreMap[$gId] }}
                                            </span>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            <div class="mt-auto pt-3 border-t border-gray-800 flex justify-between items-center text-sm text-gray-400 font-medium">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $year }}
                                </div>
                                <span class="uppercase text-[10px] font-extrabold tracking-wider {{ $type === 'tv' ? 'text-pink-400 bg-pink-900/30 border border-pink-800/30 px-2 py-1 rounded' : 'text-blue-400 bg-blue-900/30 border border-blue-800/30 px-2 py-1 rounded' }}">
                                    {{ $type === 'tv' ? 'SERIES' : 'MOVIE' }}
                                </span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-gray-900 rounded-2xl p-6 sm:p-12 text-center shadow-xl border border-gray-800">
                        <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-bold text-white mb-2">Pencarian Tidak Ditemukan</h3>
                        <p class="text-gray-400">Coba gunakan kata kunci lain atau hapus filter genre yang Anda pilih.</p>
                        <a href="{{ route('movies.index') }}" class="inline-block mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-500 transition shadow-lg">Kembali ke Katalog</a>
                    </div>
                @endforelse
            </div>
            
            @if(isset($movies) && is_object($movies) && method_exists($movies, 'links'))
                <div class="mt-10 px-4 sm:px-0">
                    {{ $movies->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>