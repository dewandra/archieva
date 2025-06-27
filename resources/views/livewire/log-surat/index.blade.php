{{-- File: resources/views/livewire/log-surat/index.blade.php --}}
<div>
    <x-slot name="title">
        Log Surat
    </x-slot>

    {{-- ========================================================================= --}}
    {{-- VERSI 1: HEADER UNTUK TAMPILAN DESKTOP (AKAN MUNCUL DI LAYAR BESAR) --}}
    {{-- ========================================================================= --}}
    <div class="d-none d-md-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Buku Agenda Log Surat</h2>
        <a href="{{ route('print.log-surat', ['date' => $currentDate->format('Y-m-d')]) }}" target="_blank" class="btn btn-primary shadow-sm">
            <i class="bi bi-printer-fill me-1"></i>
            Cetak Halaman Ini
        </a>
    </div>

    {{-- ========================================================================= --}}
    {{-- VERSI 2: HEADER UNTUK TAMPILAN MOBILE (AKAN MUNCUL DI LAYAR KECIL) --}}
    {{-- ========================================================================= --}}
    <div class="d-flex d-md-none justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Buku Agenda Log Surat</h5>
        <a href="{{ route('print.log-surat', ['date' => $currentDate->format('Y-m-d')]) }}" target="_blank" class="btn btn-primary btn-sm">
            <i class="bi bi-printer-fill me-1"></i>
            <span class="d-none d-sm-inline">Cetak</span>
        </a>
    </div>


    {{-- KONTEN CARD (TIDAK ADA PERUBAHAN) --}}
    <div class="card border-0 shadow-sm">
        {{-- HEADER CARD: Navigasi Tanggal --}}
        <div class="card-header bg-light border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <button wire:click="changeDate('previous')" class="btn btn-outline-secondary btn-sm" title="Hari Sebelumnya">
                    <i class="bi bi-caret-left-fill"></i>
                </button>

                <div class="text-center">
                    <h6 class="mb-0">{{ $currentDate->isoFormat('dddd, D MMMM Y') }}</h6>
                    <input type="date" class="form-control form-control-sm mt-1 mx-auto" style="width: auto;"
                           value="{{ $currentDate->format('Y-m-d') }}"
                           wire:change="setDate($event.target.value)">
                </div>

                <button wire:click="changeDate('next')" class="btn btn-outline-secondary btn-sm" title="Hari Berikutnya" @if($currentDate->isToday()) disabled @endif>
                    <i class="bi bi-caret-right-fill"></i>
                </button>
            </div>
        </div>

        {{-- BODY CARD: Memanggil komponen tabel --}}
        <div class="card-body">
            <x-log-surat.log-surat-table :logs="$logs" />
        </div>

        {{-- FOOTER CARD: Paginasi Data Log --}}
        @if($logs->hasPages())
        <div class="card-footer bg-light border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
            </div>
        </div>
        @endif
    </div>
</div>