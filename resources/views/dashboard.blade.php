<x-app-layout>
    @if(count($topMovies) > 0)
    @php $heroMovie = $topMovies[0]; @endphp
    <div class="relative w-full h-[60vh] bg-gray-900 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 w-full h-full">
            <img src="https://image.tmdb.org/t/p/original{{ $heroMovie['backdrop_path'] }}" alt="{{ $heroMovie['title'] ?? $heroMovie['name'] }}" class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-100 via-gray-900/40 to-transparent"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-16">
            <span class="px-4 py-1.5 bg-yellow-500 text-gray-900 font-extrabold rounded-full text-sm mb-6 inline-block shadow-lg">
                ★ {{ number_format($heroMovie['vote_average'], 1) }} GLOBAL TOP RATED
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-2xl">
                {{ $heroMovie['title'] ?? $heroMovie['name'] }}
            </h1>
            <p class="text-gray-200 text-lg md:text-xl mb-8 line-clamp-3 drop-shadow-lg px-4 md:px-12">
                {{ $heroMovie['overview'] }}
            </p>
            <a href="{{ route('movies.show', ['id' => $heroMovie['id'], 'type' => 'movie']) }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-full transition duration-300 shadow-lg transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                Lihat Detail
            </a>
        </div>
    </div>
    @endif

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 px-4 sm:px-0">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pilihan Terbaik Sepanjang Masa</h2>
                    <p class="text-gray-500 mt-2 text-lg">Berdasarkan rating global penonton di seluruh dunia</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4 sm:px-0">
                @foreach(array_slice($topMovies, 1) as $movie)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 group cursor-pointer">
                        <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => 'movie']) }}">
                            <div class="relative h-80 overflow-hidden">
                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] ?? $movie['name'] }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                
                                <div class="absolute top-0 right-0 bg-gray-900/80 text-yellow-400 font-bold px-3 py-1 m-3 rounded-lg flex items-center backdrop-blur-md">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ number_format($movie['vote_average'], 1) }}
                                </div>
                                
                                <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-gray-900/50 transition duration-300 flex items-center justify-center">
                                    <span class="text-white font-bold opacity-0 group-hover:opacity-100 bg-indigo-600 px-5 py-2.5 rounded-full transform translate-y-4 group-hover:translate-y-0 transition duration-300 shadow-lg">
                                        Lihat Detail
                                    </span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 text-lg truncate" title="{{ $movie['title'] ?? $movie['name'] }}">
                                    {{ $movie['title'] ?? $movie['name'] }}
                                </h3>
                                <p class="text-gray-500 text-sm mt-1.5 font-medium">
                                    Rilis: {{ \Carbon\Carbon::parse($movie['release_date'] ?? $movie['first_air_date'] ?? now())->format('Y') }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>