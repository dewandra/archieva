<?php

namespace App\Livewire\SuratMasuk;

use App\Livewire\Traits\WithModal;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Surat Masuk')]
class Index extends Component
{

    use WithPagination, WithModal, WithFileUploads;

    public $suratMasukId;
    public $isEditMode = false;
    public $search = '';

    // Properti untuk form, di-bind ke view
    #[Rule('required|string|max:255')]
    public $nomor_surat;

    #[Rule('required|string|max:255')]
    public $pengirim;

    #[Rule('required|date')]
    public $tanggal_surat;

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

    #[Rule('nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048')] // 2MB Max
    public $lampiran;

    public $existingLampiran; // Untuk menyimpan path file lama saat edit

    public ?SuratMasuk $selectedSurat = null;

    protected $paginationTheme = 'bootstrap';
     public function render()
    {
        $query = SuratMasuk::with('user');

        if ($this->search) {
            $query->where('perihal', 'like', '%' . $this->search . '%')
                  ->orWhere('nomor_surat', 'like', '%' . $this->search . '%')
                  ->orWhere('pengirim', 'like', '%' . $this->search . '%');
        }

        $allSuratMasuk = $query->latest()->paginate(5);

        return view('livewire.surat-masuk.index', [
            'allSuratMasuk' => $allSuratMasuk
        ]);
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        // Inisialisasi tanggal dengan hari ini
        $this->tanggal_diterima = now()->format('Y-m-d');
        $this->dispatch('open-modal', name: 'surat-masuk-modal');
    }

    public function showEditModal($id)
    {
        $this->suratMasukId = $id;
        $surat = SuratMasuk::findOrFail($id);
        
        $this->nomor_surat = $surat->nomor_surat;
        $this->pengirim = $surat->pengirim;
        $this->tanggal_surat = $surat->tanggal_surat->format('Y-m-d');
        $this->tanggal_diterima = $surat->tanggal_diterima->format('Y-m-d');
        $this->perihal = $surat->perihal;
        $this->sifat = $surat->sifat;
        $this->tujuan_surat = $surat->tujuan_surat;
        $this->posisi_surat = $surat->posisi_surat;
        $this->existingLampiran = $surat->lampiran;
        $this->lampiran = null; // Reset input file

        $this->isEditMode = true;
        $this->dispatch('open-modal', name: 'surat-masuk-modal');
    }

    public function save()
    {
        // Aturan validasi dinamis
        $rules = [
            'nomor_surat' => 'required|string|max:255|unique:surat_masuk,nomor_surat,' . $this->suratMasukId,
            'pengirim' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'tujuan_surat' => 'nullable|array',
            'posisi_surat' => 'nullable|string',
        ];

        // Validasi lampiran hanya jika ada file baru atau saat membuat data baru
        if ($this->lampiran) {
            $rules['lampiran'] = 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048';
        }

        $this->validate($rules);

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
            // Hapus file lama jika sedang dalam mode edit dan ada file lama
            if ($this->isEditMode && $this->existingLampiran) {
                Storage::disk('public')->delete($this->existingLampiran);
            }
            // Simpan file baru
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
            // Hapus file lampiran dari storage jika ada
            if ($surat->lampiran) {
                Storage::disk('public')->delete($surat->lampiran);
            }
            $surat->delete();
            $this->dispatch('swal:success', message: 'Surat berhasil dihapus.');
        }
    }
    
    // resetForm() dipanggil oleh trait WithModal
    protected function resetForm()
    {
        $this->reset(); // Mereset semua properti publik
    }

    public function showDetailModal($id)
    {
        $this->selectedSurat = SuratMasuk::with('user')->findOrFail($id);

        $this->dispatch('open-modal', name: 'detailSuratModal');
    }

    public function closeDetailModal($modalName)
    {
        if ($modalName === 'detailSuratModal') {
            $this->selectedSurat = null;
        }
        $this->dispatch('close-modal', name: $modalName);
    }
}
