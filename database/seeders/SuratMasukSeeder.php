<?php

namespace Database\Seeders;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil satu user secara acak untuk dijadikan penginput data
        // Jika tidak ada user, buat satu user baru
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $this->command->info('Membuat 15 data dummy untuk Surat Masuk...');

        // 2. Opsi untuk field 'sifat', 'tujuan', dan 'posisi'
        $sifatSurat = ['Biasa', 'Penting', 'Sangat Penting', 'Rahasia'];
        $tujuanSurat = ['TU', 'Penyusunan Program', 'Keuangan', 'Pembangunan Ekonomi', 'Kemasyarakatan', 'Sarana Prasarana'];
        $posisiSurat = ['AE', 'OTU', 'SEKBN', 'KABAN'];

        // 3. Loop untuk membuat 15 data
        for ($i = 1; $i <= 15; $i++) {
            $tanggalSurat = Carbon::now()->subDays(rand(1, 30));

            SuratMasuk::create([
                'nomor_surat' => '470/' . (100 + $i) . '/DUMMY/' . $tanggalSurat->year,
                'pengirim' => fake()->company(),
                'tanggal_surat' => $tanggalSurat,
                'tanggal_diterima' => $tanggalSurat->addDays(rand(1, 3)),
                'perihal' => 'Perihal tentang ' . Str::lower(fake()->bs()),
                'sifat' => $sifatSurat[array_rand($sifatSurat)],
                'status' => 'Belum Diproses',
                'lampiran' => null, // Dibiarkan kosong
                'tujuan_surat' => fake()->randomElements($tujuanSurat, rand(1, 2)),
                'posisi_surat' => $posisiSurat[array_rand($posisiSurat)],
                'user_id' => $user->id,
            ]);
        }
        
        $this->command->info('Seeding 15 data Surat Masuk berhasil!');
    }
}