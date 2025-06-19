<?php

namespace App\Livewire\Homepage;

use Livewire\Component;

class Index extends Component
{

    public $cdmasuk = 0;
    public $cdkeluar = 0;
    public $cdrequest = 0;

    public $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    public $masuk = [3, 5, 6, 4, 6, 8, 25];
    public $keluar = [2, 3, 4, 3, 4, 5, 6];
    public $request = [1, 2, 1, 3, 2, 1, 2];
    public $suratMasuk = [];
    
    public function mount()
    {
        $this->cdmasuk = 20;
        $this->cdkeluar = 10;
        $this->cdrequest = 5;

        $this->suratMasuk = [
            [
                'tanggal' => '04/06/2025',
                'nomor' => 'UC3024903',
                'perihal' => 'Undangan Boter Archiputed',
            ],
            [
                'tanggal' => '05/06/2025',
                'nomor' => 'KCO436788',
                'perihal' => 'Permintaan Operasional',
            ],
            [
                'tanggal' => '01/06/2025',
                'nomor' => 'KK0357863',
                'perihal' => 'Laporan Estilistik IT',
            ],
        ];
    }
    public function render()
    {
        return view('livewire.homepage.index');
    }
}
