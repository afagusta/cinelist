<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ url()->previous() }}" class="text-indigo-600 hover:underline">&larr; Kembali</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col md:flex-row">
                <div class="w-full md:w-1/3">
                    @if (isset($movie['poster_path']))
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="Poster" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>
                    @endif
                </div>

                <div class="w-full md:w-2/3 p-8 flex flex-col">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
                        {{ $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul' }}
                    </h1>
                    
                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-6">
                        <span class="flex items-center" title="Rating Global dari TMDB">
                            <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="font-bold text-gray-900">{{ number_format($movie['vote_average'] ?? 0, 1) }}</span>/10 (Global)
                        </span>
                        <span>•</span>
                        <span>{{ $movie['release_date'] ?? $movie['first_air_date'] ?? 'TBA' }}</span>
                        @if(isset($movie['runtime']))
                            <span>•</span>
                            <span>{{ $movie['runtime'] }} Menit</span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Genre</h3>
                        <div class="flex gap-2 flex-wrap">
                            @foreach($movie['genres'] ?? [] as $genre)
                                <span class="px-3 py-1 bg-gray-200 text-gray-800 text-xs rounded-full">{{ $genre['name'] }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sinopsis</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $movie['overview'] ?: 'Sinopsis tidak tersedia untuk bahasa ini.' }}
                        </p>
                    </div>

                    <div class="mt-auto">
                        <form action="{{ route('watchlists.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tmdb_movie_id" value="{{ $movie['id'] }}">
                            <input type="hidden" name="title" value="{{ $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul' }}">
                            <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] ?? '' }}">
                            <button type="submit" class="w-full md:w-auto px-8 bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition">
                                + Tambahkan ke Watchlist
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mt-8 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Beri Ulasan Lokal</h3>
                
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tmdb_movie_id" value="{{ $movie['id'] }}">
                    
                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating Bintang</label>
                        <select name="rating" id="rating" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full md:w-1/4" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                            <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                            <option value="3">⭐⭐⭐ (3 - Lumayan)</option>
                            <option value="2">⭐⭐ (2 - Buruk)</option>
                            <option value="1">⭐ (1 - Sangat Buruk)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar / Ulasan Anda</label>
                        <textarea name="comment" id="comment" rows="4" placeholder="Tulis pendapat ulasan Anda mengenai film/series ini di sini..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required></textarea>
                    </div>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded font-semibold text-sm transition">
                        Kirim Ulasan
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2 md:mb-0">Ulasan Pengguna CineList ({{ $reviews->count() ?? 0 }})</h3>
                    
                    @if($reviews->count() > 0)
                        <div class="flex items-center text-sm font-bold text-indigo-700 bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100 w-fit">
                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Rata-rata Lokal: {{ number_format($reviews->avg('rating'), 1) }} / 5.0
                        </div>
                    @endif
                </div>
                
                <div class="space-y-6">
                    @forelse($reviews ?? [] as $review)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <!-- Tampilan Header Komentar dengan Tombol Hapus (User + Admin) -->
                            <div class="flex justify-between items-start mb-1">
                                <div>
                                    <span class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</span>
                                    <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <!-- Tombol muncul jika user adalah penulis ulasan ATAU user adalah admin -->
                                @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold px-2 py-1 rounded bg-red-50 hover:bg-red-100 transition" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <div class="text-yellow-400 text-xs mb-2">
                                {{ str_repeat('⭐', $review->rating) }}
                            </div>
                            
                            <p class="text-gray-700 text-sm leading-relaxed">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 text-sm py-4">
                            Belum ada ulasan lokal untuk film ini. Jadilah yang pertama memberikan ulasan!
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>