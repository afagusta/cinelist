<x-app-layout>
    <div class="relative w-full bg-gray-900 min-h-[70vh] flex items-center pb-12 pt-8 md:pt-16">
        <div class="absolute inset-0 overflow-hidden">
            @if(isset($movie['backdrop_path']))
                <img src="https://image.tmdb.org/t/p/original{{ $movie['backdrop_path'] }}" alt="Backdrop" class="w-full h-full object-cover opacity-30 transform scale-105">
            @elseif(isset($movie['poster_path']))
                <img src="https://image.tmdb.org/t/p/original{{ $movie['poster_path'] }}" alt="Backdrop Fallback" class="w-full h-full object-cover opacity-20 blur-sm transform scale-105">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/50 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            <a href="{{ route('movies.index') }}" class="inline-flex items-center text-gray-300 hover:text-white mb-6 md:mb-10 transition duration-300 group bg-gray-800/50 hover:bg-gray-700/50 px-4 py-2 rounded-full backdrop-blur-sm w-fit border border-gray-600/50">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Katalog
            </a>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <div class="flex flex-col md:flex-row gap-8 lg:gap-12 items-start">
                
                <div class="w-48 sm:w-64 md:w-1/3 lg:w-1/4 flex-shrink-0 mx-auto md:mx-0 relative group">
                    @if (isset($movie['poster_path']))
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="Poster" class="w-full rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-gray-700/50 transition duration-500 group-hover:scale-[1.02]">
                    @else
                        <div class="w-full aspect-[2/3] bg-gray-800 rounded-2xl flex flex-col items-center justify-center text-gray-500 border border-gray-700 shadow-2xl">
                            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>No Image</span>
                        </div>
                    @endif
                </div>

                <div class="w-full md:w-2/3 lg:w-3/4 flex flex-col justify-center text-white">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-3 drop-shadow-lg tracking-tight">
                        {{ $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul' }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm sm:text-base text-gray-300 mb-6 font-medium">
                        <span class="flex items-center bg-yellow-500/10 text-yellow-400 px-3 py-1 rounded-lg border border-yellow-500/20 backdrop-blur-sm" title="Rating Global dari TMDB">
                            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="font-bold text-white mr-1">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span> / 10
                        </span>
                        <span>•</span>
                        <span>{{ \Carbon\Carbon::parse($movie['release_date'] ?? $movie['first_air_date'] ?? now())->format('d M Y') }}</span>
                        @if(isset($movie['runtime']))
                            <span>•</span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $movie['runtime'] }} Menit
                            </span>
                        @endif
                    </div>

                    <div class="mb-6 flex flex-wrap gap-2">
                        @foreach($movie['genres'] ?? [] as $genre)
                            <span class="px-4 py-1.5 bg-white/10 text-white text-xs sm:text-sm font-semibold rounded-full border border-white/20 backdrop-blur-md hover:bg-white/20 transition">
                                {{ $genre['name'] }}
                            </span>
                        @endforeach
                    </div>

                    <div class="mb-8 max-w-3xl">
                        <h3 class="text-xl font-bold text-white mb-3 flex items-center">
                            Sinopsis
                        </h3>
                        <p class="text-gray-300 leading-relaxed text-sm sm:text-base opacity-90 text-justify">
                            {{ $movie['overview'] ?: 'Sinopsis tidak tersedia untuk film/series ini.' }}
                        </p>
                    </div>

                    <div class="mt-auto">
                        <form action="{{ route('watchlists.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tmdb_movie_id" value="{{ $movie['id'] }}">
                            <input type="hidden" name="title" value="{{ $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul' }}">
                            <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] ?? '' }}">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition duration-300 shadow-lg shadow-indigo-600/30 flex items-center justify-center group transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Simpan ke Watchlist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                        <h3 class="text-xl font-extrabold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Tulis Ulasan
                        </h3>
                        
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tmdb_movie_id" value="{{ $movie['id'] }}">
                            
                            <div class="mb-5">
                                <label for="rating" class="block text-sm font-bold text-gray-700 mb-2">Rating Bintang</label>
                                <select name="rating" id="rating" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-gray-700 py-3" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                                    <option value="3">⭐⭐⭐ (3 - Lumayan)</option>
                                    <option value="2">⭐⭐ (2 - Buruk)</option>
                                    <option value="1">⭐ (1 - Sangat Buruk)</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="comment" class="block text-sm font-bold text-gray-700 mb-2">Komentar / Ulasan Anda</label>
                                <textarea name="comment" id="comment" rows="5" placeholder="Bagaimana pendapatmu tentang film ini?" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-gray-700 resize-none py-3" required></textarea>
                            </div>

                            <button type="submit" class="w-full bg-indigo-900 hover:bg-indigo-800 text-white font-bold px-6 py-3.5 rounded-xl transition shadow-md flex items-center justify-center">
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 pb-4 border-b border-gray-100">
                            <h3 class="text-xl font-extrabold text-gray-900 mb-3 sm:mb-0">
                                Ulasan Pengguna CineList ({{ $reviews->count() ?? 0 }})
                            </h3>
                            
                            @if($reviews->count() > 0)
                                <div class="flex items-center text-sm font-bold text-indigo-700 bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100 w-fit">
                                    <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Rata-rata: {{ number_format($reviews->avg('rating'), 1) }} / 5.0
                                </div>
                            @endif
                        </div>
                        
                        <div class="space-y-6">
                            @forelse($reviews ?? [] as $review)
                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 transition duration-300 hover:shadow-md hover:bg-white group">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center mr-3 uppercase">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</h4>
                                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        
                                        @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-white text-xs font-bold px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-500 transition border border-red-100 hover:border-red-500 flex items-center" onclick="return confirm('Yakin ingin menghapus ulasan ini secara permanen?')">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    
                                    <div class="text-yellow-400 text-xs mb-3 pl-13">
                                        {{ str_repeat('⭐', $review->rating) }}
                                    </div>
                                    
                                    <p class="text-gray-700 text-sm leading-relaxed bg-white p-4 rounded-xl border border-gray-100">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            @empty
                                <div class="text-center py-12 px-4">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Ulasan</h4>
                                    <p class="text-gray-500 text-sm max-w-md mx-auto">
                                        Jadilah yang pertama memberikan ulasan untuk film ini! Bagikan pendapatmu kepada pengguna CineList lainnya.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>