@props(['groupedSurat'])

@if($groupedSurat->isNotEmpty())
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 g-4">
        
        @foreach ($groupedSurat as $tanggal => $items)
            <div class="col">
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-light text-center fw-bold">
                        {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}
                    </div>
                    <div class="card-body p-0">
                        {{-- 
                            PERBAIKAN 1: 
                            Wrapper <div class="table-responsive"> DIHAPUS.
                            Ini akan mencegah scrollbar horizontal muncul.
                        --}}
                        <table class="table table-sm table-hover mb-0">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-3" style="width: 15%;">No</th>
                                    <th style="width: 50%;">Klasifikasi</th>
                                    <th style="width: 20%;">Pencatat</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr wire:key="{{ $item->id }}" style="vertical-align: middle;">
                                        <td class="ps-3 fw-bold">{{ $item->nomor_surat }}</td>
                                        {{-- 
                                            PERBAIKAN 2: 
                                            Menambahkan style "word-break: break-all;" pada kolom Klasifikasi.
                                            Ini akan memaksa teks panjang untuk turun ke baris berikutnya.
                                        --}}
                                        <td style="word-break: break-all;">{{ $item->klasifikasi }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">
                                                {{ $item->user?->name }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-light btn-sm" title="Edit" wire:click="showEditModal({{ $item->id }})">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button class="btn btn-light btn-sm text-danger" title="Hapus" wire:click="confirmDelete({{ $item->id }})">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center p-5">
        <i class="bi bi-journal-x fs-1 text-muted"></i>
        <p class="text-muted mt-2">Belum ada data surat keluar yang tercatat.</p>
    </div>
@endif