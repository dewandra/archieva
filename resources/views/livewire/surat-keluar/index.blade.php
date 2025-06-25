<div>
    <x-slot name="title">
        Surat Keluar
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Buku Agenda Surat Keluar</h2>
        <button type="button" class="btn btn-primary shadow-sm" wire:click="showCreateModal">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Data
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <x-surat-keluar.surat-keluar-table :groupedSurat="$groupedSurat" />

            {{-- Link Paginasi --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $paginatedLinks->links() }}
            </div>
        </div>
    </div>

    <x-surat-keluar.surat-keluar-modal :isEditMode="false" />

    {{-- Modal Konfirmasi Hapus --}}
</div>