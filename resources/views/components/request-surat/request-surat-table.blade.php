@props(['requests'])

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
                        <a href="{{ asset('storage/' . $request->berkas) }}" target="_blank"
                            title="Lihat Berkas" class="btn btn-sm btn-outline-dark">
                            <i class="bi bi-file-earmark-text"></i> Lihat
                        </a>
                    </td>
                    <td class="fw-bold text-primary">{{ $request->nomor_surat ?? '-' }}</td>
                    <td>
                        @if ($request->status == 'Menunggu')
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Menunggu</span>
                        @elseif($request->status == 'Disetujui')
                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill">Disetujui</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Ditolak</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            @if (in_array(Auth::user()->role, [0, 1]) && $request->status == 'Menunggu')
                                <button class="btn btn-light btn-sm text-danger" title="Tolak"
                                    wire:click.prevent="rejectRequest({{ $request->id }})"
                                    wire:confirm="Anda yakin ingin menolak request ini?">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                                <button class="btn btn-light btn-sm text-success" title="Setujui"
                                    wire:click="showApproveModal({{ $request->id }})">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            @endif
                            
                            {{-- PASTIKAN BAGIAN INI SUDAH BENAR --}}
                            @if(in_array(Auth::user()->role, [0, 1]))
                                <button class="btn btn-light btn-sm text-danger" title="Hapus Permanen"
                                    wire:click="confirmDelete({{ $request->id }})">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center p-4">Tidak ada data untuk ditampilkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>