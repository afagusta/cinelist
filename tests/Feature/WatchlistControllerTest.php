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
    $response->assertSee('Belum Ditonton');
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

test('index filters by movie type', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    Watchlist::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 1,
        'title' => 'Movie Item',
        'type' => 'movie',
    ]);

    Watchlist::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 2,
        'title' => 'TV Item',
        'type' => 'tv',
    ]);

    $response = $this->actingAs($user)->get(route('watchlists.index', ['type' => 'movie']));

    $response->assertOk();
    $response->assertSee('Movie Item');
    $response->assertDontSee('TV Item');
});

test('index filters by tv type', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    Watchlist::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 1,
        'title' => 'Movie Item',
        'type' => 'movie',
    ]);

    Watchlist::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 2,
        'title' => 'TV Item',
        'type' => 'tv',
    ]);

    $response = $this->actingAs($user)->get(route('watchlists.index', ['type' => 'tv']));

    $response->assertOk();
    $response->assertSee('TV Item');
    $response->assertDontSee('Movie Item');
});

test('guest cannot access watchlists', function () {
    $response = $this->get(route('watchlists.index'));
    $response->assertRedirect(route('login'));
});

test('toggle-watched marks as watched', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $watchlist = Watchlist::factory()->create([
        'user_id' => $user->id,
        'is_watched' => false,
    ]);

    $response = $this->actingAs($user)->patch(route('watchlists.toggle-watched', $watchlist));

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('watchlists', [
        'id' => $watchlist->id,
        'is_watched' => true,
    ]);
});

test('toggle-watched marks as unwatched', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $watchlist = Watchlist::factory()->watched()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->patch(route('watchlists.toggle-watched', $watchlist));

    $response->assertRedirect();

    $this->assertDatabaseHas('watchlists', [
        'id' => $watchlist->id,
        'is_watched' => false,
    ]);
});

test('toggle-watched cannot toggle another users watchlist', function () {
    $user = User::factory()->create();
    $user->assignRole('user');
    $other = User::factory()->create();

    $watchlist = Watchlist::factory()->create([
        'user_id' => $other->id,
        'is_watched' => false,
    ]);

    $response = $this->actingAs($user)->patch(route('watchlists.toggle-watched', $watchlist));

    $response->assertForbidden();
});
