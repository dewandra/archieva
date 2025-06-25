<?php

namespace App\Livewire\SuratKeluar;

use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Surat Keluar')]
class Index extends Component
{

    use WithPagination;

    public $suratId, $tanggal, $nomor_surat, $klasifikasi;
    public $isEditMode = false;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Ambil 3 tanggal unik terbaru, lalu paginasi
        $distinctDates = SuratKeluar::select('tanggal')
            ->distinct()
            ->orderBy('tanggal', 'asc')
            ->paginate(3);

        // Ambil semua item surat yang tanggalnya ada di halaman paginasi saat ini
        // Eager load relasi 'user' untuk efisiensi query
        $suratItems = SuratKeluar::with('user')
            ->whereIn('tanggal', $distinctDates->pluck('tanggal'))
            ->orderBy('nomor_surat', 'asc')
            ->get();

        // Kelompokkan data berdasarkan tanggal untuk membuat struktur grid
        $groupedSurat = $suratItems->groupBy(fn ($item) => $item->tanggal->format('Y-m-d'));

        return view('livewire.surat-keluar.index',[
            'groupedSurat' => $groupedSurat,
            'paginatedLinks' => $distinctDates,
        ]);
    }

        // Menampilkan modal untuk membuat data baru
    public function showCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->tanggal = now()->format('Y-m-d');
        $this->dispatch('open-modal', name: 'surat-keluar-modal');
    }

    // Menampilkan modal untuk mengedit data
    public function showEditModal($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $this->suratId = $surat->id;
        $this->tanggal = $surat->tanggal->format('Y-m-d');
        $this->nomor_surat = $surat->nomor_surat;
        $this->klasifikasi = $surat->klasifikasi;
        $this->isEditMode = true;
        $this->dispatch('open-modal', name: 'surat-keluar-modal');
    }

    // Menyimpan data (Create & Update)
    public function save()
    {
        $rules = [
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|numeric|min:0|max:100',
            'klasifikasi' => 'required|string|max:255',
        ];

        $rules['nomor_surat'] .= '|unique:surat_keluars,nomor_surat,' . $this->suratId . ',id,tanggal,' . $this->tanggal;

        $this->validate($rules);

        SuratKeluar::updateOrCreate(
            ['id' => $this->suratId],
            [
                'tanggal' => $this->tanggal,
                'nomor_surat' => str_pad($this->nomor_surat, 2, '0', STR_PAD_LEFT),
                'klasifikasi' => $this->klasifikasi,
                'user_id' => Auth::id(), // Simpan ID user yang sedang login
            ]
        );

        $this->dispatch('swal:success', message: $this->isEditMode ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.');
        $this->dispatch('close-modal', name: 'surat-keluar-modal');
    }

    // Konfirmasi hapus data
    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', id: $id, title: 'Anda Yakin?', text: 'Data surat yang dihapus tidak dapat dikembalikan!', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal');
    }

    // Proses hapus data
    #[On('destroy')]
    public function destroy($id)
    {
        SuratKeluar::find($id)->delete();
        $this->dispatch('swal:success', message: 'Data berhasil dihapus.');
    }

    // Reset properti form
    private function resetForm()
    {
        $this->reset(['suratId', 'isEditMode', 'tanggal', 'nomor_surat', 'klasifikasi']);
    }
}