<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'pengirim',
        'tanggal_surat',
        'tanggal_diterima',
        'perihal',
        'sifat',
        'status',
        'lampiran',
        'tujuan_surat',
        'posisi_surat',
        'user_id'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
        'tujuan_surat' => 'array', // Untuk menyimpan tujuan surat dalam format JSON
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
