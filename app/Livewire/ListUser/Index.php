<?php

namespace App\Livewire\ListUser;

use App\Livewire\Traits\WithModal;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithModal, WithFileUploads;

    // Properti untuk form
    #[Rule('required|string|min:3')]
    public $name;

    #[Rule('required|email')]
    public $email;

    #[Rule('nullable|min:8|confirmed')]
    public $password;
    public $password_confirmation;

    #[Rule('required|integer')]
    public $role;

    // TAMBAHKAN PROPERTI BARU DI SINI
    #[Rule('nullable|image|max:1024')] // 1MB Max, bisa diubah
    public $image;
    

    // Properti untuk state
    public $userId;
    public $isEditMode = false;
    public $search = '';
    public $existingImage;
    // Menggunakan tema pagination Bootstrap
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $users = User::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })->latest()->paginate(5); // Mengambil 5 data per halaman

        return view('livewire.list-user.index', [
            'users' => $users
        ]);
    }
    // Method untuk menampilkan modal create
    public function showCreateModal()
    {
        // Panggil method dari Trait
        $this->showCreateModalHook('user-modal');
    }
    
    // Method untuk menampilkan modal edit
    public function showEditModal($id)
    {
        // Panggil method dari Trait
        $this->showEditModalHook('user-modal');

        $this->userId = $id;
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->existingImage = $user->image; // Simpan gambar lama untuk validasi
        $this->image = null;
    }

    // Method untuk menyimpan data (Create & Update)
    public function save()
{
    $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email,' . $this->userId,
        'role' => 'required|integer',
    ];

    if (!$this->isEditMode || !empty($this->password)) {
        $rules['password'] = 'required|min:8|confirmed';
    }

    $this->validate($rules);

    $data = [
        'name' => $this->name,
        'email' => $this->email,
        'role' => $this->role,
    ];

    if ($this->image) {
        $path = $this->image->store('userPhotos', 'public');
        $data['image'] = $path;
    }

    if (!empty($this->password)) {
        $data['password'] = Hash::make($this->password);
    }

    User::updateOrCreate(['id' => $this->userId], $data);

    // KOMA SUDAH DITAMBAHKAN DI SINI
    $this->dispatch(
        'swal:success', 
        message: $this->isEditMode ? 'User berhasil diperbarui.' : 'User berhasil ditambahkan.'
    );

    $this->closeModal('user-modal');
}

    // METHOD BARU: Khusus untuk update role
    public function updateRole()
    {
        // 1. Validasi hanya field 'role'
        $this->validate([
            'role' => 'required|integer',
        ]);

        // 2. Cari user berdasarkan userId yang sudah disimpan
        $user = User::findOrFail($this->userId);

        // 3. Update hanya kolom 'role'
        $user->update([
            'role' => $this->role,
        ]);

        // 4. Kirim notifikasi sukses
        $this->dispatch('swal:success', 
            message: 'Role pengguna berhasil diperbarui.'
        );

        // 5. Tutup modal
        $this->closeModal('user-modal');
    }
     public function confirmDelete($id)
    {
        $this->dispatch(
            'swal:confirm',
            id     : $id,
            title   : 'Anda Yakin?', // <-- Teks judul yang akan dikirim
            text    : 'Data pengguna yang dihapus tidak dapat dikembalikan!', // <-- Teks deskripsi
            confirmButtonText : 'Ya, hapus!',
            cancelButtonText : 'Batal',
        );
    }

    // GANTI SELURUH METHOD delete($data) YANG LAMA DENGAN INI
    #[On('destroy')]
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            
            $user->delete();

            // Dispatch notifikasi sukses (ini sudah benar)
            $this->dispatch(
                'swal:success',
                message: 'User berhasil dihapus.'
            );
        }
    }
    // Method untuk mereset form
    protected function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'userId', 'isEditMode']);
    }
    
}
