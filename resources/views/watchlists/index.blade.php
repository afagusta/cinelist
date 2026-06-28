<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen">
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

            <div class="mb-8 px-4 sm:px-0">
                <p class="text-gray-400 text-lg">
                    Kamu memiliki <span class="font-bold text-indigo-400">{{ count($watchlists) }} film/series</span> yang tersimpan di daftar pantauan.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4 sm:px-0">
                @forelse($watchlists as $watchlist)
                    <div class="bg-gray-900 rounded-2xl shadow-xl border border-gray-800 overflow-hidden hover:shadow-2xl hover:border-indigo-500 transition-all duration-300 transform hover:-translate-y-2 group flex flex-col h-full relative">
                        
                        <div class="relative h-[280px] sm:h-[400px] overflow-hidden bg-gray-800">
                            @if(!empty($watchlist->poster_path))
                                <img src="https://image.tmdb.org/t/p/w500{{ $watchlist->poster_path }}" alt="{{ $watchlist->title }}" 
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-500 flex-col">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>No Image</span>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-950/40 to-transparent opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-3 backdrop-blur-sm">
                                
                                <a href="{{ route('movies.show', ['id' => $watchlist->tmdb_movie_id, 'type' => $watchlist->type ?? 'movie']) }}" class="text-white font-bold bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-lg flex items-center w-40 justify-center text-sm">
                                    Lihat Detail
                                </a>

                                <form action="{{ route('watchlists.destroy', $watchlist->id) }}" method="POST" class="transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 delay-75 w-40">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-900/80 border border-red-700 hover:bg-red-600 font-bold px-6 py-2.5 rounded-full shadow-lg flex items-center w-full justify-center text-sm transition" 
                                        onclick="return confirm('Hapus {{ addslashes($watchlist->title) }} dari daftar tontonan kamu?')">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </div>
                        
                        <div class="p-5 flex-grow bg-gray-900 flex flex-col justify-center border-t border-gray-800 relative z-10">
                            <a href="{{ route('movies.show', ['id' => $watchlist->tmdb_movie_id, 'type' => $watchlist->type ?? 'movie']) }}" class="hover:text-indigo-400 transition">
                                <h3 class="font-bold text-white text-lg line-clamp-2 text-center leading-snug" title="{{ $watchlist->title }}">
                                    {{ $watchlist->title }}
                                </h3>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-gray-900 rounded-3xl p-16 text-center shadow-xl border border-gray-800 max-w-2xl mx-auto mt-6">
                        <div class="w-24 h-24 bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-6 border border-indigo-800/50">
                            <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Watchlist Masih Kosong</h3>
                        <p class="text-gray-400 mb-8 text-lg">Kamu belum menyimpan film atau tv series apapun ke dalam daftar tontonan. Yuk cari film favoritmu sekarang!</p>
                        <a href="{{ route('movies.index') }}" class="inline-block px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition shadow-lg transform hover:-translate-y-1">
                            Mulai Eksplorasi Film
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>