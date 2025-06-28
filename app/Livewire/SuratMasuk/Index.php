<?php

namespace App\Livewire\SuratMasuk;

use App\Livewire\Traits\WithModal;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Surat Masuk')]
class Index extends Component
{

    use WithPagination, WithModal, WithFileUploads;

    public $suratMasukId;
    public $isEditMode = false;
    public $search = '';

    // Properti untuk form (tidak ada perubahan)
    #[Rule('required|string|max:255')]
    public $nomor_surat;
    #[Rule('required|string|max:255')]
    public $pengirim;
    #[Rule('required|date')]
    public
    $tanggal_surat;
    #[Rule('required|date')]
    public $tanggal_diterima;
    #[Rule('required|string')]
    public $perihal;
    #[Rule('required|string')]
    public $sifat;
    #[Rule('nullable|array')]
    public $tujuan_surat = [];
    #[Rule('nullable|string')]
    public $posisi_surat;
    #[Rule('nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048')]
    public $lampiran;
    public $existingLampiran;

    public ?SuratMasuk $selectedSurat = null;
    public ?int $selectedNomorAgenda = null;

    // ==========================================================
    // PERBAIKAN: Inisialisasi filter ke string kosong agar tidak aktif secara default
    // ==========================================================
    public $filterTahun = '';
    public $filterBulan = '';
    public $filterSifat = '';

    protected $paginationTheme = 'bootstrap';

    // Metode mount() dihapus karena tidak lagi diperlukan untuk inisialisasi filter

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterTahun', 'filterBulan', 'filterSifat', 'search'])) {
            $this->resetPage();
        }
    }

     public function render()
    {
        $availableYears = SuratMasuk::select(DB::raw('YEAR(tanggal_diterima) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $query = SuratMasuk::with('user');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('perihal', 'like', '%' . $this->search . '%')
                  ->orWhere('nomor_surat', 'like', '%' . $this->search . '%')
                  ->orWhere('pengirim', 'like', '%' . $this->search . '%');
            });
        }

        // Logika query ini sekarang hanya akan berjalan jika filter diisi oleh pengguna
        if ($this->filterTahun) {
            $query->whereYear('tanggal_diterima', $this->filterTahun);
        }
        if ($this->filterBulan) {
            $query->whereMonth('tanggal_diterima', $this->filterBulan);
        }
        if ($this->filterSifat) {
            $query->where('sifat', $this->filterSifat);
        }

        $allSuratMasuk = $query->orderBy('id', 'asc')->paginate(10);

        return view('livewire.surat-masuk.index', [
            'allSuratMasuk' => $allSuratMasuk,
            'availableYears' => $availableYears,
        ]);
    }

    // ... (Sisa method lainnya tidak perlu diubah)
    public function showCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->tanggal_diterima = now()->format('Y-m-d');
        $this->dispatch('open-modal', name: 'surat-masuk-modal');
    }

    public function showEditModal($id, $nomorAgenda = null)
    {
        $this->suratMasukId = $id;
        $surat = SuratMasuk::findOrFail($id);
        
        $this->selectedNomorAgenda = $nomorAgenda;
        
        $this->nomor_surat = $surat->nomor_surat;
        $this->pengirim = $surat->pengirim;
        $this->tanggal_surat = $surat->tanggal_surat->format('Y-m-d');
        $this->tanggal_diterima = $surat->tanggal_diterima->format('Y-m-d');
        $this->perihal = $surat->perihal;
        $this->sifat = $surat->sifat;
        $this->tujuan_surat = $surat->tujuan_surat;
        $this->posisi_surat = $surat->posisi_surat;
        $this->existingLampiran = $surat->lampiran;
        $this->lampiran = null; 

        $this->isEditMode = true;
        $this->dispatch('open-modal', name: 'surat-masuk-modal');
    }

    public function save()
    {
        $rules = [
            'nomor_surat' => 'required|string|max:255|unique:surat_masuk,nomor_surat,' . $this->suratMasukId,
            'pengirim' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'tujuan_surat' => 'required|array|min:1',
            'posisi_surat' => 'required|string',
        ];

        if ($this->lampiran) {
            $rules['lampiran'] = 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048';
        }

        $messages = [
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique'   => 'Nomor surat ini sudah pernah digunakan.',
            'pengirim.required' => 'Nama pengirim wajib diisi.',
            'tanggal_surat.required' => 'Tanggal surat wajib dipilih.',
            'tanggal_diterima.required' => 'Tanggal diterima wajib dipilih.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'sifat.required' => 'Sifat surat wajib dipilih.',
            'tujuan_surat.required' => 'Tujuan surat wajib dipilih minimal satu.',
            'posisi_surat.required' => 'Posisi surat saat ini wajib dipilih.',
            'lampiran.mimes' => 'Format lampiran harus PDF, DOC, DOCX, JPG, atau PNG.',
            'lampiran.max' => 'Ukuran lampiran maksimal adalah 2MB.',
        ];

        $this->validate($rules, $messages);

        $data = [
            'nomor_surat' => $this->nomor_surat,
            'pengirim' => $this->pengirim,
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_diterima' => $this->tanggal_diterima,
            'perihal' => $this->perihal,
            'sifat' => $this->sifat,
            'tujuan_surat' => $this->tujuan_surat,
            'posisi_surat' => $this->posisi_surat,
            'user_id' => Auth::id(),
        ];

        if ($this->lampiran) {
            if ($this->isEditMode && $this->existingLampiran) {
                Storage::disk('public')->delete($this->existingLampiran);
            }
            $path = $this->lampiran->store('file_surat', 'public');
            $data['lampiran'] = $path;
        }

        SuratMasuk::updateOrCreate(['id' => $this->suratMasukId], $data);

        $this->dispatch('swal:success', message: $this->isEditMode ? 'Surat berhasil diperbarui.' : 'Surat berhasil ditambahkan.');
        $this->closeModal('surat-masuk-modal');
    }

    public function confirmDelete($id)
    {
        $this->dispatch(
            'swal:confirm',
            id: $id,
            title: 'Anda Yakin?',
            text: 'Data surat masuk yang dihapus tidak dapat dikembalikan!',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
        );
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $surat = SuratMasuk::find($id);
        if ($surat) {
            if ($surat->lampiran) {
                Storage::disk('public')->delete($surat->lampiran);
            }
            $surat->delete();
            $this->dispatch('swal:success', message: 'Surat berhasil dihapus.');
        }
    }
    
    protected function resetForm()
    {
        $this->reset(); 
        $this->selectedNomorAgenda = null;
    }

    public function showDetailModal($id, $nomorAgenda = null)
    {
        $this->selectedNomorAgenda = $nomorAgenda;
        $this->selectedSurat = SuratMasuk::with('user')->findOrFail($id);
        $this->dispatch('open-modal', name: 'detailSuratModal');
    }

    public function closeDetailModal($modalName)
    {
        if ($modalName === 'detailSuratModal') {
            $this->selectedSurat = null;
            $this->selectedNomorAgenda = null; 
        }
        $this->dispatch('close-modal', name: $modalName);
    }
}