<div>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center w-100">

                {{-- Filter Desktop --}}
                <div class="btn-group d-none d-md-block">
                    <button class="btn {{ $filterStatus == 'Semua' ? 'btn-primary' : 'btn-outline-secondary' }}"
                        wire:click="$set('filterStatus', 'Semua')">Semua</button>
                    <button class="btn {{ $filterStatus == 'Menunggu' ? 'btn-primary' : 'btn-outline-secondary' }}"
                        wire:click="$set('filterStatus', 'Menunggu')">Menunggu</button>
                    <button class="btn {{ $filterStatus == 'Disetujui' ? 'btn-primary' : 'btn-outline-secondary' }}"
                        wire:click="$set('filterStatus', 'Disetujui')">Disetujui</button>
                    <button class="btn {{ $filterStatus == 'Ditolak' ? 'btn-primary' : 'btn-outline-secondary' }}"
                        wire:click="$set('filterStatus', 'Ditolak')">Ditolak</button>
                </div>

                {{-- Filter Mobile --}}
                <div class="dropdown d-md-none">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-funnel-fill me-1"></i>
                        Filter: <span class="fw-bold">{{ $filterStatus }}</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"
                                wire:click.prevent="$set('filterStatus', 'Semua')">Semua</a></li>
                        <li><a class="dropdown-item" href="#"
                                wire:click.prevent="$set('filterStatus', 'Menunggu')">Menunggu</a></li>
                        <li><a class="dropdown-item" href="#"
                                wire:click.prevent="$set('filterStatus', 'Disetujui')">Disetujui</a></li>
                        <li><a class="dropdown-item" href="#"
                                wire:click.prevent="$set('filterStatus', 'Ditolak')">Ditolak</a></li>
                    </ul>
                </div>

                {{-- Tombol Buat Request (hanya muncul untuk role 'Bidang') --}}
                @if (Auth::user()->role == 2)
                    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#tambahRequestModal">
                        <i class="bi bi-plus-circle d-none d-sm-inline-block"></i>
                        <span class="d-sm-none"><i class="bi bi-plus-circle"></i></span>
                        <span class="d-none d-sm-inline ms-1">Buat Request</span>
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body">
            
            <x-request-surat.request-surat-table :requests="$requests" />
            <x-request-surat.request-surat-cards :requests="$requests" />

            <div class="d-flex justify-content-end mt-3">{{ $requests->links() }}</div>
        </div>
    </div>

    {{-- Panggil komponen modal --}}
    <x-request-surat.request-surat-modal-tambah />
    <x-request-surat.request-surat-modal-approve :selectedRequest="$selectedRequest" />
</div>