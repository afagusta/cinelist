<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Tontonan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse ($watchlists as $watchlist)
                    <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                        
                        <a href="{{ route('movies.show', ['id' => $watchlist->tmdb_movie_id]) }}" class="block">
                            @if ($watchlist->poster_path)
                                <img src="https://image.tmdb.org/t/p/w500{{ $watchlist->poster_path }}" alt="Poster" class="w-full h-auto object-cover hover:opacity-75 transition cursor-pointer">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500 hover:opacity-75 transition cursor-pointer">No Image</div>
                            @endif
                        </a>
                        
                        <div class="p-4 flex-1 flex flex-col">
                            
                            <a href="{{ route('movies.show', ['id' => $watchlist->tmdb_movie_id]) }}">
                                <h3 class="font-bold text-lg text-gray-900 leading-tight hover:text-indigo-600 transition mb-4 cursor-pointer">
                                    {{ $watchlist->title }}
                                </h3>
                            </a>
                            
                            <div class="mt-auto pt-4 flex gap-2">
                                <form action="{{ route('watchlists.destroy', $watchlist->id) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 text-white text-sm font-semibold py-2 rounded hover:bg-red-600 transition" onclick="return confirm('Hapus dari watchlist?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-4 bg-white shadow rounded text-center text-gray-500">
                        Watchlist kamu masih kosong. Yuk cari film dulu!
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>