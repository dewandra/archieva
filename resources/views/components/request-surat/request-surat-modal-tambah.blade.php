<div wire:ignore.self class="modal fade" id="tambahRequestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-my-primary text-white">
                <h5 class="modal-title">Buat Request Surat Baru</h5><button type="button"
                    class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form wire:submit="createRequest">
                <div class="modal-body">
                    <div class="mb-3"><label for="bidang" class="form-label">Bidang/Keperluan</label><input
                            type="text" class="form-control" id="bidang" wire:model="bidang"
                            placeholder="Contoh: Bidang Pemerintahan">
                        @error('bidang')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3"><label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="keterangan" wire:model="keterangan" rows="2"
                            placeholder="Info tambahan mengenai surat..."></textarea>
                    </div>
                    <div class="mb-3"><label for="berkas" class="form-label">Unggah Berkas/Draft
                            Surat</label><input class="form-control" type="file" id="berkas"
                            wire:model="berkas">
                        @error('berkas')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                        <div wire:loading wire:target="berkas" class="text-muted small mt-1">
                            Uploading...</div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">
                        <div wire:loading wire:target="createRequest"
                            class="spinner-border spinner-border-sm me-2"></div><i
                            class="bi bi-send-fill me-1"></i> Submit
                    </button></div>
            </form>
        </div>
    </div>
</div>