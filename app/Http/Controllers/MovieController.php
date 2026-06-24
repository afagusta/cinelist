<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use App\Models\Review; // <-- Tambahan: Memanggil model Review

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $genreId = $request->input('genre'); 
        
        $movieGenres = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/genre/movie/list', ['language' => 'id-ID'])
            ->json()['genres'] ?? [];
            
        $tvGenres = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/genre/tv/list', ['language' => 'id-ID'])
            ->json()['genres'] ?? [];

        $genreMap = collect(array_merge($movieGenres, $tvGenres))->pluck('name', 'id')->toArray();
        
        $dropdownGenres = collect(array_merge($movieGenres, $tvGenres))->unique('id')->sortBy('name');
        
        if ($query) {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/search/multi', [
                    'query' => $query,
                    'language' => 'id-ID'
                ]);
        } elseif ($genreId) {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/discover/movie', [
                    'with_genres' => $genreId,
                    'language' => 'id-ID',
                    'sort_by' => 'popularity.desc'
                ]);
        } else {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/trending/all/day', [
                    'language' => 'id-ID'
                ]);
        }

        $movies = $response->json()['results'] ?? [];

        return view('movies.index', compact('movies', 'query', 'genreMap', 'dropdownGenres', 'genreId'));
    }

    // Fungsi show yang sudah di-upgrade agar pintar mendeteksi TV Series & Menarik Ulasan
    public function show($id, $type = 'movie')
    {
        // 1. Coba cari dengan tipe default (movie)
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/{$type}/{$id}", [
                'language' => 'id-ID',
                'append_to_response' => 'credits'
            ]);

        // 2. Kalau gagal dan tipenya tadi 'movie', otomatis cari sebagai 'tv'
        if ($response->failed() && $type === 'movie') {
            $type = 'tv'; 
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get("https://api.themoviedb.org/3/{$type}/{$id}", [
                    'language' => 'id-ID',
                    'append_to_response' => 'credits'
                ]);
        }

        // 3. Kalau dicari di movie dan tv dua-duanya tetap tidak ada, baru lempar error 404
        if ($response->failed()) {
            abort(404, 'Film atau TV Series tidak ditemukan di TMDB.');
        }

        $movie = $response->json();

        // --- TAMBAHAN: Tarik ulasan lokal dari database ---
        // Mengambil review beserta data user yang menulisnya, diurutkan dari yang terbaru
        $reviews = Review::with('user')
            ->where('tmdb_movie_id', $id)
            ->latest()
            ->get();
        // ---------------------------------------------------

        // Kirim variabel $reviews ke dalam view bersama $movie dan $type
        return view('movies.show', compact('movie', 'type', 'reviews'));
    }
}