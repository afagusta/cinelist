<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Film & Series') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />
            
            <form action="{{ route('movies.index') }}" method="GET" class="mb-6 flex gap-2">
                
                <input type="text" name="search" value="{{ $query ?? '' }}" placeholder="Cari film atau tv series..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full md:w-1/2">
                
                <select name="genre" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full md:w-1/4">
                    <option value="">Semua Genre</option>
                    @foreach($dropdownGenres as $genre)
                        <option value="{{ $genre['id'] }}" {{ (isset($genreId) && $genreId == $genre['id']) ? 'selected' : '' }}>
                            {{ $genre['name'] }}
                        </option>
                    @endforeach
                </select>

                <x-primary-button type="submit">
                    {{ __('Cari') }}
                </x-primary-button>
            </form>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($movies as $movie)
                    <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                        
                        <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => $movie['media_type'] ?? 'movie']) }}" class="block">
                            @if (isset($movie['poster_path']))
                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="Poster" class="w-full h-auto object-cover hover:opacity-75 transition">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500 hover:opacity-75 transition">No Image</div>
                            @endif
                        </a>
                        
                        <div class="p-4 flex-1 flex flex-col">
                            
                            @if(isset($movie['genre_ids']))
                                <div class="flex gap-1 flex-wrap mb-3">
                                    @foreach(array_slice($movie['genre_ids'], 0, 3) as $genreId)
                                        @if(isset($genreMap[$genreId]))
                                            <a href="{{ route('movies.index', ['genre' => $genreId]) }}" class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[11px] font-semibold rounded-full border border-indigo-100 hover:bg-indigo-200 hover:text-indigo-900 transition cursor-pointer">
                                                {{ $genreMap[$genreId] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            
                            <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => $movie['media_type'] ?? 'movie']) }}">
                                <h3 class="font-bold text-lg text-gray-900 leading-tight hover:text-indigo-600 transition">
                                    {{ $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul' }}
                                </h3>
                            </a>
                            
                            <div class="flex items-center mt-1 mb-2">
                                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-sm text-gray-700 font-medium">
                                    {{ isset($movie['vote_average']) && $movie['vote_average'] > 0 ? number_format($movie['vote_average'], 1) : 'Belum ada rating' }} / 10
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mt-2 line-clamp-3">
                                {{ $movie['overview'] ?? 'Sinopsis tidak tersedia.' }}
                            </p>
                            
                            <div class="mt-auto pt-4">
                                <form action="{{ route('watchlists.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tmdb_movie_id" value="{{ $movie['id'] }}">
                                    <input type="hidden" name="title" value="{{ $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul' }}">
                                    <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] ?? '' }}">
                                    <button type="submit" class="w-full bg-indigo-600 text-white text-sm font-semibold py-2 rounded hover:bg-indigo-700 transition">
                                        + Watchlist
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>