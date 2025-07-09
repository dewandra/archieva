<?php

namespace Database\Seeders;

use App\Models\LogSurat;
use App\Models\RequestSurat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LogSuratSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = User::where('role', 1)->first() ?? User::first();
        if (!$petugas) {
            $this->command->error('Tidak ada user ditemukan. Silakan buat user terlebih dahulu.');
            return;
        }

        $requestSurat = RequestSurat::firstOrCreate(
            ['bidang' => 'Bidang Testing'],
            [
                'user_id' => $petugas->id,
                'berkas' => 'dummy_berkas.pdf',
                'keterangan' => 'Request untuk seeding data.',
                'status' => 'Disetujui',
                'nomor_surat' => 'SEED/001/VI/' . now()->year,
                'tanggal_disetujui' => now(),
                'approved_by_user_id' => $petugas->id,
            ]
        );

        $this->command->info('Membuat 10 data log selama seminggu terakhir...');

        for ($i = 1; $i <= 10; $i++) {
            // Buat tanggal acak dalam 7 hari ke belakang
            $createdAt = Carbon::today()->subDays(rand(0, 6))->setTime(rand(8, 16), rand(0, 59), 0);
            $tanggalArsip = $createdAt->copy(); // Bisa sama dengan created_at atau bisa digeser jika ingin

            LogSurat::create([
                'request_surat_id' => $requestSurat->id,
                'user_id' => $petugas->id,
                'nomor_surat' => '470/' . (100 + $i) . '/PEM',
                'bidang' => 'Bidang Test ' . chr(64 + $i), // A, B, C, ...
                'tanggal_arsip' => $tanggalArsip,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        $this->command->info('Seeding 10 data log berhasil!');
    }
}
