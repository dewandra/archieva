<div>
    {{-- Atur Judul Halaman --}}
    <x-slot name="title">
        Surat Keluar
    </x-slot>

    {{-- =================================================================
    BAGIAN 1: TAMPILAN UTAMA (DAFTAR KENDALI) - REDESIGNED
    ================================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Buku Agenda Surat Keluar</h2>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahSuratKeluarModal">
            <i class="bi bi-send-plus-fill me-1"></i>
            Buat Lembar Kendali
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
             <div class="d-flex justify-content-between align-items-center">
                <div class="col-md-4">
                     <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control border-start-0" placeholder="Cari berdasarkan klasifikasi atau tujuan...">
                    </div>
                </div>
                <div class="text-muted small">Menampilkan 2 Lembar Kendali</div>
            </div>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                {{-- CONTOH DATA - Ganti dengan perulangan @foreach dari data lembar kendali Anda --}}
                
                {{-- Item Lembar Kendali 1 --}}
                <div class="list-group-item py-3 px-2">
                    <div class="row align-items-start">
                        <div class="col-md-2 text-center">
                            <i class="bi bi-calendar3 text-primary h5"></i>
                            <div class="fw-bold">08 Juni 2025</div>
                            <small class="text-muted">ID: SK-001</small>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-sm table-borderless">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>NO. URUT</th>
                                        <th>KLASIFIKASI SURAT</th>
                                        <th>TUJUAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Optio eu est</td>
                                        <td>PT. Jaya Abadi</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Elit sed eu</td>
                                        <td>Dinas Pendidikan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2 text-end">
                             <div class="btn-group">
                                <button class="btn btn-light btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-sm text-danger" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Akhir Item 1 --}}

                {{-- Item Lembar Kendali 2 --}}
                 <div class="list-group-item py-3 px-2">
                    <div class="row align-items-start">
                        <div class="col-md-2 text-center">
                            <i class="bi bi-calendar3 text-primary h5"></i>
                            <div class="fw-bold">07 Juni 2025</div>
                            <small class="text-muted">ID: SK-002</small>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-sm table-borderless">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>NO. URUT</th>
                                        <th>KLASIFIKASI SURAT</th>
                                        <th>TUJUAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>12</td>
                                        <td>123sda</td>
                                        <td>Kementrian Keuangan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2 text-end">
                             <div class="btn-group">
                                <button class="btn btn-light btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-light btn-sm text-danger" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Akhir Item 2 --}}
            </div>
             <div class="d-flex justify-content-end mt-3">
                {{-- Di sini tempat pagination Laravel/Livewire --}}
            </div>
        </div>
    </div>

    {{-- =================================================================
    BAGIAN 2: MODAL TAMBAH SURAT KELUAR - DYNAMIC & REDESIGNED
    ================================================================== --}}
    <div wire:ignore.self class="modal fade" id="tambahSuratKeluarModal" tabindex="-1" aria-labelledby="tambahSuratKeluarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-my-primary text-white">
                    <h5 class="modal-title" id="tambahSuratKeluarModalLabel">Buat Lembar Kendali Surat Keluar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" x-data="{ letters: [{no_urut: '', klas: '', tujuan: ''}] }">
                    <form wire:submit.prevent="saveSuratKeluar">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pembuatan</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <hr>
                        
                        <template x-for="(letter, index) in letters" :key="index">
                            <fieldset class="border rounded-3 p-3 mb-3 position-relative">
                                <legend class="fs-6 px-2 w-auto">
                                    <span class="fw-bold">Surat Ke-</span><span x-text="index + 1"></span>
                                </legend>

                                <button type="button" x-show="letters.length > 1" @click="letters.splice(index, 1)" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 me-3 mt-1" title="Hapus isian ini">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">No. Urut</label>
                                        <input type="text" class="form-control" x-model="letter.no_urut" placeholder="No.">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Klasifikasi</label>
                                        <input type="text" class="form-control" x-model="letter.klas" placeholder="Klasifikasi/Perihal singkat...">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Tujuan Surat</label>
                                        <input type="text" class="form-control" x-model="letter.tujuan" placeholder="Ditujukan kepada...">
                                    </div>
                                </div>
                            </fieldset>
                        </template>

                        <button type="button" @click="letters.push({no_urut: '', klas: '', tujuan: ''})" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle-dotted"></i> Tambah Isian Surat Lagi
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="saveSuratKeluar(letters)"><i class="bi bi-check-circle me-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>