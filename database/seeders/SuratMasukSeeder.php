<?php

namespace Database\Seeders;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SuratMasukSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $this->command->info('Membuat 25 data dummy untuk Surat Masuk selama seminggu terakhir...');

        $sifatSurat = ['Biasa', 'Penting', 'Sangat Penting', 'Rahasia'];
        $tujuanSurat = ['TU', 'Penyusunan Program', 'Keuangan', 'Pembangunan Ekonomi', 'Kemasyarakatan', 'Sarana Prasarana'];
        $posisiSurat = ['AE', 'OTU', 'SEKBN', 'KABAN'];

        for ($i = 1; $i <= 25; $i++) {
            // Tanggal surat selama 7 hari terakhir
            $tanggalSurat = Carbon::today()->subDays(rand(0, 6))->setTime(rand(8, 15), rand(0, 59));

            SuratMasuk::create([
                'nomor_surat' => '470/' . (100 + $i) . '/DUMMY/' . $tanggalSurat->year,
                'pengirim' => fake()->company(),
                'tanggal_surat' => $tanggalSurat,
                'tanggal_diterima' => $tanggalSurat->copy()->addDays(rand(0, 2)),
                'perihal' => 'Perihal tentang ' . Str::lower(fake()->bs()),
                'sifat' => $sifatSurat[array_rand($sifatSurat)],
                'status' => 'Belum Diproses',
                'lampiran' => null,
                'tujuan_surat' => implode(', ', fake()->randomElements($tujuanSurat, rand(1, 2))),
                'posisi_surat' => $posisiSurat[array_rand($posisiSurat)],
                'user_id' => $user->id,
                'created_at' => $tanggalSurat,
                'updated_at' => $tanggalSurat,
            ]);
        }

        $this->command->info('Seeding 25 data Surat Masuk berhasil!');
    }
}
