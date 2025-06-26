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
        Schema::create('request_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('bidang');
            $table->string('berkas');
            $table->text('keterangan')->nullable();
            $table->string('status')->default('Menunggu');
            
            // KOLOM BARU UNTUK NOMOR SURAT YANG DI-INPUT ARSIP
            $table->string('nomor_surat')->nullable(); 
            
            // KOLOM BARU UNTUK TANGGAL SURAT DIBERIKAN
            $table->date('tanggal_disetujui')->nullable();

            $table->foreignId('approved_by_user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_surats');
    }
};
