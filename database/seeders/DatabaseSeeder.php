<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DesaSeeder::class,
            RtSeeder::class,
            JenisSuratSeeder::class,
        ]);

        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@simades.local',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Create Admin Desa
        User::create([
            'name' => 'Admin Desa Sukamaju',
            'email' => 'admin.desa@sukamaju.local',
            'password' => Hash::make('password'),
            'role' => 'admin_desa',
            'desa_id' => 1,
            'is_active' => true,
        ]);

        // Create Kepala Desa
        User::create([
            'name' => 'H. Ahmad Sudirman',
            'email' => 'kades@sukamaju.local',
            'password' => Hash::make('password'),
            'role' => 'kepala_desa',
            'desa_id' => 1,
            'is_active' => true,
        ]);

        // Create Ketua RT
        User::create([
            'name' => 'Bapak Ketua RT 01',
            'email' => 'rt01@sukamaju.local',
            'password' => Hash::make('password'),
            'role' => 'ketua_rt',
            'desa_id' => 1,
            'rt_id' => 1, // RT 01/RW 01
            'is_active' => true,
        ]);

        // Create Test Warga
        User::create([
            'name' => 'John Doe',
            'email' => 'warga@sukamaju.local',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'desa_id' => 1,
            'rt_id' => 1,
            'is_active' => true,
        ]);
    }
}
