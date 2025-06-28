{{-- File: resources/views/livewire/surat-keluar/partials/filters.blade.php --}}

{{-- Tampilan Desktop --}}
<div class="row align-items-center gy-3 d-none d-md-flex">
    <div class="col-md-9 d-flex align-items-center gap-2">
        <span class="text-muted small me-2">Filter:</span>
        <div style="width: 120px;">
            <select wire:model.live="filterTahun" class="form-select form-select-sm"><option value="">Semua Tahun</option>@foreach ($availableYears as $year)<option value="{{ $year }}">{{ $year }}</option>@endforeach</select>
        </div>
        <div style="width: 140px;">
            <select wire:model.live="filterBulan" class="form-select form-select-sm"><option value="">Semua Bulan</option>@for ($i = 1; $i <= 12; $i++)<option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>@endfor</select>
        </div>
        <div class="input-group input-group-sm ms-2" style="width: 250px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="search" wire:model.live.debounce.300ms="search" class="form-control border-start-0" placeholder="Cari nomor/klasifikasi...">
        </div>
    </div>
    <div class="col-md-3 text-md-end">
        <button type="button" class="btn btn-primary btn-sm shadow-sm" wire:click="showCreateModal"><i class="bi bi-plus-circle me-1"></i>Tambah Data</button>
    </div>
</div>

{{-- Tampilan Mobile --}}
<div class="row align-items-center gy-3 d-flex d-md-none">
    <div class="col-12"><div class="row g-2"><div class="col-6"><select wire:model.live="filterTahun" class="form-select form-select-sm"><option value="">Semua Tahun</option>@foreach ($availableYears as $year)<option value="{{ $year }}">{{ $year }}</option>@endforeach</select></div><div class="col-6"><select wire:model.live="filterBulan" class="form-select form-select-sm"><option value="">Semua Bulan</option>@for ($i = 1; $i <= 12; $i++)<option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}</option>@endfor</select></div></div></div>
    <div class="col-12"><div class="input-group input-group-sm"><span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span><input type="search" wire:model.live.debounce.300ms="search" class="form-control border-start-0" placeholder="Cari nomor atau klasifikasi..."></div></div>
    <div class="col-12"><div class="d-grid"><button type="button" class="btn btn-primary btn-sm shadow-sm" wire:click="showCreateModal"><i class="bi bi-plus-circle me-1"></i>Tambah Data</button></div></div>
</div>