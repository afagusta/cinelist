<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tmdb_movie_id',
        'title',
        'poster_path',
        'type',
        'is_watched',
    ];

    protected function casts(): array
    {
        return [
            'is_watched' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
