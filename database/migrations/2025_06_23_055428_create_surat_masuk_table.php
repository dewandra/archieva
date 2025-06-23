<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('pengirim');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('perihal');
            $table->string('sifat')->default('Biasa'); // Biasa, Penting, Segera, Rahasia
            $table->string('status')->default('Belum Diproses'); // Belum Diproses, Sedang Diproses, Selesai
            $table->string('lampiran')->nullable(); // Untuk menyimpan nama file surat yang diupload
            $table->json('tujuan_surat')->nullable(); // Menyimpan tujuan surat dalam format JSON
            $table->string('posisi_surat')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
