<div>
    <x-slot name="title">Request Surat</x-slot>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Pengajuan Surat</h2>
        @if(Auth::user()->role == 2) <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahRequestModal"><i class="bi bi-plus-circle me-1"></i> Buat Request</button> @endif
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
             <div class="btn-group">
                 <button class="btn {{ $filterStatus == 'Semua' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Semua')">Semua</button>
                 <button class="btn {{ $filterStatus == 'Menunggu' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Menunggu')">Menunggu</button>
                 <button class="btn {{ $filterStatus == 'Disetujui' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Disetujui')">Disetujui</button>
                 <button class="btn {{ $filterStatus == 'Ditolak' ? 'btn-primary' : 'btn-outline-secondary' }}" wire:click="$set('filterStatus', 'Ditolak')">Ditolak</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive"><table class="table table-hover align-middle">
                <thead class="text-muted small text-uppercase"><tr><th scope="col">#</th><th scope="col">Pemohon</th><th scope="col">Tgl. Request</th><th scope="col">Berkas</th><th scope="col">No. Surat</th><th scope="col">Status</th><th scope="col" class="text-center">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($requests as $request)
                    <tr wire:key="{{ $request->id }}">
                        <td class="fw-bold">{{ $loop->index + $requests->firstItem() }}</td>
                        <td><div class="fw-bold">{{ $request->user->name }}</div><div class="text-muted small">{{ $request->bidang }}</div></td>
                        <td>{{ $request->created_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                        <td><a href="{{ asset('storage/' . $request->berkas) }}" target="_blank" title="Lihat Berkas" class="btn btn-sm btn-outline-dark"><i class="bi bi-file-earmark-text"></i> Lihat</a></td>
                        <td class="fw-bold text-primary">{{ $request->nomor_surat ?? '-' }}</td>
                        <td>
                            @if($request->status == 'Menunggu') <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Menunggu</span>
                            @elseif($request->status == 'Disetujui') <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Disetujui</span>
                            @else <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(in_array(Auth::user()->role, [0, 1]) && $request->status == 'Menunggu')
                            <div class="btn-group"><button class="btn btn-light btn-sm text-danger" title="Tolak" wire:click.prevent="rejectRequest({{ $request->id }})" wire:confirm="Anda yakin ingin menolak request ini?"><i class="bi bi-x-circle-fill"></i></button><button class="btn btn-light btn-sm text-success" title="Setujui" wire:click="showApproveModal({{ $request->id }})"><i class="bi bi-check-circle-fill"></i></button></div>
                            @else <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty <tr><td colspan="7" class="text-center p-4">Tidak ada data untuk ditampilkan.</td></tr>
                    @endforelse
                </tbody>
            </table></div>
            <div class="d-flex justify-content-end mt-3">{{ $requests->links() }}</div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="tambahRequestModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content border-0"><div class="modal-header bg-my-primary text-white"><h5 class="modal-title">Buat Request Surat Baru</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><form wire:submit="createRequest"><div class="modal-body"><div class="mb-3"><label for="bidang" class="form-label">Bidang/Keperluan</label><input type="text" class="form-control" id="bidang" wire:model="bidang" placeholder="Contoh: Bidang Pemerintahan">@error('bidang')<span class="text-danger small">{{$message}}</span>@enderror</div><div class="mb-3"><label for="keterangan" class="form-label">Keterangan (Opsional)</label><textarea class="form-control" id="keterangan" wire:model="keterangan" rows="2" placeholder="Info tambahan mengenai surat..."></textarea></div><div class="mb-3"><label for="berkas" class="form-label">Unggah Berkas/Draft Surat</label><input class="form-control" type="file" id="berkas" wire:model="berkas">@error('berkas')<span class="text-danger small">{{$message}}</span>@enderror<div wire:loading wire:target="berkas" class="text-muted small mt-1">Uploading...</div></div></div><div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary"><div wire:loading wire:target="createRequest" class="spinner-border spinner-border-sm me-2"></div><i class="bi bi-send-fill me-1"></i> Submit</button></div></form></div></div></div>
    <div wire:ignore.self class="modal fade" id="approveRequestModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content border-0"><div class="modal-header bg-my-primary text-white"><h5 class="modal-title">Persetujuan & Penomoran Surat</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>@if($selectedRequest)<form wire:submit="approveRequest"><div class="modal-body"><p>Anda akan menyetujui request dari <span class="fw-bold">{{ $selectedRequest->user->name }}</span>. Silakan input nomor surat yang akan diberikan.</p><hr><div class="mb-3"><label for="nomor_surat_baru" class="form-label">Nomor Surat</label><input type="text" class="form-control" id="nomor_surat_baru" wire:model="nomor_surat_baru" placeholder="Contoh: 470/123/PEM">@error('nomor_surat_baru')<span class="text-danger small">{{$message}}</span>@enderror</div><div class="mb-3"><label for="tanggal_disetujui" class="form-label">Tanggal Surat</label><input type="date" class="form-control" id="tanggal_disetujui" wire:model="tanggal_disetujui">@error('tanggal_disetujui')<span class="text-danger small">{{$message}}</span>@enderror</div></div><div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success"><div wire:loading wire:target="approveRequest" class="spinner-border spinner-border-sm me-2"></div><i class="bi bi-check-circle-fill me-1"></i> Setujui & Simpan</button></div></form>@endif</div></div></div>
</div>