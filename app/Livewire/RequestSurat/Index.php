<?php

namespace App\Livewire\RequestSurat;

use App\Models\LogSurat;
use App\Models\RequestSurat;
use App\Models\User;
use App\Notifications\NewRequestSurat;
use App\Notifications\RequestApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On; 
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads, WithPagination;

    public $bidang, $berkas, $keterangan, $selectedRequest, $filterStatus = 'Semua';
    public $nomor_surat_baru, $tanggal_disetujui;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $query = RequestSurat::with(['user', 'approver'])->latest();
        if ($this->filterStatus !== 'Semua') {
            $query->where('status', $this->filterStatus);
        }
        if (Auth::user()->role == 2) {
            $query->where('user_id', Auth::id());
        }
        return view('livewire.request-surat.index', ['requests' => $query->paginate(10)]);
    }

    public function createRequest()
    {
        $rules = [
            'bidang' => 'required|string|max:255',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ];

        $messages = [
            'bidang.required' => 'Bidang atau keperluan wajib diisi.',
            'berkas.required' => 'Anda wajib mengunggah berkas atau draft surat.',
            'berkas.mimes'    => 'Format berkas harus PDF, JPG, atau PNG.',
            'berkas.max'      => 'Ukuran berkas maksimal adalah 2MB.',
        ];

        $validated = $this->validate($rules, $messages);

        $validated['berkas'] = $this->berkas->store('berkas_request', 'public');
        $validated['user_id'] = Auth::id();
        $newRequest = RequestSurat::create($validated);
        $receivers = User::whereIn('role', [0, 1])->get();
        Notification::send($receivers, new NewRequestSurat($newRequest));
        $this->dispatch('swal:success', message: 'Request berhasil dikirim.');
        $this->dispatch('close-modal', name: 'tambahRequestModal');
        $this->reset(['bidang', 'berkas', 'keterangan']);
    }

    public function showApproveModal($requestId)
    {
        $this->selectedRequest = RequestSurat::findOrFail($requestId);
        $this->tanggal_disetujui = now()->format('Y-m-d');
        $this->dispatch('open-modal', name: 'approveRequestModal');
    }

    public function approveRequest()
    {
        $rules = [
            'nomor_surat_baru' => 'required|string|max:255|unique:request_surats,nomor_surat',
            'tanggal_disetujui' => 'required|date',
        ];

        $messages = [
            'nomor_surat_baru.required' => 'Nomor surat wajib diisi.',
            'nomor_surat_baru.unique'   => 'Nomor surat ini sudah pernah digunakan.',
            'tanggal_disetujui.required' => 'Tanggal persetujuan wajib diisi.',
        ];

        $this->validate($rules, $messages);

        $this->selectedRequest->update([
            'status' => 'Disetujui',
            'nomor_surat' => $this->nomor_surat_baru,
            'tanggal_disetujui' => $this->tanggal_disetujui,
            'approved_by_user_id' => Auth::id(),
        ]);

        LogSurat::create([
            'request_surat_id' => $this->selectedRequest->id,
            'user_id' => Auth::id(), // Petugas yang menyetujui
            'nomor_surat' => $this->nomor_surat_baru,
            'tanggal_arsip' => now(), // Tanggal saat ini
            'bidang' => $this->selectedRequest->bidang,
        ]);

        $requester = $this->selectedRequest->user;
        if ($requester) {
            $requester->notify(new RequestApproved($this->selectedRequest));
        }
        $this->dispatch('swal:success', message: 'Request berhasil disetujui.');
        $this->dispatch('close-modal', name: 'approveRequestModal');
        $this->reset(['nomor_surat_baru', 'tanggal_disetujui', 'selectedRequest']);
    }

    public function rejectRequest($requestId)
    {
        $request = RequestSurat::findOrFail($requestId);
        $request->update(['status' => 'Ditolak', 'approved_by_user_id' => Auth::id()]);
        $this->dispatch('swal:success', message: 'Request telah ditolak.');
    }

    /**
     * 2. Method ini dipanggil oleh tombol hapus untuk MEMICU event SweetAlert.
     */
    public function confirmDelete($requestId)
    {
        $this->dispatch('swal:confirm-delete', requestId: $requestId);
    }

    /**
     * 3. Method ini HANYA akan dieksekusi setelah ada konfirmasi dari SweetAlert.
     * Atribut #[On] berfungsi sebagai listener event dari frontend.
     */
     #[On('delete-request-confirmed')]
    public function deleteRequest(int $requestId)
    {
        if (!in_array(Auth::user()->role, [0, 1])) {
            $this->dispatch('swal:error', message: 'Aksi tidak diizinkan.');
            return;
        }

        $request = RequestSurat::find($requestId); 

        if ($request) {
            if ($request->berkas) {
                Storage::disk('public')->delete($request->berkas);
            }

            $request->delete();

            $this->dispatch('swal:success', message: 'Request surat berhasil dihapus permanen.');
        } else {
             $this->dispatch('swal:error', message: 'Data tidak ditemukan.');
        }
    }
}