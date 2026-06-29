<?php

use App\Models\Review;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'user']);
    Role::firstOrCreate(['name' => 'admin']);
});

test('store creates a new review', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->post(route('reviews.store'), [
        'tmdb_movie_id' => 100,
        'rating' => 5,
        'comment' => 'Film yang sangat bagus!',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('reviews', [
        'user_id' => $user->id,
        'tmdb_movie_id' => 100,
        'rating' => 5,
        'comment' => 'Film yang sangat bagus!',
    ]);
});

test('store validates rating range', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->post(route('reviews.store'), [
        'tmdb_movie_id' => 100,
        'rating' => 10,
        'comment' => 'Test',
    ]);

    $response->assertSessionHasErrors(['rating']);
});

test('store validates required fields', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->post(route('reviews.store'), []);

    $response->assertSessionHasErrors(['tmdb_movie_id', 'rating', 'comment']);
});

test('owner can destroy their own review', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $review = Review::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 100,
    ]);

    $response = $this->actingAs($user)->delete(route('reviews.destroy', $review));

    $response->assertRedirect();
    $response->assertSessionHas('status');

    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});

test('admin can destroy any review', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $user = User::factory()->create();

    $review = Review::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 100,
    ]);

    $response = $this->actingAs($admin)->delete(route('reviews.destroy', $review));

    $response->assertRedirect();

    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});

test('non-owner cannot destroy another users review', function () {
    $user = User::factory()->create();
    $user->assignRole('user');
    $other = User::factory()->create();
    $other->assignRole('user');

    $review = Review::factory()->create([
        'user_id' => $other->id,
        'tmdb_movie_id' => 100,
    ]);

    $this->actingAs($user)->delete(route('reviews.destroy', $review));

    $this->assertDatabaseHas('reviews', ['id' => $review->id]);
});

test('store prevents duplicate review for same movie', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    Review::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 100,
        'rating' => 3,
        'comment' => 'Biasa aja',
    ]);

    $response = $this->actingAs($user)->post(route('reviews.store'), [
        'tmdb_movie_id' => 100,
        'rating' => 5,
        'comment' => 'Ternyata bagus!',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status');

    $this->assertDatabaseCount('reviews', 1);
    $this->assertDatabaseHas('reviews', [
        'user_id' => $user->id,
        'tmdb_movie_id' => 100,
        'rating' => 5,
        'comment' => 'Ternyata bagus!',
    ]);
});

test('owner can update their own review', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $review = Review::factory()->create([
        'user_id' => $user->id,
        'tmdb_movie_id' => 100,
        'rating' => 3,
        'comment' => 'Lumayan',
    ]);

    $response = $this->actingAs($user)->patch(route('reviews.update', $review), [
        'rating' => 5,
        'comment' => 'Ternyata sangat bagus!',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('reviews', [
        'id' => $review->id,
        'rating' => 5,
        'comment' => 'Ternyata sangat bagus!',
    ]);
});

test('non-owner cannot update another users review', function () {
    $user = User::factory()->create();
    $user->assignRole('user');
    $other = User::factory()->create();
    $other->assignRole('user');

    $review = Review::factory()->create([
        'user_id' => $other->id,
        'tmdb_movie_id' => 100,
        'rating' => 3,
        'comment' => 'Lumayan',
    ]);

    $response = $this->actingAs($user)->patch(route('reviews.update', $review), [
        'rating' => 5,
        'comment' => 'Diubah oleh orang lain',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseHas('reviews', [
        'id' => $review->id,
        'rating' => 3,
        'comment' => 'Lumayan',
    ]);
});

test('guest cannot create reviews', function () {
    $response = $this->post(route('reviews.store'), [
        'tmdb_movie_id' => 100,
        'rating' => 5,
        'comment' => 'Good',
    ]);

    $response->assertRedirect(route('login'));
});
