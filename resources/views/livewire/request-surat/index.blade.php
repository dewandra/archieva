<div>
    <x-slot name="title">Request Surat</x-slot>
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
             <div class="d-flex justify-content-between align-items-center">
                 
                {{-- ========================================================== --}}
                {{-- VERSI 1: FILTER UNTUK DESKTOP --}}
                {{-- Akan tampil di layar medium ke atas (>=768px) --}}
                {{-- ========================================================== --}}
                 <div class="btn-group d-none d-md-block">
                     <button class="btn {{ $filterStatus == 'Semua' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Semua')">Semua</button>
                     <button class="btn {{ $filterStatus == 'Menunggu' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Menunggu')">Menunggu</button>
                     <button class="btn {{ $filterStatus == 'Disetujui' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Disetujui')">Disetujui</button>
                     <button class="btn {{ $filterStatus == 'Ditolak' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Ditolak')">Ditolak</button>
                </div>

                {{-- ========================================================== --}}
                {{-- VERSI 2: FILTER UNTUK MOBILE (DROPDOWN) --}}
                {{-- Akan tampil di layar kecil (<768px) --}}
                {{-- ========================================================== --}}
                <div class="dropdown d-md-none">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel-fill me-1"></i>
                        Filter: <span class="fw-bold">{{ $filterStatus }}</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" wire:click.prevent="$set('filterStatus', 'Semua')">Semua</a></li>
                        <li><a class="dropdown-item" href="#" wire:click.prevent="$set('filterStatus', 'Menunggu')">Menunggu</a></li>
                        <li><a class="dropdown-item" href="#" wire:click.prevent="$set('filterStatus', 'Disetujui')">Disetujui</a></li>
                        <li><a class="dropdown-item" href="#" wire:click.prevent="$set('filterStatus', 'Ditolak')">Ditolak</a></li>
                    </ul>
                </div>

                {{-- Tombol Buat Request (hanya muncul untuk role 'Bidang') --}}
                @if(Auth::user()->role == 2)
                    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahRequestModal">
                        <i class="bi bi-plus-circle d-none d-sm-inline-block"></i> 
                        <span class="d-sm-none"><i class="bi bi-plus-circle"></i></span>
                        <span class="d-none d-sm-inline ms-1">Buat Request</span>
                    </button> 
                @endif
             </div>
        </div>
        <div class="card-body">
            
            {{-- Tampilan Tabel untuk Desktop (Tidak Berubah) --}}
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Pemohon</th>
                            <th scope="col">Tgl. Request</th>
                            <th scope="col">Berkas</th>
                            <th scope="col">No. Surat</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $request)
                        <tr wire:key="desktop-{{ $request->id }}">
                            <td class="fw-bold">{{ $loop->index + $requests->firstItem() }}</td>
                            <td>
                                <div class="fw-bold">{{ $request->user->name }}</div>
                                <div class="text-muted small">{{ $request->bidang }}</div>
                            </td>
                            <td>{{ $request->created_at->isoFormat('D MMM Y, HH:mm') }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $request->berkas) }}" target="_blank" title="Lihat Berkas" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-file-earmark-text"></i> Lihat
                                </a>
                            </td>
                            <td class="fw-bold text-primary">{{ $request->nomor_surat ?? '-' }}</td>
                            <td>
                                @if($request->status == 'Menunggu') 
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Menunggu</span>
                                @elseif($request->status == 'Disetujui') 
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Disetujui</span>
                                @else 
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(in_array(Auth::user()->role, [0, 1]) && $request->status == 'Menunggu')
                                <div class="btn-group">
                                    <button class="btn btn-light btn-sm text-danger" title="Tolak" wire:click.prevent="rejectRequest({{ $request->id }})" wire:confirm="Anda yakin ingin menolak request ini?">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                    <button class="btn btn-light btn-sm text-success" title="Setujui" wire:click="showApproveModal({{ $request->id }})">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                </div>
                                @else 
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty 
                            <tr><td colspan="7" class="text-center p-4">Tidak ada data untuk ditampilkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tampilan Card untuk Mobile (Tidak Berubah) --}}
            <div class="d-md-none">
                @forelse ($requests as $request)
                    <div class="card shadow-sm mb-3" wire:key="mobile-{{ $request->id }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title mb-1">
                                        <span class="fw-bold text-primary me-2">#{{ $loop->index + $requests->firstItem() }}</span>
                                        {{ $request->user->name }}
                                    </h6>
                                    <p class="small text-muted mb-2">{{ $request->bidang }}</p>
                                    @if($request->status == 'Menunggu') 
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Menunggu</span>
                                    @elseif($request->status == 'Disetujui') 
                                        <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Disetujui</span>
                                    @else 
                                        <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Ditolak</span>
                                    @endif
                                </div>
                                @if(in_array(Auth::user()->role, [0, 1]) && $request->status == 'Menunggu')
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item text-success" href="#" wire:click="showApproveModal({{ $request->id }})">
                                                    <i class="bi bi-check-circle-fill me-2"></i>Setujui
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" wire:click.prevent="rejectRequest({{ $request->id }})" wire:confirm="Anda yakin ingin menolak request ini?">
                                                    <i class="bi bi-x-circle-fill me-2"></i>Tolak
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                 <a href="{{ asset('storage/' . $request->berkas) }}" target="_blank" title="Lihat Berkas" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-file-earmark-text"></i> Lihat Berkas
                                </a>
                                <small class="text-muted">{{ $request->created_at->isoFormat('D MMM Y, HH:mm') }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-folder2-open fs-1 text-muted"></i>
                        <p class="mt-2 mb-0 text-muted">Tidak ada data untuk ditampilkan.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-end mt-3">{{ $requests->links() }}</div>
        </div>
    </div>

    {{-- Kode Modal tidak perlu diubah --}}
    <div wire:ignore.self class="modal fade" id="tambahRequestModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content border-0"><div class="modal-header bg-my-primary text-white"><h5 class="modal-title">Buat Request Surat Baru</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><form wire:submit="createRequest"><div class="modal-body"><div class="mb-3"><label for="bidang" class="form-label">Bidang/Keperluan</label><input type="text" class="form-control" id="bidang" wire:model="bidang" placeholder="Contoh: Bidang Pemerintahan">@error('bidang')<span class="text-danger small">{{$message}}</span>@enderror</div><div class="mb-3"><label for="keterangan" class="form-label">Keterangan (Opsional)</label><textarea class="form-control" id="keterangan" wire:model="keterangan" rows="2" placeholder="Info tambahan mengenai surat..."></textarea></div><div class="mb-3"><label for="berkas" class="form-label">Unggah Berkas/Draft Surat</label><input class="form-control" type="file" id="berkas" wire:model="berkas">@error('berkas')<span class="text-danger small">{{$message}}</span>@enderror<div wire:loading wire:target="berkas" class="text-muted small mt-1">Uploading...</div></div></div><div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary"><div wire:loading wire:target="createRequest" class="spinner-border spinner-border-sm me-2"></div><i class="bi bi-send-fill me-1"></i> Submit</button></div></form></div></div></div>
    <div wire:ignore.self class="modal fade" id="approveRequestModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content border-0"><div class="modal-header bg-my-primary text-white"><h5 class="modal-title">Persetujuan & Penomoran Surat</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>@if($selectedRequest)<form wire:submit="approveRequest"><div class="modal-body"><p>Anda akan menyetujui request dari <span class="fw-bold">{{ $selectedRequest->user->name }}</span>. Silakan input nomor surat yang akan diberikan.</p><hr><div class="mb-3"><label for="nomor_surat_baru" class="form-label">Nomor Surat</label><input type="text" class="form-control" id="nomor_surat_baru" wire:model="nomor_surat_baru" placeholder="Contoh: 470/123/PEM">@error('nomor_surat_baru')<span class="text-danger small">{{$message}}</span>@enderror</div><div class="mb-3"><label for="tanggal_disetujui" class="form-label">Tanggal Surat</label><input type="date" class="form-control" id="tanggal_disetujui" wire:model="tanggal_disetujui">@error('tanggal_disetujui')<span class="text-danger small">{{$message}}</span>@enderror</div></div><div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success"><div wire:loading wire:target="approveRequest" class="spinner-border spinner-border-sm me-2"></div><i class="bi bi-check-circle-fill me-1"></i> Setujui & Simpan</button></div></form>@endif</div></div></div>
</div>