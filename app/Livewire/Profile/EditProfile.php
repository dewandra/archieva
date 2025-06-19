<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    // Properti untuk form, di-bind ke view
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $image; // Untuk upload file baru
    public $existingImage; // Untuk menampilkan gambar lama

    // Method `mount` berjalan saat komponen pertama kali dimuat
    // Kita gunakan untuk mengisi form dengan data user saat ini
    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->existingImage = $user->image;
    }

    // Method ini akan dipanggil saat form disubmit
    public function updateProfile()
    {
        $user = auth()->user();

        // Aturan validasi
        $rules = [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|max:1024', // 1MB Max
        ];

        // Hanya validasi password jika diisi
        if (!empty($this->password)) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

        // Update data dasar
        $user->name = $this->name;
        $user->email = $this->email;
        
        // Proses upload gambar baru jika ada
        if ($this->image) {
            // Hapus gambar lama jika ada
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            // Simpan gambar baru dan update path
            $user->image = $this->image->store('userPhotos', 'public');
            $this->existingImage = $user->image; // Update properti untuk tampilan
        }

        // Proses update password jika diisi
        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // Reset field password agar tidak tersimpan
        $this->reset(['password', 'password_confirmation']);
        
        // Kirim notifikasi sukses
        $this->dispatch('swal:success', message: 'Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.profile.index');
    }
}
