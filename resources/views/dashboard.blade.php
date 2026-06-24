<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Top Rated Movies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-900">Pilihan Film Terbaik Sepanjang Masa</h3>
                <p class="text-sm text-gray-500">Berdasarkan rating global TMDB</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($topMovies as $movie)
                    <div class="bg-white rounded-lg shadow overflow-hidden group hover:shadow-xl transition duration-300">
                        <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => 'movie']) }}" class="block relative">
                            @if(isset($movie['poster_path']))
                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>
                            @endif
                            
                            <div class="absolute top-2 right-2 bg-black bg-opacity-80 text-yellow-400 font-bold px-2 py-1 rounded text-xs flex items-center shadow-lg">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                {{ number_format($movie['vote_average'], 1) }}
                            </div>
                        </a>
                        
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 text-sm truncate" title="{{ $movie['title'] }}">{{ $movie['title'] }}</h4>
                            <p class="text-xs text-gray-500 mt-1">
                                Rilis: {{ isset($movie['release_date']) ? \Carbon\Carbon::parse($movie['release_date'])->format('Y') : 'TBA' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>