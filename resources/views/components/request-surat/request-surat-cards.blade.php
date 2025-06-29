@props(['requests'])

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
                        @if ($request->status == 'Menunggu')
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Menunggu</span>
                        @elseif($request->status == 'Disetujui')
                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Disetujui</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Ditolak</span>
                        @endif
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if (in_array(Auth::user()->role, [0, 1]) && $request->status == 'Menunggu')
                                <li><a class="dropdown-item text-success" href="#" wire:click="showApproveModal({{ $request->id }})"><i class="bi bi-check-circle-fill me-2"></i>Setujui</a></li>
                                <li><a class="dropdown-item text-warning" href="#" wire:click.prevent="rejectRequest({{ $request->id }})" wire:confirm="Anda yakin ingin menolak request ini?"><i class="bi bi-x-circle-fill me-2"></i>Tolak</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            
                            {{-- PASTIKAN BAGIAN INI SUDAH BENAR --}}
                            @if(in_array(Auth::user()->role, [0, 1]))
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                    wire:click.prevent="confirmDelete({{ $request->id }})">
                                    <i class="bi bi-trash3-fill me-2"></i>Hapus Permanen
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
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