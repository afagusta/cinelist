<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
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
            'name' => 'Biasa aja',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($userRole);

        $user1 = User::firstOrCreate([
            'email' => 'user1@cinelist.com',
            'name' => 'Afa Ganteng',
            'password' => Hash::make('password'),
        ]);
        $user1->assignRole($userRole);
    }
}
