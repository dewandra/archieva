<div>
    {{-- Atur Judul Halaman Sesuai Pola Sebelumnya --}}
    <x-slot name="title">
        List Users
    </x-slot>

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Manajemen Pengguna</h2>
        {{-- Tombol Tambah Users --}}
        <button type="button" class="btn btn-primary shadow-sm" wire:click="showCreateModal">
            <i class="bi bi-person-plus-fill me-1"></i>
            Tambah User
        </button>
    </div>

    {{-- Konten Utama dalam Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="col-md-4">
                <input type="search" class="form-control" placeholder="Cari nama atau email pengguna..."
                    wire:model.live.debounce.300ms="search">
            </div>
        </div>
        <div class="card-body">
            <x-list-user.list-user-table :users="$users" />
        </div>
    </div>

    <x-list-user.list-user-modal :isEditMode="$isEditMode" :image="$image" :existingImage="$existingImage" />
</div>
