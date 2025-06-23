<div>
    {{-- Atur Judul Halaman --}}
    <x-slot name="title">
        Surat Masuk
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Surat Masuk</h2>
        <button type="button" class="btn btn-primary shadow-sm" wire:click="showCreateModal">
            <i class="bi bi-envelope-plus-fill me-1"></i>
            Tambah Surat Masuk
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="search" wire:model.live.debounce.300ms="search"
                            class="form-control border-start-0" placeholder="Cari perihal, nomor, atau pengirim...">
                    </div>
                </div>
                {{-- Anda bisa menambahkan filter di sini jika perlu --}}
            </div>
        </div>
        <div class="card-body">
            {{-- Panggil komponen tabel --}}
            <x-surat-masuk.surat-masuk-table :allSuratMasuk="$allSuratMasuk" />
        </div>
    </div>

    {{-- Panggil komponen modal (tidak akan terlihat sampai dipicu) --}}
    <x-surat-masuk.surat-masuk-modal :isEditMode="$isEditMode" />

    <x-surat-masuk.surat-masuk-detail-modal :surat="$selectedSurat" />

    {{-- Konfirmasi Hapus --}}
</div>

{{-- Tambahkan sedikit style untuk icon circle --}}
@push('styles')
    <style>
        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }
        .icon-circle .bi {
            font-size: 1.2rem;
        }
    </style>
@endpush