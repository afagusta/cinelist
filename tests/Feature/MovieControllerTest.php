<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'user']);
    Role::firstOrCreate(['name' => 'admin']);
});

test('dashboard redirects admin users to admin panel', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertRedirect(route('admin.dashboard'));
});

test('dashboard shows top rated movies for regular users', function () {
    Http::fake([
        'api.themoviedb.org/3/movie/top_rated*' => Http::response([
            'results' => [
                ['id' => 1, 'title' => 'Movie A', 'poster_path' => '/a.jpg', 'backdrop_path' => '/b.jpg', 'vote_average' => 8.5, 'overview' => 'Great movie', 'release_date' => '2024-01-01'],
                ['id' => 2, 'title' => 'Movie B', 'poster_path' => '/c.jpg', 'backdrop_path' => '/d.jpg', 'vote_average' => 7.5, 'overview' => 'Good movie', 'release_date' => '2024-02-01'],
            ],
        ]),
    ]);

    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Movie A');
    $response->assertSee('Movie B');
});

test('index shows trending movies by default', function () {
    Http::fake([
        'api.themoviedb.org/3/genre/movie/list*' => Http::response(['genres' => []]),
        'api.themoviedb.org/3/genre/tv/list*' => Http::response(['genres' => []]),
        'api.themoviedb.org/3/trending/all/day*' => Http::response([
            'results' => [
                ['id' => 1, 'title' => 'Trending Now', 'poster_path' => '/p.jpg', 'vote_average' => 8.0, 'genre_ids' => [], 'release_date' => '2024-01-01'],
            ],
            'total_results' => 1,
            'page' => 1,
            'total_pages' => 1,
        ]),
    ]);

    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get(route('movies.index'));

    $response->assertOk();
    $response->assertSee('Trending Now');
});

test('index searches movies by query', function () {
    Http::fake([
        'api.themoviedb.org/3/genre/movie/list*' => Http::response(['genres' => []]),
        'api.themoviedb.org/3/genre/tv/list*' => Http::response(['genres' => []]),
        'api.themoviedb.org/3/search/multi*' => Http::response([
            'results' => [
                ['id' => 10, 'title' => 'Search Result', 'poster_path' => '/s.jpg', 'vote_average' => 7.0, 'genre_ids' => [], 'release_date' => '2024-03-01'],
            ],
            'total_results' => 1,
            'page' => 1,
            'total_pages' => 1,
        ]),
    ]);

    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get(route('movies.index', ['search' => 'test']));

    $response->assertOk();
    $response->assertSee('Search Result');
});

test('show displays movie detail with credits', function () {
    Http::fake([
        'api.themoviedb.org/3/movie/99*' => Http::response([
            'id' => 99,
            'title' => 'Detail Movie',
            'poster_path' => '/d.jpg',
            'backdrop_path' => '/b.jpg',
            'vote_average' => 9.0,
            'overview' => 'Amazing film',
            'release_date' => '2024-05-01',
            'genres' => [['id' => 1, 'name' => 'Action']],
            'credits' => ['cast' => [], 'crew' => []],
        ]),
    ]);

    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get(route('movies.show', ['id' => 99, 'type' => 'movie']));

    $response->assertOk();
    $response->assertSee('Detail Movie');
    $response->assertSee('Amazing film');
});
