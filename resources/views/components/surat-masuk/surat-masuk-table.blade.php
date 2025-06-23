@props(['allSuratMasuk'])

<div class="table-responsive">
    <table class="table table-borderless table-hover align-middle">
        <tbody>
            @forelse ($allSuratMasuk as $surat)
                <tr wire:key="{{ $surat->id }}">
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
                        <button class="btn btn-light btn-sm" title="Edit" wire:click="showEditModal({{ $surat->id }})">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-light btn-sm" title="Detail" data-bs-toggle="modal" data-bs-target="#detailSuratModal" wire:click="showDetailModal({{ $surat->id }})">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button class="btn btn-light btn-sm text-danger" title="Hapus" wire:click="confirmDelete({{ $surat->id }})">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">
                        Tidak ada data surat masuk ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-end mt-2">
    {{ $allSuratMasuk->links() }}
</div>