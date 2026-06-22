<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use Spatie\Permission\Models\Role; 
use Illuminate\Support\Facades\Hash; 

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Role Admin dan User
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // 2. Buat Akun Admin CineList
        $admin = User::firstOrCreate([
            'email' => 'admin@cinelist.com',
            'name' => 'Admin CineList',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        // 3. Buat Akun User Biasa
        $user = User::firstOrCreate([
            'email' => 'user@cinelist.com',
            'name' => 'Pengguna Biasa',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($userRole);
    }
}