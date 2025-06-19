@props([
    'isEditMode' => false,
    'image' => null,
    'existingImage' => null,
])

<div wire:ignore.self class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userModalLabel">
                    {{ $isEditMode ? 'Edit Role Pengguna' : 'Tambah Pengguna Baru' }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            {{-- Ganti form submit untuk memanggil method yang benar --}}
            <form wire:submit.prevent="{{ $isEditMode ? 'updateRole' : 'save' }}">
                <div class="modal-body">
                    {{-- Input Nama: disable saat edit --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" wire:model="name" @if($isEditMode) disabled @endif>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    {{-- Input Email: disable saat edit --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" wire:model="email" @if($isEditMode) disabled @endif>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    {{-- Input Role: SELALU AKTIF --}}
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" wire:model="role">
                            <option value="">Pilih Role</option>
                            <option value="0">Admin</option>
                            <option value="1">Arsip</option>
                            <option value="2">Bidang</option>
                        </select>
                        @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- Hanya tampilkan input gambar dan password saat mode TAMBAH --}}
                    @if (!$isEditMode)
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Profil</label>
                            <input type="file" class="form-control" id="image" wire:model="image">
                            @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                            {{-- ... preview gambar ... --}}
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" wire:model="password">
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" wire:model="password_confirmation">
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="{{ $isEditMode ? 'updateRole' : 'save' }}" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>