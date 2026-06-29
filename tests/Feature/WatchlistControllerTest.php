<?php

use App\Models\User;
use App\Models\Watchlist;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'user']);
});

test('index displays user watchlists', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    Watchlist::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 1,
        'title' => 'Saved Movie',
        'type' => 'movie',
    ]);

    $response = $this->actingAs($user)->get(route('watchlists.index'));

    $response->assertOk();
    $response->assertSee('Saved Movie');
});

test('store creates a new watchlist entry', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->post(route('watchlists.store'), [
        'tmdb_movie_id' => 42,
        'title' => 'New Watchlist Item',
        'poster_path' => '/poster.jpg',
        'type' => 'movie',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('watchlists', [
        'user_id' => $user->id,
        'tmdb_movie_id' => 42,
        'title' => 'New Watchlist Item',
    ]);
});

test('store does not duplicate watchlist entries', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    Watchlist::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 42,
        'title' => 'Existing',
        'type' => 'movie',
    ]);

    $this->actingAs($user)->post(route('watchlists.store'), [
        'tmdb_movie_id' => 42,
        'title' => 'Existing',
        'poster_path' => null,
        'type' => 'movie',
    ]);

    $this->assertDatabaseCount('watchlists', 1);
});

test('store validates required fields', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->post(route('watchlists.store'), []);

    $response->assertSessionHasErrors(['tmdb_movie_id', 'title', 'type']);
});

test('destroy removes watchlist entry', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $watchlist = Watchlist::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 1,
        'title' => 'To Delete',
        'type' => 'movie',
    ]);

    $response = $this->actingAs($user)->delete(route('watchlists.destroy', $watchlist));

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('watchlists', ['id' => $watchlist->id]);
});

test('destroy does not delete another users watchlist', function () {
    $user = User::factory()->create();
    $user->assignRole('user');
    $other = User::factory()->create();

    $watchlist = Watchlist::factory()->create([
        'user_id' => $other->id,
        'tmdb_movie_id' => 1,
        'title' => 'Not Mine',
        'type' => 'movie',
    ]);

    $this->actingAs($user)->delete(route('watchlists.destroy', $watchlist));

    $this->assertDatabaseHas('watchlists', ['id' => $watchlist->id]);
});

test('guest cannot access watchlists', function () {
    $response = $this->get(route('watchlists.index'));
    $response->assertRedirect(route('login'));
});
