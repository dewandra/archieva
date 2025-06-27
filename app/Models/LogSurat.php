<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_surat_id',
        'user_id',
        'nomor_surat',
        'tanggal_arsip',
        'bidang',
    ];

    protected $casts = [
        'tanggal_arsip' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestSurat()
    {
        return $this->belongsTo(RequestSurat::class);
    }
}
