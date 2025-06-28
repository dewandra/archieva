@props(['isEditMode' => false])
{{-- MODAL UNTUK TAMBAH / EDIT DATA --}}
    <div wire:ignore.self class="modal fade" id="surat-keluar-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <form wire:submit.prevent="save">
                    <div class="modal-header bg-my-primary text-white">
                        <h5 class="modal-title">
                            {{ $isEditMode ? 'Edit Data Surat Keluar' : 'Tambah Data Surat Keluar' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" wire:model="tanggal">
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor</label>
                            <input type="number" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" wire:model.lazy="nomor_surat" placeholder="Contoh: 01, 35, 68...">
                             @error('nomor_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="klasifikasi" class="form-label">Klasifikasi</label>
                            <input type="text" class="form-control @error('klasifikasi') is-invalid @enderror" id="klasifikasi" wire:model="klasifikasi" placeholder="Klasifikasi atau perihal singkat...">
                            @error('klasifikasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm"></span>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>