<div>
    <div class="card border-0 shadow-sm">
        {{-- Header Card Baru dengan Filter dan Tombol --}}
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="row align-items-center gy-3">
                {{-- Kolom Filter --}}
                <div class="col-md-8 d-flex align-items-center gap-2">
                    <span class="text-muted small me-2">Filter:</span>
                    {{-- Filter Tahun --}}
                    <div style="width: 120px;">
                        <select wire:model.live="filterTahun" class="form-select form-select-sm">
                            <option value="">Semua Tahun</option>
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Filter Bulan --}}
                    <div style="width: 140px;">
                        <select wire:model.live="filterBulan" class="form-select form-select-sm">
                            <option value="">Semua Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>
                            @endfor
                        </select>
                    </div>
                    {{-- Filter Sifat --}}
                    <div style="width: 160px;">
                        <select wire:model.live="filterSifat" class="form-select form-select-sm">
                            <option value="">Semua Sifat</option>
                            <option value="Biasa">Biasa</option>
                            <option value="Penting">Penting</option>
                            <option value="Sangat Penting">Sangat Penting</option>
                            <option value="Rahasia">Rahasia</option>
                        </select>
                    </div>
                </div>

                {{-- Kolom Pencarian --}}
                <div class="col-md-4">
                     <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="search" wire:model.live.debounce.300ms="search" class="form-control border-start-0" placeholder="Cari perihal, nomor, atau pengirim...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- Panggil komponen tabel (tidak perlu diubah) --}}
            <x-surat-masuk.surat-masuk-table :allSuratMasuk="$allSuratMasuk" />
        </div>
        <div class="card-footer bg-white border-0 py-3">
             <button type="button" class="btn btn-primary shadow-sm w-100" wire:click="showCreateModal">
                <i class="bi bi-envelope-plus-fill me-1"></i>
                Tambah Surat Masuk Baru
            </button>
        </div>
    </div>

    {{-- komponen modal--}}
    <x-surat-masuk.surat-masuk-modal :isEditMode="$isEditMode" />
    <x-surat-masuk.surat-masuk-detail-modal :surat="$selectedSurat" :nomorAgenda="$selectedNomorAgenda"/>
</div>

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