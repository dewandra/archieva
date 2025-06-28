@props(['allSuratMasuk'])

{{-- ============================================================= --}}
{{--                              DEKSTOP                          --}}
{{-- ============================================================= --}}
<div class="d-none d-md-block">
    <div class="table-responsive">
        <table class="table table-borderless table-hover align-middle">
            <tbody>
                @forelse ($allSuratMasuk as $surat)
                    <tr wire:key="desktop-{{ $surat->id }}">
                        <td class="fw-bold" style="width: 5%;">{{ $loop->index + $allSuratMasuk->firstItem() }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary-subtle text-primary-emphasis me-3">
                                    <i class="bi bi-envelope-paper-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">No. Surat: {{ $surat->nomor_surat }}</div>
                                    <div class="text-muted small">Perihal: {{ Str::limit($surat->perihal, 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $surat->pengirim }}</div>
                            <div class="text-muted small">Diterima: {{ $surat->tanggal_diterima->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $surat->sifat }}</span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-light btn-sm" title="Edit" wire:click="showEditModal({{ $surat->id }}, {{ $loop->index + $allSuratMasuk->firstItem() }})">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-light btn-sm" title="Detail" data-bs-toggle="modal" data-bs-target="#detailSuratModal" wire:click="showDetailModal({{ $surat->id }}, {{ $loop->index + $allSuratMasuk->firstItem() }})">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                            <button class="btn btn-light btn-sm text-danger" title="Hapus" wire:click="confirmDelete({{ $surat->id }})">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            Tidak ada data surat masuk ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- ============================================================= --}}
{{--                               MOBILE                          --}}
{{-- ============================================================= --}}
<div class="d-block d-md-none">
    @forelse ($allSuratMasuk as $surat)
        <div class="card shadow-sm mb-3" wire:key="mobile-{{ $surat->id }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    {{-- Informasi Utama --}}
                    <div>
                        <h6 class="card-title mb-1">
                            <span class="fw-bold text-primary me-2">#{{ $loop->index + $allSuratMasuk->firstItem() }}</span>
                            {{ $surat->perihal }}
                        </h6>
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill mb-2">{{ $surat->sifat }}</span>
                        <p class="small text-muted mb-0">
                            <i class="bi bi-send-fill"></i> Dari: {{ $surat->pengirim }}
                        </p>
                         <p class="small text-muted mb-0">
                            <i class="bi bi-box-arrow-in-down"></i> Diterima: {{ $surat->tanggal_diterima->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Tombol Aksi dalam Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#detailSuratModal" wire:click="showDetailModal({{ $surat->id }}, {{ $loop->index + $allSuratMasuk->firstItem() }})"><i class="bi bi-eye-fill me-2"></i>Detail</a></li>
                            <li><a class="dropdown-item" href="#" wire:click="showEditModal({{ $surat->id }}, {{ $loop->index + $allSuratMasuk->firstItem() }})"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" wire:click="confirmDelete({{ $surat->id }})"><i class="bi bi-trash3-fill me-2"></i>Hapus</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-folder2-open fs-1 text-muted"></i>
            <p class="mt-2 mb-0 text-muted">Tidak ada data surat ditemukan.</p>
        </div>
    @endforelse
</div>


{{-- Paginasi akan tetap muncul di bawah --}}
<div class="d-flex justify-content-end mt-2">
    {{ $allSuratMasuk->links() }}
</div>