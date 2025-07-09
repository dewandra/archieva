<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
// 1. Buat User Admin (role 0)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 0,
        ]);

        // 2. Buat User Arsip (role 1)
        User::factory()->create([
            'name' => 'Arsip User',
            'email' => 'arsip@example.com',
            'role' => 1,
        ]);

        // 3. Buat User Bidang (role 2)
        User::factory()->create([
            'name' => 'Bidang User',
            'email' => 'bidang@example.com',
            'role' => 2,
        ]);
        
        // Membuat 5 user bidang tambahan sebagai data dummy
        User::factory(5)->create([
            'role' => 2,
        ]);

        $this-> call([
            SuratMasukSeeder::class,
            SuratKeluarSeeder::class,
            RequestSuratSeeder::class,
        ]);
    }
}
