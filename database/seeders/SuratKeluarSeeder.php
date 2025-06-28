<?php

namespace Database\Seeders;

use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SuratKeluarSeeder extends Seeder
{
    public function run(): void
    {
        SuratKeluar::truncate();
        $user = User::first();
        if (!$user) {
            $this->command->error('User tidak ditemukan.');
            return;
        }

        $this->command->info('Membuat data dummy Surat Keluar sesuai alur yang benar...');

        // Skenario Halaman 1
        $this->createSuratForDate('2025-06-22', 1, 34, $user->id);
        $this->createSuratForDate('2025-06-23', 35, 67, $user->id);
        $this->createSuratForDate('2025-06-24', 68, 100, $user->id);

        // Tanggal 25 Juni sengaja dilompati (asumsi libur)

        // Skenario Halaman 2 (Nomor direset kembali)
        $this->createSuratForDate('2025-06-26', 1, 34, $user->id);
        $this->createSuratForDate('2025-06-27', 35, 67, $user->id);
        $this->createSuratForDate('2025-06-28', 68, 100, $user->id);

        $this->command->info('Seeding Surat Keluar selesai.');
    }

    /**
     * Helper function untuk membuat data surat pada rentang nomor tertentu.
     */
    private function createSuratForDate(string $tanggal, int $nomor_awal, int $nomor_akhir, int $userId): void
    {
        for ($i = $nomor_awal; $i <= $nomor_akhir; $i++) {
            SuratKeluar::create([
                'tanggal' => Carbon::parse($tanggal),
                'nomor_surat' => str_pad($i, 2, '0', STR_PAD_LEFT),
                'klasifikasi' => 'Klasifikasi untuk tgl ' . $tanggal . ' no. ' . $i,
                'user_id' => $userId,
            ]);
        }
    }
}