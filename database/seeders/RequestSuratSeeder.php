<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\RequestSurat;
use App\Models\LogSurat;
use Illuminate\Support\Carbon;

class RequestSuratSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->command->info('Memulai proses seeding untuk Request Surat dan Log Surat...');

        $bidangUsers = User::where('role', 2)->get();
        if ($bidangUsers->isEmpty()) {
            $this->command->error('Tidak ada user dengan role "Bidang" (role = 2) ditemukan. Seeder dibatalkan.');
            Schema::enableForeignKeyConstraints();
            return;
        }

        $arsipUser = User::whereIn('role', [0, 1])->inRandomOrder()->first();
        if (!$arsipUser) {
            $this->command->error('Tidak ada user "Admin" atau "Arsip" (role 0 atau 1) ditemukan. Seeder dibatalkan.');
            Schema::enableForeignKeyConstraints();
            return;
        }

        $bidangOptions = [
            'Pembangunan Ekonomi',
            'Pemerintahan',
            'Kemasyarakatan',
            'Sarana Prasarana',
            'Keuangan'
        ];
        $statuses = ['Menunggu', 'Disetujui'];
        $today = Carbon::today();
        $startDate = Carbon::today()->subDays(6); // 6 hari lalu

        for ($i = 1; $i <= 15; $i++) {
            $pemohon = $bidangUsers->random();
            $status = $statuses[array_rand($statuses)];
            $bidang = $bidangOptions[array_rand($bidangOptions)];

            // Tanggal dibuat
            $createdAt = ($i === 1)
                ? $today // Data pertama = hari ini
                : Carbon::parse($startDate)->addDays(rand(0, 6)); // Random di 6 hari sebelumnya

            $newRequest = RequestSurat::create([
                'user_id' => $pemohon->id,
                'bidang' => $bidang,
                'berkas' => 'berkas_request/dummy_berkas_test_' . $i . '.pdf',
                'keterangan' => 'Keterangan uji untuk request dari ' . $bidang,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            if ($status === 'Disetujui') {
                $tanggalDisetujui = (clone $createdAt)->addDays(rand(0, 1));

                $newRequest->update([
                    'nomor_surat' => 'TEST/' . (200 + $i) . '/VII/' . $createdAt->year,
                    'tanggal_disetujui' => $tanggalDisetujui,
                    'approved_by_user_id' => $arsipUser->id,
                ]);

                LogSurat::create([
                    'request_surat_id' => $newRequest->id,
                    'user_id' => $arsipUser->id,
                    'nomor_surat' => $newRequest->nomor_surat,
                    'tanggal_arsip' => $tanggalDisetujui,
                    'bidang' => $newRequest->bidang,
                ]);
            }
        }

        Schema::enableForeignKeyConstraints();
        $this->command->info('Seeding 15 Request Surat berhasil dengan distribusi tanggal acak dan 1 data hari ini.');
    }
}
