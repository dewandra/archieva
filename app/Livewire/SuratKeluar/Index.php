<?php

namespace App\Livewire\SuratKeluar;

use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Surat Keluar')]
class Index extends Component
{
    // WithPagination dihapus karena paginasi ditangani secara manual.

    //================================================
    // SECTION: Properti Komponen
    //================================================

    public $suratId;
    public $tanggal;
    public $nomor_surat;
    public $klasifikasi;
    public $isEditMode = false;

    // Properti untuk filter dan pencarian
    public $filterTahun = '';
    public $filterBulan = '';
    public $search = '';

    // Properti untuk paginasi manual
    public $page = 1;
    public $perPage = 3; // Menampilkan 3 tanggal per halaman
    public $totalDates = 0;


    //================================================
    // SECTION: Metode Paginasi Manual
    //================================================
    
    public function nextPage()
    {
        // Hanya menambah halaman jika halaman saat ini bukan halaman terakhir
        if ($this->page < ceil($this->totalDates / $this->perPage)) {
            $this->page++;
        }
    }

    public function previousPage()
    {
        // Hanya mengurangi halaman jika bukan halaman pertama
        if ($this->page > 1) {
            $this->page--;
        }
    }

    public function goToPage($page)
    {
        $this->page = $page;
    }

    //================================================
    // SECTION: Lifecycle Hooks
    //================================================

    public function updated($propertyName): void
    {
        // Me-reset ke halaman 1 setiap kali filter atau pencarian diubah
        if (in_array($propertyName, ['filterTahun', 'filterBulan', 'search'])) {
            $this->page = 1;
        }
    }

    //================================================
    // SECTION: Metode Render
    //================================================

    public function render()
    {
        // Mengambil daftar tahun unik untuk opsi filter.
        $availableYears = SuratKeluar::select(DB::raw('YEAR(tanggal) as year'))
            ->distinct()->orderBy('year', 'desc')->pluck('year');

        // Memulai query builder dasar.
        $query = SuratKeluar::query();

        // Menerapkan filter sebelum kalkulasi paginasi.
        if ($this->filterTahun) $query->whereYear('tanggal', $this->filterTahun);
        if ($this->filterBulan) $query->whereMonth('tanggal', $this->filterBulan);
        if ($this->search) {
            $query->where(function ($subQuery) {
                $subQuery->where('nomor_surat', 'like', '%' . $this->search . '%')
                         ->orWhere('klasifikasi', 'like', '%' . $this->search . '%');
            });
        }
        
        // 1. Ambil semua tanggal unik yang sesuai dengan filter untuk dihitung.
        $allDistinctDates = $query->select('tanggal')->distinct()->orderBy('tanggal', 'asc')->pluck('tanggal');
        
        // 2. Hitung total tanggal unik untuk paginasi.
        $this->totalDates = $allDistinctDates->count();
        
        // 3. Ambil "potongan" tanggal (slice) untuk halaman saat ini.
        $datesForCurrentPage = $allDistinctDates->slice(($this->page - 1) * $this->perPage, $this->perPage);

        $suratItems = collect();
        if ($datesForCurrentPage->isNotEmpty()) {
            $suratItems = SuratKeluar::with('user')
                ->whereIn('tanggal', $datesForCurrentPage)
                ->when($this->search, function ($subQuery) {
                    $subQuery->where(function ($q) {
                        $q->where('nomor_surat', 'like', '%' . $this->search . '%')
                          ->orWhere('klasifikasi', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('tanggal', 'asc')
                // FIX: Paksa pengurutan 'nomor_surat' (string) sebagai angka (integer).
                ->orderByRaw('CAST(nomor_surat AS UNSIGNED) asc')
                ->get();
        }

        $groupedSurat = $suratItems->groupBy(fn ($item) => $item->tanggal->format('Y-m-d'))->sortKeys();

        return view('livewire.surat-keluar.index', [
            'groupedSurat'   => $groupedSurat,
            'availableYears' => $availableYears,
        ]);
    }

    //================================================
    // SECTION: Aksi Modal
    //================================================
    
    public function showCreateModal(): void
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->tanggal = now()->format('Y-m-d');
        $this->dispatch('open-modal', name: 'surat-keluar-modal');
    }

    public function showEditModal(int $id): void
    {
        $surat = SuratKeluar::findOrFail($id);
        $this->suratId = $surat->id;
        $this->tanggal = $surat->tanggal->format('Y-m-d');
        $this->nomor_surat = $surat->nomor_surat;
        $this->klasifikasi = $surat->klasifikasi;
        $this->isEditMode = true;
        $this->dispatch('open-modal', name: 'surat-keluar-modal');
    }

    //================================================
    // SECTION: Operasi CRUD
    //================================================

    public function save(): void
    {
        $rules = [
            'tanggal'     => 'required|date',
            'nomor_surat' => 'required|numeric|min:1|max:100',
            'klasifikasi' => 'required|string|max:255',
        ];
        $rules['nomor_surat'] .= '|unique:surat_keluars,nomor_surat,' . $this->suratId . ',id,tanggal,' . $this->tanggal;
        $messages = [
            'tanggal.required'       => 'Kolom tanggal wajib diisi.',
            'nomor_surat.required'   => 'Kolom nomor surat wajib diisi.',
            'nomor_surat.numeric'    => 'Nomor surat harus berupa angka.',
            'nomor_surat.min'        => 'Nomor surat tidak boleh kurang dari 1.',
            'nomor_surat.max'        => 'Nomor surat tidak boleh lebih dari 100.',
            'nomor_surat.unique'     => 'Nomor surat ini sudah terdaftar pada tanggal yang sama.',
            'klasifikasi.required'   => 'Kolom klasifikasi wajib diisi.',
            'klasifikasi.max'        => 'Klasifikasi tidak boleh melebihi 255 karakter.',
        ];
        
        $this->validate($rules, $messages);
        
        SuratKeluar::updateOrCreate(
            ['id' => $this->suratId],
            [
                'tanggal'     => $this->tanggal,
                'nomor_surat' => str_pad($this->nomor_surat, 2, '0', STR_PAD_LEFT),
                'klasifikasi' => $this->klasifikasi,
                'user_id'     => Auth::id(),
            ]
        );

        $message = $this->isEditMode ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.';
        $this->dispatch('swal:success', message: $message);
        $this->dispatch('close-modal', name: 'surat-keluar-modal');
    }

    public function confirmDelete(int $id): void
    {
        $this->dispatch('swal:confirm', id: $id, title: 'Anda Yakin?', text: 'Data surat yang dihapus tidak dapat dikembalikan!', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal');
    }

    #[On('destroy')]
    public function destroy(int $id): void
    {
        SuratKeluar::find($id)->delete();
        $this->dispatch('swal:success', message: 'Data berhasil dihapus.');
    }

    //================================================
    // SECTION: Metode Utilitas
    //================================================
    
    private function resetForm(): void
    {
        $this->reset(['suratId', 'isEditMode', 'tanggal', 'nomor_surat', 'klasifikasi']);
    }
}