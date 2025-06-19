<div>
    <x-slot name="title">
        Edit Profil
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Pengaturan Profil</h2>
    </div>

    <div class="card border-0 shadow-sm">
        <form wire:submit.prevent="updateProfile">
            <div class="card-body">
                <div class="row">
                    {{-- Kolom Kiri: Informasi Pribadi & Role --}}
                    <div class="col-md-8">
                        <h5 class="mb-4">Informasi Pribadi</h5>
                        
                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" wire:model="email">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Role (Ditampilkan tapi tidak bisa diubah) --}}
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" id="role" 
                                   value="@if(auth()->user()->role == 0) Admin @elseif(auth()->user()->role == 1) Arsip @else Bidang @endif" 
                                   disabled readonly>
                            <div class="form-text">Role tidak dapat diubah melalui halaman ini.</div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-4">Ubah Password</h5>
                        <p class="text-muted small">Kosongkan jika Anda tidak ingin mengubah password.</p>

                        {{-- Password Baru --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" wire:model="password">
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        {{-- Konfirmasi Password Baru --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" wire:model="password_confirmation">
                        </div>
                    </div>

                    {{-- Kolom Kanan: Foto Profil --}}
                    <div class="col-md-4">
                        <h5 class="mb-3">Foto Profil</h5>
                        <div class="text-center">
                            {{-- Logic untuk menampilkan preview gambar --}}
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-thumbnail rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                            @elseif ($existingImage)
                                <img src="{{ asset('storage/' . $existingImage) }}" alt="Current Image" class="img-thumbnail rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('img/default.png') }}" alt="Default Avatar" class="img-thumbnail rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                            @endif

                            <div wire:loading wire:target="image" class="text-muted small my-2">Uploading...</div>
                            
                            <label for="image" class="btn btn-sm btn-secondary">
                                Ganti Foto
                            </label>
                            <input type="file" class="d-none" id="image" wire:model="image">
                            @error('image') <span class="text-danger d-block small mt-2">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary">
                    <span wire:loading wire:target="updateProfile" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>