<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $query = Auth::user()->watchlists()->latest();

        if ($type && in_array($type, ['movie', 'tv'])) {
            $query->where('type', $type);
        }

        $watchlists = $query->get();

        return view('watchlists.index', compact('watchlists', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tmdb_movie_id' => 'required|integer',
            'title' => 'required|string',
            'poster_path' => 'nullable|string',
            'type' => 'required|string',
        ]);

        Watchlist::firstOrCreate([
            'user_id' => Auth::id(),
            'tmdb_movie_id' => $request->tmdb_movie_id,
            'type' => $request->type,
        ], [
            'title' => $request->title,
            'poster_path' => $request->poster_path,
        ]);

        return back()->with('success', 'Film berhasil ditambahkan ke Watchlist!');
    }

    public function destroy(Watchlist $watchlist)
    {
        if ($watchlist->user_id === Auth::id()) {
            $watchlist->delete();
        }

        return back()->with('success', 'Film dihapus dari Watchlist!');
    }

    public function toggleWatched(Watchlist $watchlist)
    {
        abort_if($watchlist->user_id !== Auth::id(), 403);

        $watchlist->update([
            'is_watched' => ! $watchlist->is_watched,
        ]);

        $status = $watchlist->is_watched ? 'Ditandai sudah ditonton' : 'Ditandai belum ditonton';

        return back()->with('success', "{$watchlist->title} — {$status}!");
    }
}
