<?php

namespace App\Livewire\LogSurat;

use App\Models\LogSurat;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    // Gunakan trait WithPagination untuk data log harian
    use WithPagination;

    public $selectedDate;
    protected $paginationTheme = 'bootstrap';

    // Mendengarkan event perubahan tanggal dari view
    protected $listeners = ['dateChanged' => 'setDate'];

    public function mount()
    {
        // Saat komponen dimuat, set tanggal ke hari ini jika tidak ada tanggal yang dipilih
        if (empty($this->selectedDate)) {
            $latestLog = LogSurat::latest('tanggal_arsip')->first();
            $this->selectedDate = $latestLog ? $latestLog->tanggal_arsip->format('Y-m-d') : now()->format('Y-m-d');
        }
    }

    public function setDate($date)
    {
        $this->selectedDate = $date;
        $this->resetPage(); // Reset paginasi data log saat tanggal berubah
    }

    public function getAvailableDatesProperty()
    {
        // Ambil 10 tanggal unik terbaru untuk navigasi
        return LogSurat::selectRaw('DATE(tanggal_arsip) as date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->limit(10)
            ->pluck('date');
    }

    public function changeDate($direction)
    {
        $current = Carbon::parse($this->selectedDate);
        $newDate = $direction === 'next' ? $current->addDay() : $current->subDay();
        $this->setDate($newDate->format('Y-m-d'));
    }

    public function render()
    {
        // Paginasi sekarang diterapkan pada data log di dalam tanggal yang dipilih
        $logsThisDay = LogSurat::with('user')
            ->whereDate('tanggal_arsip', $this->selectedDate)
            ->latest()
            ->paginate(10); // <-- Menampilkan 10 log per halaman

        return view('livewire.log-surat.index', [
            'logs' => $logsThisDay,
            'currentDate' => Carbon::parse($this->selectedDate),
        ]);
    }
}