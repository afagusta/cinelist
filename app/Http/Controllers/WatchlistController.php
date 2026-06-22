<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Auth::user()->watchlists()->latest()->get();
        return view('watchlists.index', compact('watchlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tmdb_movie_id' => 'required|integer',
            'title' => 'required|string',
            'poster_path' => 'nullable|string',
        ]);

        Watchlist::firstOrCreate([
            'user_id' => Auth::id(),
            'tmdb_movie_id' => $request->tmdb_movie_id,
        ], [
            'title' => $request->title,
            'poster_path' => $request->poster_path,
        ]);

        return back()->with('status', 'Film berhasil ditambahkan ke Watchlist!');
    }

    public function destroy(Watchlist $watchlist)
    {
        if ($watchlist->user_id === Auth::id()) {
            $watchlist->delete();
        }

        return back()->with('status', 'Film dihapus dari Watchlist!');
    }
}