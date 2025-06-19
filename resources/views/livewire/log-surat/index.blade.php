<div>
    {{-- Atur Judul Halaman --}}
    <x-slot name="title">
        Log Surat
    </x-slot>

    {{-- =================================================================
    BAGIAN 1: TAMPILAN UTAMA (TABEL KENDALI FINAL)
    ================================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Log Surat Tercatat</h2>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Data
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control border-start-0" placeholder="Cari nomor surat atau nama petugas...">
                    </div>
                </div>
                <div>
                    <button class="btn btn-outline-secondary" type="button" title="Cetak Laporan">
                        <i class="bi bi-printer me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nomor Surat</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Bidang</th>
                            <th scope="col">Petugas</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Contoh data --}}
                        <tr>
                            <td class="fw-bold">1</td>
                            <td class="fw-bold text-primary">12312312312</td>
                            <td>08-05-2025</td>
                            <td><span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Pemerintahan</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://i.pravatar.cc/150?u=joko" alt="Avatar" class="rounded-circle me-2" width="35" height="35">
                                    <span>joko</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-light btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-light btn-sm text-danger" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                            </td>
                        </tr>
                        {{-- ... baris data lainnya ... --}}
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{-- Pagination --}}
            </div>
        </div>
    </div>

    {{-- =================================================================
    BAGIAN 2: MODAL SEKARANG BERADA DI DALAM ROOT ELEMENT
    ================================================================== --}}
    <div wire:ignore.self class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header bg-my-primary text-white">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Log Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label for="nomorSurat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" id="nomorSurat" wire:model="nomorSurat">
                        </div>
                        <div class="mb-3">
                            <label for="tanggalSurat" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggalSurat" wire:model="tanggalSurat">
                        </div>
                        <div class="mb-3">
                            <label for="bidang" class="form-label">Bidang</label>
                            <input type="text" class="form-control" id="bidang" wire:model="bidang">
                        </div>
                        <div class="mb-3">
                            <label for="petugas" class="form-label">Petugas</label>
                            <input type="text" class="form-control" id="petugas" wire:model="petugas">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="save"><i class="bi bi-check-circle me-1"></i> Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

</div> 