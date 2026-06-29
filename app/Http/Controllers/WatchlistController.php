<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');

        $query = Auth::user()->watchlists()->latest();

        if ($type && in_array($type, ['movie', 'tv'])) {
            $query->where('type', $type);
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $watchlists = $query->get();

        $movieIds = $watchlists->pluck('tmdb_movie_id');
        $localRatings = Review::whereIn('tmdb_movie_id', $movieIds)
            ->selectRaw('tmdb_movie_id, ROUND(AVG(rating), 1) as avg_rating, COUNT(*) as total_reviews')
            ->groupBy('tmdb_movie_id')
            ->get()
            ->keyBy('tmdb_movie_id');

        return view('watchlists.index', compact('watchlists', 'type', 'search', 'localRatings'));
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
