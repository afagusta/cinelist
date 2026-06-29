<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $genreId = $request->input('genre');
        $page = $request->input('page', 1);

        $movieGenres = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/genre/movie/list', ['language' => 'id-ID'])
            ->json()['genres'] ?? [];

        $tvGenres = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/genre/tv/list', ['language' => 'id-ID'])
            ->json()['genres'] ?? [];

        $genreMap = collect(array_merge($movieGenres, $tvGenres))->pluck('name', 'id')->toArray();

        $dropdownGenres = collect(array_merge($movieGenres, $tvGenres))->unique('id')->sortBy('name');

        $params = ['language' => 'id-ID', 'page' => $page];

        if ($query) {
            $params['query'] = $query;
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/search/multi', $params);
        } elseif ($genreId) {
            $params['with_genres'] = $genreId;
            $params['sort_by'] = 'popularity.desc';
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/discover/movie', $params);
        } else {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/trending/all/day', $params);
        }

        $data = $response->json();
        $movies = $data['results'] ?? [];
        $total = $data['total_results'] ?? 0;
        $currentPage = $data['page'] ?? 1;
        $perPage = count($movies) ?: 20;

        $movieIds = collect($movies)->pluck('id');

        $localRatings = Review::whereIn('tmdb_movie_id', $movieIds)
            ->selectRaw('tmdb_movie_id, ROUND(AVG(rating), 1) as avg_rating, COUNT(*) as total_reviews')
            ->groupBy('tmdb_movie_id')
            ->get()
            ->keyBy('tmdb_movie_id');

        $movies = new LengthAwarePaginator(
            $movies,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('movies.index', compact('movies', 'query', 'genreMap', 'dropdownGenres', 'genreId', 'localRatings'));
    }

    public function show($id, $type = 'movie')
    {
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/{$type}/{$id}", [
                'language' => 'id-ID',
                'append_to_response' => 'credits',
            ]);

        if ($response->failed() && $type === 'movie') {
            $type = 'tv';
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get("https://api.themoviedb.org/3/{$type}/{$id}", [
                    'language' => 'id-ID',
                    'append_to_response' => 'credits',
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

        if ($user && $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/movie/top_rated', [
                'language' => 'id-ID',
                'page' => 1,
            ]);

        $topMovies = $response->json()['results'] ?? [];

        $movieIds = collect($topMovies)->pluck('id');
        $localRatings = Review::whereIn('tmdb_movie_id', $movieIds)
            ->selectRaw('tmdb_movie_id, ROUND(AVG(rating), 1) as avg_rating, COUNT(*) as total_reviews')
            ->groupBy('tmdb_movie_id')
            ->get()
            ->keyBy('tmdb_movie_id');

        return view('dashboard', compact('topMovies', 'localRatings'));
    }
}
