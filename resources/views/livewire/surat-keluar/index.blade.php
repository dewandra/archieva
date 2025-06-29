<div>
    <x-slot name="title">
        Surat Keluar
    </x-slot>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            {{-- Tata letak responsif untuk filter dan tombol --}}
            @include('livewire.partials.filters')
        </div>
        <div class="card-body">
            @if($groupedSurat->isNotEmpty())
                <x-surat-keluar.surat-keluar-table :groupedSurat="$groupedSurat" />
            @else
                <div class="text-center p-5">
                    <i class="bi bi-journal-x fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Tidak ada data surat keluar yang ditemukan.</p>
                </div>
            @endif

            {{-- ====================================================== --}}
            {{-- PAGINASI MANUAL --}}
            {{-- ====================================================== --}}
            @if($totalDates > $perPage)
            <div class="d-flex justify-content-end mt-4">
                <nav>
                    <ul class="pagination">
                        {{-- Tombol Previous --}}
                        <li class="page-item @if($page <= 1) disabled @endif">
                            <a class="page-link" href="#" wire:click.prevent="previousPage">‹</a>
                        </li>

                        {{-- Tombol Halaman --}}
                        @for ($i = 1; $i <= ceil($totalDates / $perPage); $i++)
                            <li class="page-item @if($page == $i) active @endif">
                                <a class="page-link" href="#" wire:click.prevent="goToPage({{ $i }})">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Tombol Next --}}
                        <li class="page-item @if($page >= ceil($totalDates / $perPage)) disabled @endif">
                            <a class="page-link" href="#" wire:click.prevent="nextPage">›</a>
                        </li>
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>

    <x-surat-keluar.surat-keluar-modal :isEditMode="$isEditMode" />
</div>