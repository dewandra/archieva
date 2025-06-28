<?php

namespace App\Livewire\Homepage;

use App\Models\RequestSurat;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Index extends Component
{
    // Properti untuk menyimpan jumlah total hari ini
    public int $countSuratMasukToday = 0;
    public int $countSuratKeluarToday = 0;
    public int $countRequestSuratToday = 0;

    // Properti untuk data grafik
    public array $chartLabels = [];
    public array $chartSuratMasuk = [];
    public array $chartSuratKeluar = [];
    public array $chartRequestSurat = [];

    // Properti untuk tabel surat terbaru
    public $latestSuratMasuk = [];
    public $latestSuratKeluar = [];
    public $latestRequestSurat = [];

    /**
     * Method mount() dijalankan saat komponen pertama kali di-load.
     * Ini adalah tempat terbaik untuk mengambil data awal dari database.
     */
    public function mount()
    {
        $this->loadSummaryData();
        $this->loadChartData();
        $this->loadLatestLetters();
    }

    /**
     * Mengambil data ringkasan untuk kartu di bagian atas.
     */
    public function loadSummaryData()
    {
        // Menghitung jumlah surat masuk, keluar, dan request yang dibuat hari ini
        $this->countSuratMasukToday = SuratMasuk::whereDate('created_at', today())->count();
        $this->countSuratKeluarToday = SuratKeluar::whereDate('created_at', today())->count();
        $this->countRequestSuratToday = RequestSurat::whereDate('created_at', today())->count();
    }

    /**
     * Menyiapkan data untuk ditampilkan pada grafik mingguan.
     */
    public function loadChartData()
    {
        $this->chartLabels = [];
        $this->chartSuratMasuk = [];
        $this->chartSuratKeluar = [];
        $this->chartRequestSurat = [];

        // Loop untuk 7 hari terakhir untuk mengisi data grafik
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $this->chartLabels[] = $date->isoFormat('dddd'); // Format hari dalam Bahasa Indonesia

            // Ambil jumlah data per hari
            $this->chartSuratMasuk[] = SuratMasuk::whereDate('created_at', $date)->count();
            $this->chartSuratKeluar[] = SuratKeluar::whereDate('created_at', $date)->count();
            $this->chartRequestSurat[] = RequestSurat::whereDate('created_at', $date)->count();
        }
    }

    /**
     * Mengambil 5 surat masuk dan keluar terbaru untuk ditampilkan di tabel.
     */
    public function loadLatestLetters()
    {
        $this->latestSuratMasuk = SuratMasuk::latest()->take(2)->get();
        $this->latestSuratKeluar = SuratKeluar::latest()->take(2)->get();
        $this->latestRequestSurat = RequestSurat::latest()->take(2)->get();
    }

    /**
     * Method render() bertugas untuk menampilkan view.
     */
    public function render()
    {
        return view('livewire.homepage.index');
    }
}