<?php

namespace App\Livewire\SuratMasuk;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Surat Masuk')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.surat-masuk.index');
    }
}
