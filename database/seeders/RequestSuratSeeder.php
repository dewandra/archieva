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
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Non-aktifkan sementara aturan foreign key untuk pembersihan
        Schema::disableForeignKeyConstraints();
        $this->command->info('Memulai proses seeding untuk Request Surat dan Log Surat...');

        // 1. Ambil semua user yang relevan
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

        // 2. Definisikan data master
        $bidangOptions = [
            'Pembangunan Ekonomi', 
            'Pemerintahan', 
            'Kemasyarakatan', 
            'Sarana Prasarana', 
            'Keuangan'
        ];
        $statuses = ['Menunggu', 'Disetujui'];
        $startDate = Carbon::create(2025, 6, 23);
        $endDate = Carbon::create(2025, 6, 29);

        // 3. Loop untuk membuat 15 data
        for ($i = 1; $i <= 15; $i++) {
            // Pilih data secara acak
            $pemohon = $bidangUsers->random();
            $status = $statuses[array_rand($statuses)];
            $bidang = $bidangOptions[array_rand($bidangOptions)];
            
            // Buat tanggal acak dalam rentang yang ditentukan
            $randomTimestamp = mt_rand($startDate->timestamp, $endDate->timestamp);
            $createdAt = Carbon::createFromTimestamp($randomTimestamp);

            // Buat data RequestSurat
            $newRequest = RequestSurat::create([
                'user_id' => $pemohon->id,
                'bidang' => $bidang,
                'berkas' => 'berkas_request/dummy_berkas_test_' . $i . '.pdf',
                'keterangan' => 'Keterangan uji untuk request dari ' . $bidang,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Jika statusnya 'Disetujui', buat LogSurat yang terintegrasi
            if ($status === 'Disetujui') {
                $tanggalDisetujui = $createdAt->addDays(rand(0, 1)); // Disetujui 0-1 hari setelah request
                
                // Update request dengan data persetujuan
                $newRequest->update([
                    'nomor_surat' => 'TEST/' . (200 + $i) . '/VI/' . $createdAt->year,
                    'tanggal_disetujui' => $tanggalDisetujui,
                    'approved_by_user_id' => $arsipUser->id,
                ]);

                // Buat LogSurat yang berelasi
                LogSurat::create([
                    'request_surat_id' => $newRequest->id,
                    'user_id' => $arsipUser->id,
                    'nomor_surat' => $newRequest->nomor_surat,
                    'tanggal_arsip' => $tanggalDisetujui,
                    'bidang' => $newRequest->bidang,
                ]);
            }
        }
        
        // Aktifkan kembali aturan foreign key
        Schema::enableForeignKeyConstraints();
        $this->command->info('Seeding 15 Request Surat dengan status Menunggu/Disetujui berhasil!');
    }
}