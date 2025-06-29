<div wire:ignore.self class="modal fade" id="approveRequestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-my-primary text-white">
                <h5 class="modal-title">Persetujuan & Penomoran Surat</h5><button type="button"
                    class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            @if ($selectedRequest)
                <form wire:submit="approveRequest">
                    <div class="modal-body">
                        <p>Anda akan menyetujui request dari <span
                                class="fw-bold">{{ $selectedRequest->user->name }}</span>. Silakan input nomor
                            surat yang akan diberikan.</p>
                        <hr>
                        <div class="mb-3"><label for="nomor_surat_baru" class="form-label">Nomor
                                Surat</label><input type="text" class="form-control" id="nomor_surat_baru"
                                wire:model="nomor_surat_baru" placeholder="Contoh: 470/123/PEM">
                            @error('nomor_surat_baru')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3"><label for="tanggal_disetujui" class="form-label">Tanggal
                                Surat</label><input type="date" class="form-control" id="tanggal_disetujui"
                                wire:model="tanggal_disetujui">
                            @error('tanggal_disetujui')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success">
                            <div wire:loading wire:target="approveRequest"
                                class="spinner-border spinner-border-sm me-2"></div><i
                                class="bi bi-check-circle-fill me-1"></i> Setujui & Simpan
                        </button></div>
                </form>
            @endif
        </div>
    </div>
</div>