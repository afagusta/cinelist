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
                <x-primary-button type="submit">
                    {{ __('Cari') }}
                </x-primary-button>
            </form>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($movies as $movie)
                    <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                        @if (isset($movie['poster_path']))
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="Poster" class="w-full h-auto object-cover">
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>
                        @endif
                        
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-lg text-gray-900 leading-tight">
                                {{ $movie['title'] ?? $movie['name'] ?? 'Tanpa Judul' }}
                            </h3>
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