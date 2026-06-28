<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin = User::firstOrCreate([
            'email' => 'admin@cinelist.com',
            'name' => 'Admin CineList',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        $user = User::firstOrCreate([
            'email' => 'user@cinelist.com',
            'name' => 'Pengguna Biasa',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($userRole);

        $pasukanUser = User::factory()->count(1000)->create([
            'password' => Hash::make('password'),
        ]);

        foreach ($pasukanUser as $prajurit) {
            $prajurit->assignRole($userRole);
        }
    }
}
