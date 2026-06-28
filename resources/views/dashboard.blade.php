<x-app-layout>
    @if(count($topMovies) > 0)
    @php $heroMovie = $topMovies[0]; @endphp
    <div class="relative w-full h-[40vh] md:h-[60vh] bg-gray-950 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            <img src="https://image.tmdb.org/t/p/original{{ $heroMovie['backdrop_path'] }}" alt="{{ $heroMovie['title'] ?? $heroMovie['name'] }}" class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/60 to-transparent"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-16">
            <span class="px-4 py-1.5 bg-yellow-500 text-gray-900 font-extrabold rounded-full text-sm mb-6 inline-block shadow-lg">
                ★ {{ number_format($heroMovie['vote_average'], 1) }} GLOBAL TOP RATED
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-2xl">
                {{ $heroMovie['title'] ?? $heroMovie['name'] }}
            </h1>
            <p class="text-gray-300 text-lg md:text-xl mb-8 line-clamp-3 drop-shadow-lg px-4 md:px-12">
                {{ $heroMovie['overview'] }}
            </p>
            <a href="{{ route('movies.show', ['id' => $heroMovie['id'], 'type' => 'movie']) }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-full transition duration-300 shadow-lg transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                Lihat Detail
            </a>
        </div>
    </div>
    @endif

    <div class="py-12 bg-gray-950">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-white tracking-tight">Pilihan Terbaik Sepanjang Masa</h2>
                <p class="text-gray-400 mt-2 text-lg">Berdasarkan rating global penonton di seluruh dunia</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4 sm:px-0">
                @foreach(array_slice($topMovies, 1) as $movie)
                    <div class="bg-gray-900 rounded-2xl shadow-xl border border-gray-800 overflow-hidden hover:border-indigo-500 transition duration-300 transform hover:-translate-y-2 group relative">
                        
                        <div class="relative h-56 md:h-80 overflow-hidden">
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] ?? $movie['name'] }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                            
                            <div class="absolute top-0 right-0 bg-gray-950/80 text-yellow-400 font-bold px-3 py-1 m-3 rounded-lg flex items-center backdrop-blur-md z-10 border border-gray-700/50">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                {{ number_format($movie['vote_average'], 1) }}
                            </div>

                            <div class="absolute inset-0 bg-gray-950/70 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center gap-3 backdrop-blur-sm">
                                <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => 'movie']) }}" class="text-white font-bold bg-indigo-600 px-6 py-2.5 rounded-full shadow-lg hover:bg-indigo-500 transition w-40 text-center">
                                    Lihat Detail
                                </a>
                                <form action="{{ route('watchlists.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tmdb_movie_id" value="{{ $movie['id'] }}">
                                    <input type="hidden" name="title" value="{{ $movie['title'] ?? $movie['name'] }}">
                                    <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] ?? '' }}">
                                    <input type="hidden" name="type" value="movie">
                                    <button type="submit" class="text-white bg-gray-800 border border-gray-600 hover:bg-gray-700 font-bold px-6 py-2.5 rounded-full shadow-lg flex items-center w-40 justify-center transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                        Simpan
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-white text-lg truncate" title="{{ $movie['title'] ?? $movie['name'] }}">
                                {{ $movie['title'] ?? $movie['name'] }}
                            </h3>
                            <p class="text-gray-400 text-sm mt-1.5 font-medium">
                                Rilis: {{ \Carbon\Carbon::parse($movie['release_date'] ?? $movie['first_air_date'] ?? now())->format('Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>