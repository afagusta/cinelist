<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tmdb_movie_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tmdb_movie_id' => $request->tmdb_movie_id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ],
        );

        $message = $review->wasRecentlyCreated
            ? 'Ulasan berhasil ditambahkan!'
            : 'Ulasan berhasil diperbarui!';

        return back()->with('status', $message);
    }

    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id && ! Auth::user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus ulasan ini.');
        }

        $review->delete();

        return back()->with('status', 'Ulasan berhasil dihapus!');
    }
}
