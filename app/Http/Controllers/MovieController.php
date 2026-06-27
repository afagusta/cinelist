<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use App\Models\Review; 

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

    public function show($id, $type = 'movie')
    {
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/{$type}/{$id}", [
                'language' => 'id-ID',
                'append_to_response' => 'credits'
            ]);

        if ($response->failed() && $type === 'movie') {
            $type = 'tv'; 
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get("https://api.themoviedb.org/3/{$type}/{$id}", [
                    'language' => 'id-ID',
                    'append_to_response' => 'credits'
                ]);
        }

        if ($response->failed()) {
            abort(404, 'Film atau TV Series tidak ditemukan di TMDB.');
        }

        $movie = $response->json();

        $reviews = Review::with('user')
            ->where('tmdb_movie_id', $id)
            ->latest()
            ->get();
     
        return view('movies.show', compact('movie', 'type', 'reviews'));
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user && (
            $user->role === 'admin' || 
            $user->role === 'Admin' || 
            $user->role == 1 || 
            $user->is_admin == 1 ||
            (method_exists($user, 'hasRole') && $user->hasRole('admin'))
        )) {
            return redirect()->route('admin.dashboard');
        }

        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/movie/top_rated', [
                'language' => 'id-ID',
                'page' => 1
            ]);

        $topMovies = $response->json()['results'] ?? [];

        return view('dashboard', compact('topMovies'));
    }
}