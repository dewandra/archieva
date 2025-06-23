@props(['isEditMode' => false])

<div wire:ignore.self class="modal fade" id="surat-masuk-modal" tabindex="-1" aria-labelledby="suratMasukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-my-primary text-white">
                <h5 class="modal-title" id="suratMasukModalLabel">
                    {{ $isEditMode ? 'Edit Formulir Surat Masuk' : 'Formulir Surat Masuk Baru' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="save">
                    {{-- INFORMASI UTAMA --}}
                    <h6 class="text-muted">Informasi Utama</h6>
                    <hr class="mt-2">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" id="nomor_surat" wire:model="nomor_surat" placeholder="Contoh: 123/ABC/VI/2025">
                            @error('nomor_surat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pengirim" class="form-label">Pengirim</label>
                            <input type="text" class="form-control" id="pengirim" wire:model="pengirim" placeholder="Nama instansi/perorangan">
                             @error('pengirim') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control" id="tanggal_surat" wire:model="tanggal_surat">
                            @error('tanggal_surat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_diterima" class="form-label">Tanggal Diterima</label>
                            <input type="date" class="form-control" id="tanggal_diterima" wire:model="tanggal_diterima">
                            @error('tanggal_diterima') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- DETAIL SURAT --}}
                    <h6 class="text-muted mt-3">Detail Surat</h6>
                    <hr class="mt-2">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="perihal" class="form-label">Perihal</label>
                            <textarea class="form-control" id="perihal" rows="2" wire:model="perihal" placeholder="Subjek atau inti dari surat"></textarea>
                            @error('perihal') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sifat" class="form-label">Sifat Surat</label>
                            <select class="form-select" id="sifat" wire:model="sifat">
                                <option value="">Pilih sifat surat...</option>
                                <option value="Biasa">Biasa</option>
                                <option value="Penting">Penting</option>
                                <option value="Sangat Penting">Sangat Penting</option>
                                <option value="Rahasia">Rahasia</option>
                            </select>
                            @error('sifat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lampiran" class="form-label">Lampiran File (PDF / DOC)</label>
                            <input class="form-control" type="file" id="lampiran" wire:model="lampiran">
                            @error('lampiran') <span class="text-danger small">{{ $message }}</span> @enderror
                            <div wire:loading wire:target="lampiran" class="text-muted small">Uploading...</div>
                        </div>
                    </div>

                    {{-- DISPOSISI --}}
                    <h6 class="text-muted mt-3">Disposisi Awal</h6>
                    <hr class="mt-2">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ditujukan Ke</label>
                            @error('tujuan_surat') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                            <div class="p-3 border rounded" style="max-height: 200px; overflow-y: auto;">
                                <div class="form-check"><input class="form-check-input" type="checkbox" value="TU" id="dest_tu" wire:model="tujuan_surat"><label class="form-check-label" for="dest_tu">TU</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" value="Penyusunan Program" id="dest_program" wire:model="tujuan_surat"><label class="form-check-label" for="dest_program">Penyusunan Program</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" value="Keuangan" id="dest_keuangan" wire:model="tujuan_surat"><label class="form-check-label" for="dest_keuangan">Keuangan</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" value="Pembangunan Ekonomi" id="dest_pembangunan" wire:model="tujuan_surat"><label class="form-check-label" for="dest_pembangunan">Pembangunan Ekonomi</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" value="Kemasyarakatan" id="dest_kemasyarakatan" wire:model="tujuan_surat"><label class="form-check-label" for="dest_kemasyarakatan">Kemasyarakatan</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" value="Sarana Prasarana" id="dest_sarana" wire:model="tujuan_surat"><label class="form-check-label" for="dest_sarana">Sarana Prasarana</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" value="Semua Bidang" id="dest_semua" wire:model="tujuan_surat"><label class="form-check-label" for="dest_semua">Semua Bidang</label></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Posisi Surat</label>
                            @error('posisi_surat') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                            <div class="p-3 border rounded">
                                <div class="form-check"><input class="form-check-input" type="radio" name="posisiSuratGroup" value="AE" id="pos_ae" wire:model="posisi_surat"><label class="form-check-label" for="pos_ae">AE</label></div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="posisiSuratGroup" value="OTU" id="pos_otu" wire:model="posisi_surat"><label class="form-check-label" for="pos_otu">OTU</label></div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="posisiSuratGroup" value="SEKBN" id="pos_sekbn" wire:model="posisi_surat"><label class="form-check-label" for="pos_sekbn">SEKBN</label></div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="posisiSuratGroup" value="KABAN" id="pos_kaban" wire:model="posisi_surat"><label class="form-check-label" for="pos_kaban">KABAN</label></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" wire:click="save">
                    <span wire:loading wire:target="save" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>