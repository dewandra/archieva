<?php

namespace Database\Seeders;

use App\Models\LogSurat;
use App\Models\RequestSurat;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LogSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari user 'arsip' atau user pertama sebagai petugas
        $petugas = User::where('role', 1)->first() ?? User::first();
        if (!$petugas) {
            $this->command->error('Tidak ada user ditemukan. Silakan buat user terlebih dahulu.');
            return;
        }

        // 2. Cari request surat yang sudah ada atau buat satu dummy request
        $requestSurat = RequestSurat::firstOrCreate(
            ['bidang' => 'Bidang Testing'],
            [
                'user_id' => $petugas->id,
                'berkas' => 'dummy_berkas.pdf',
                'keterangan' => 'Request untuk seeding data.',
                'status' => 'Disetujui',
                'nomor_surat' => 'SEED/001/VI/2025',
                'tanggal_disetujui' => now(),
                'approved_by_user_id' => $petugas->id,
            ]
        );

        $this->command->info('Membuat 10 data log untuk tanggal 27 Juni 2025...');

        // 3. Loop untuk membuat 10 data log
        for ($i = 1; $i <= 10; $i++) {
            LogSurat::create([
                'request_surat_id' => $requestSurat->id,
                'user_id' => $petugas->id,
                'nomor_surat' => '470/' . (100 + $i) . '/PEM', // Nomor surat unik
                'bidang' => 'Bidang Test ' . chr(64 + $i), // Bidang A, B, C, dst.
                'tanggal_arsip' => Carbon::create(2025, 6, 27, 9, $i * 3, 0), // Tanggal dan waktu yang berbeda-beda
            ]);
        }
        
        $this->command->info('Seeding 10 data log berhasil!');
    }
}
