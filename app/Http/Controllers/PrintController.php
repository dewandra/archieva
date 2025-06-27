<?php

namespace App\Http\Controllers;

use App\Models\LogSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PrintController extends Controller
{
    public function printLogSurat($date)
    {
        $selectedDate = Carbon::parse($date);

        // Ambil SEMUA log untuk tanggal yang dipilih, tanpa paginasi
        $logs = LogSurat::with('user')
            ->whereDate('tanggal_arsip', $selectedDate)
            ->latest()
            ->get();

        $title = 'Laporan Log Surat - ' . $selectedDate->isoFormat('D MMMM Y');

        // Kita akan membuat view 'prints.log-surat' pada langkah berikutnya
        return view('prints.log-surat', [
            'logs' => $logs,
            'selectedDate' => $selectedDate,
            'title' => $title,
        ]);
    }
}
