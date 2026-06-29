<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'user']);
});

test('admin dashboard shows statistics', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    User::factory()->count(3)->create()->each(fn ($u) => $u->assignRole('user'));

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertSee('Panel Admin');
    $response->assertSee('Total Pengguna');
});

test('admin can delete a user', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

    $response->assertRedirect();
    $response->assertSessionHas('status');

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('admin cannot delete themselves', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

    $response->assertRedirect();
    $response->assertSessionHasErrors();

    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

test('guest cannot access admin dashboard', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertRedirect(route('login'));
});

test('regular user cannot access admin dashboard', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('regular user cannot delete users', function () {
    $user = User::factory()->create();
    $user->assignRole('user');
    $target = User::factory()->create();

    $response = $this->actingAs($user)->delete(route('admin.users.destroy', $target));

    $response->assertForbidden();
});
