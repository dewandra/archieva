<?php

namespace App\Livewire\SuratKeluar;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Surat Keluar')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.surat-keluar.index');
    }
}
