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
        $this->createSuratForDate('2025-07-09', 1, 34, $user->id);
        $this->createSuratForDate('2025-07-10', 35, 67, $user->id);
        $this->createSuratForDate('2025-07-11', 68, 100, $user->id);

        // Skenario Halaman 2
        $this->createSuratForDate('2025-07-12', 1, 34, $user->id);
        $this->createSuratForDate('2025-07-13', 35, 67, $user->id);
        $this->createSuratForDate('2025-07-14', 68, 100, $user->id);

        $this->command->info('Seeding Surat Keluar selesai.');
    }

    private function createSuratForDate(string $tanggal, int $nomor_awal, int $nomor_akhir, int $userId): void
    {
        $carbonTanggal = Carbon::parse($tanggal);

        for ($i = $nomor_awal; $i <= $nomor_akhir; $i++) {
            SuratKeluar::create([
                'tanggal' => $carbonTanggal,
                'nomor_surat' => str_pad($i, 2, '0', STR_PAD_LEFT),
                'klasifikasi' => 'Klasifikasi untuk tgl ' . $tanggal . ' no. ' . $i,
                'user_id' => $userId,
                'created_at' => $carbonTanggal,
                'updated_at' => $carbonTanggal,
            ]);
        }
    }
}
