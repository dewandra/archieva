<div>
    <div>
    {{-- Atur Judul Halaman --}}
    <x-slot name="title">
        Request Surat
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Request Pengajuan Surat</h2>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahRequestModal">
            <i class="bi bi-plus-circle me-1"></i>
            Buat Request
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="btn-group">
                         <button class="btn btn-primary active">Semua</button>
                         <button class="btn btn-outline-secondary text-my-primary">Menunggu</button>
                         <button class="btn btn-outline-secondary text-my-primary">Disetujui</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Bidang</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Foto Surat</th>
                            <th scope="col">Nomor Surat</th>
                            {{-- KOLOM BARU DITAMBAHKAN --}}
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- CONTOH DATA - DENGAN LOGIKA STATUS --}}

                        {{-- Contoh 1: Status Menunggu --}}
                        <tr>
                            <td class="fw-bold">1</td>
                            <td>pemerintahan</td>
                            <td>08-06-2025</td>
                            <td>
                                <a href="#" title="Lihat Berkas">
                                    <img src="https://placehold.co/100x140/e2e8f0/64748b?text=Berkas" alt="Foto Surat" class="img-thumbnail" width="50">
                                </a>
                            </td>
                            <td class="fw-bold text-primary">-</td>
                            <td>
                                {{-- BADGE UNTUK STATUS MENUNGGU --}}
                                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">
                                    Menunggu
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-light btn-sm text-danger" title="Tolak"><i class="bi bi-x-circle-fill"></i></button>
                                    <button class="btn btn-light btn-sm text-success" title="Setujui"><i class="bi bi-check-circle-fill"></i></button>
                                </div>
                            </td>
                        </tr>

                        {{-- Contoh 2: Status Disetujui --}}
                        <tr>
                            <td class="fw-bold">2</td>
                            <td>pemerintahan</td>
                            <td>07-06-2025</td>
                            <td>
                                 <a href="#" title="Lihat Berkas">
                                    <img src="https://placehold.co/100x140/e2e8f0/64748b?text=Berkas" alt="Foto Surat" class="img-thumbnail" width="50">
                                </a>
                            </td>
                            <td class="fw-bold text-primary">123/A/VI/2025</td>
                            <td>
                                {{-- BADGE UNTUK STATUS DISETUJUI --}}
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                                    Disetujui
                                </span>
                            </td>
                            <td class="text-center">
                                {{-- Aksi disembunyikan jika sudah final --}}
                                <button class="btn btn-light btn-sm" title="Lihat Detail"><i class="bi bi-eye-fill"></i></button>
                            </td>
                        </tr>

                        {{-- Contoh 3: Status Ditolak --}}
                        <tr>
                            <td class="fw-bold">3</td>
                            <td>sarpras</td>
                            <td>06-06-2025</td>
                             <td>
                                 <a href="#" title="Lihat Berkas">
                                    <img src="https://placehold.co/100x140/e2e8f0/64748b?text=Berkas" alt="Foto Surat" class="img-thumbnail" width="50">
                                </a>
                            </td>
                            <td class="fw-bold text-primary">-</td>
                             <td>
                                {{-- BADGE UNTUK STATUS DITOLAK --}}
                                <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">
                                    Ditolak
                                </span>
                            </td>
                            <td class="text-center">
                                 {{-- Aksi disembunyikan jika sudah final --}}
                                <span class="text-muted small">Tidak ada aksi</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{-- Di sini tempat pagination Laravel/Livewire --}}
            </div>
        </div>
    </div>
</div>

{{-- MODAL UNTUK TAMBAH DATA (TETAP SAMA) --}}
<div wire:ignore.self class="modal fade" id="tambahRequestModal" tabindex="-1" aria-labelledby="tambahRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-my-primary text-white">
                <h5 class="modal-title" id="tambahRequestModalLabel">Buat Request Surat Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="createRequest">
                    <div class="mb-3">
                        <label for="bidang" class="form-label">Bidang</label>
                        <input type="text" class="form-control" id="bidang" wire:model="bidang" placeholder="Masukkan nama bidang Anda">
                    </div>
                    <div class="mb-3">
                         <label for="tanggal" class="form-label">Tanggal Pengajuan</label>
                         <input type="date" class="form-control" id="tanggal" wire:model="tanggal">
                    </div>
                    <div class="mb-3">
                         <label for="berkas" class="form-label">Unggah Foto/Berkas Surat (.jpg, .png, .pdf)</label>
                         <input class="form-control" type="file" id="berkas" wire:model="berkas">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" wire:click="createRequest">
                    <i class="bi bi-send-fill me-1"></i> Submit Request
                </button>
            </div>
        </div>
    </div>
</div>
</div>