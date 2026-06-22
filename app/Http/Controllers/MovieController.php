<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/search/multi', [
                    'query' => $query,
                    'language' => 'id-ID'
                ]);
        } else {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/trending/all/day', [
                    'language' => 'id-ID'
                ]);
        }

        $movies = $response->json()['results'] ?? [];

        return view('movies.index', compact('movies', 'query'));
    }

    // Fungsi baru untuk Halaman Detail
    public function show($id, $type = 'movie')
    {
        // Menembak endpoint detail TMDB, dan menarik data aktor (credits) sekaligus
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/{$type}/{$id}", [
                'language' => 'id-ID',
                'append_to_response' => 'credits'
            ]);

        if ($response->failed()) {
            abort(404, 'Film tidak ditemukan.');
        }

        $movie = $response->json();

        return view('movies.show', compact('movie', 'type'));
    }
}