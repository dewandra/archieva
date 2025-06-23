<div>
    {{-- Atur Judul Halaman --}}
    <x-slot name="title">
        Surat Masuk
    </x-slot>

    {{-- =================================================================
    BAGIAN 1: TAMPILAN UTAMA (TABEL SURAT MASUK) - REDESIGNED
    ================================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Surat Masuk</h2>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahSuratModal">
            <i class="bi bi-envelope-plus-fill me-1"></i>
            Tambah Surat Masuk
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="search" wire:model.live.debounce.300ms="search"
                            class="form-control border-start-0" placeholder="Cari perihal atau nomor surat...">
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btn btn-primary active">Semua</button>
                    <button class="btn btn-outline-secondary text-my-primary">Penting</button>
                    <button class="btn btn-outline-secondary text-my-primary">Arsip</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle">
                    {{-- Thead tidak perlu ditampilkan untuk desain ini --}}
                    <tbody>
                        {{-- CONTOH DATA - Ganti dengan perulangan @foreach --}}
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-primary-subtle text-primary-emphasis me-3">
                                        <i class="bi bi-envelope-paper-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">No. Surat: 1231</div>
                                        <div class="text-muted small">Perihal: Corrupti nulla sunt</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">PT B</div>
                                <div class="text-muted small">Diterima: 08/06/2025</div>
                            </td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Sangat
                                    Penting</span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-light btn-sm" title="Edit"
                                    wire:click="edit({{-- $surat->id --}})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-light btn-sm" title="Detail" data-bs-toggle="modal"
                                    data-bs-target="#detailSuratModal" wire:click="showDetail({{-- $surat->id --}})">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <button class="btn btn-light btn-sm text-danger" title="Hapus"
                                    wire:click="confirmDelete({{-- $surat->id --}})">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-success-subtle text-success-emphasis me-3">
                                        <i class="bi bi-envelope-paper-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">No. Surat: 122</div>
                                        <div class="text-muted small">Perihal: Ullam tempor ut vel</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">PT A</div>
                                <div class="text-muted small">Diterima: 07/06/2025</div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Biasa</span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-light btn-sm" title="Edit"><i
                                        class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-sm" title="Detail" data-bs-toggle="modal"
                                    data-bs-target="#detailSuratModal"><i class="bi bi-eye-fill"></i></button>
                                <button class="btn btn-light btn-sm text-danger" title="Hapus"><i
                                        class="bi bi-trash3-fill"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-2">
                {{-- Di sini tempat pagination Laravel/Livewire --}}
                {{-- $suratMasuk->links() --}}
            </div>
        </div>
    </div>

    {{-- =================================================================
    BAGIAN 2: MODAL UNTUK TAMBAH DATA SURAT - REDESIGNED
    ================================================================== --}}
    <div wire:ignore.self class="modal fade" id="tambahSuratModal" tabindex="-1"
        aria-labelledby="tambahSuratModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-my-primary text-white">
                    <h5 class="modal-title" id="tambahSuratModalLabel">Formulir Surat Masuk Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        {{-- INFORMASI UTAMA --}}
                        <h6 class="text-muted">Informasi Utama</h6>
                        <hr class="mt-2">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomorSurat" class="form-label">Nomor Surat</label>
                                <input type="text" class="form-control" id="nomorSurat" wire:model="nomorSurat"
                                    placeholder="Contoh: 123/ABC/VI/2025">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pengirim" class="form-label">Pengirim</label>
                                <input type="text" class="form-control" id="pengirim" wire:model="pengirim"
                                    placeholder="Nama instansi/perorangan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggalSurat" class="form-label">Tanggal Surat</label>
                                <input type="date" class="form-control" id="tanggalSurat"
                                    wire:model="tanggalSurat">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggalDiterima" class="form-label">Tanggal Diterima</label>
                                <input type="date" class="form-control" id="tanggalDiterima"
                                    wire:model="tanggalDiterima">
                            </div>
                        </div>

                        {{-- DETAIL SURAT --}}
                        <h6 class="text-muted mt-3">Detail Surat</h6>
                        <hr class="mt-2">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="perihal" class="form-label">Perihal</label>
                                <textarea class="form-control" id="perihal" rows="2" wire:model="perihal"
                                    placeholder="Subjek atau inti dari surat"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sifat" class="form-label">Sifat Surat</label>
                                <select class="form-select" id="sifat" wire:model="sifat">
                                    <option selected>Pilih sifat surat...</option>
                                    <option value="Biasa">Biasa</option>
                                    <option value="Penting">Penting</option>
                                    <option value="Sangat Penting">Sangat Penting</option>
                                    <option value="Rahasia">Rahasia</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fileSurat" class="form-label">Lampiran File (PDF, DOC, JPG)</label>
                                <input class="form-control" type="file" id="fileSurat" wire:model="fileSurat">
                            </div>
                        </div>

                         {{-- DISPOSISI --}}
                    <h6 class="text-muted mt-3">Disposisi Awal</h6>
                    <hr class="mt-2">
                    <div class="row">
                        {{-- BAGIAN DITUJUKAN KE (MULTI-PILIHAN) --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ditujukan Ke</label>
                            <div class="p-3 border rounded" style="max-height: 200px; overflow-y: auto;">
                                {{-- DAFTAR CHECKBOX --}}
                                <div class="form-check">
                                    {{-- UBAH: type="radio" menjadi "checkbox" --}}
                                    <input class="form-check-input" type="checkbox" value="TU" id="dest_tu" wire:model="ditujukanKe">
                                    <label class="form-check-label" for="dest_tu">TU</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Penyusunan Program" id="dest_program" wire:model="ditujukanKe">
                                    <label class="form-check-label" for="dest_program">Penyusunan Program</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Keuangan" id="dest_keuangan" wire:model="ditujukanKe">
                                    <label class="form-check-label" for="dest_keuangan">Keuangan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Pembangunan Ekonomi" id="dest_pembangunan" wire:model="ditujukanKe">
                                    <label class="form-check-label" for="dest_pembangunan">Pembangunan Ekonomi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Kemasyarakatan" id="dest_kemasyarakatan" wire:model="ditujukanKe">
                                    <label class="form-check-label" for="dest_kemasyarakatan">Kemasyarakatan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Sarana Prasarana" id="dest_sarana" wire:model="ditujukanKe">
                                    <label class="form-check-label" for="dest_sarana">Sarana Prasarana</o>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Semua Bidang" id="dest_semua" wire:model="ditujukanKe">
                                    <label class="form-check-label" for="dest_semua">Semua Bidang</label>
                                </div>
                            </div>
                        </div>

                        {{-- BARU: BAGIAN POSISI SURAT (PILIHAN TUNGGAL) --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Posisi Surat</label>
                            <div class="p-3 border rounded">
                                {{-- DAFTAR RADIO BUTTON --}}
                                <div class="form-check">
                                    {{-- INFO: type="radio" dan wire:model yang sama untuk satu pilihan --}}
                                    <input class="form-check-input" type="radio" name="posisiSuratGroup" value="AE" id="pos_ae" wire:model="posisiSurat">
                                    <label class="form-check-label" for="pos_ae">AE</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="posisiSuratGroup" value="OTU" id="pos_otu" wire:model="posisiSurat">
                                    <label class="form-check-label" for="pos_otu">OTU</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="posisiSuratGroup" value="SEKBN" id="pos_sekbn" wire:model="posisiSurat">
                                    <label class="form-check-label" for="pos_sekbn">SEKBN</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="posisiSuratGroup" value="KABAN" id="pos_kaban" wire:model="posisiSurat">
                                    <label class="form-check-label" for="pos_kaban">KABAN</label>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="save"><i
                            class="bi bi-check-circle me-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- =================================================================
    BAGIAN 3: MODAL UNTUK DETAIL SURAT - REDESIGNED
    ================================================================== --}}
    <div wire:ignore.self class="modal fade" id="detailSuratModal" tabindex="-1"
        aria-labelledby="detailSuratModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-light border-bottom">
                    <div>
                        <h5 class="modal-title" id="detailSuratModalLabel">Detail Surat</h5>
                        <small class="text-muted">Nomor Surat: 1231</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-7">
                            <h6 class="text-primary">PERIHAL</h6>
                            <p class="h5 mb-4">Corrupti nulla sunt.</p>

                            <h6 class="text-primary">DETAIL</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150px"><i class="bi bi-person-fill me-2 text-muted"></i> Pengirim</td>
                                    <td>: PT B</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event-fill me-2 text-muted"></i> Tgl. Surat</td>
                                    <td>: 16 April 1986</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-check-fill me-2 text-muted"></i> Tgl. Diterima</td>
                                    <td>: 26 Agustus 1993</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-lock-fill me-2 text-muted"></i> Sifat</td>
                                    <td>: <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Sangat
                                            Penting</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <h6 class="text-primary">LAMPIRAN</h6>
                            <div class="border rounded p-3 text-center">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-1"></i>
                                <p class="mb-2 mt-2">nama_file_surat.pdf</p>
                                <a href="#" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-download me-2"></i> Download Lampiran
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-primary">DISPOSISI</h6>
                    <p>Surat ini telah didisposisikan ke bagian: <strong>Pemerintahan</strong>.</p>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary"><i class="bi bi-printer me-1"></i> Cetak Lembar
                        Disposisi</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan sedikit style untuk icon circle --}}
@push('styles')
    <style>
        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }

        .icon-circle .bi {
            font-size: 1.2rem;
        }
    </style>
@endpush
