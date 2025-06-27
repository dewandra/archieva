{{-- File: resources/views/components/log-surat/log-surat-table.blade.php --}}
@props(['logs'])

{{-- ======================================================= --}}
{{-- 1. TAMPILAN UNTUK DESKTOP (TABLE) - d-none d-md-block --}}
{{--    Akan disembunyikan di layar kecil (mobile)        --}}
{{-- ======================================================= --}}
<div class="table-responsive d-none d-md-block">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th scope="col" style="width: 5%;">#</th>
                <th scope="col">Nomor Surat</th>
                <th scope="col">Bidang</th>
                <th scope="col">Petugas Arsip</th>
                <th scope="col" class="text-end">Waktu Arsip</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr wire:key="desktop-{{ $log->id }}">
                    <td class="fw-bold text-center">{{ $logs->firstItem() + $loop->index }}</td>
                    <td>{{ $log->nomor_surat }}</td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $log->bidang }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($log->user)
                                <img src="{{ $log->user->image ? asset('storage/' . $log->user->image) : asset('img/default.png') }}" alt="Avatar" class="rounded-circle me-2" width="35" height="35" style="object-fit: cover;">
                                <span>{{ $log->user->name }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-end text-muted small">{{ $log->created_at->format('H:i') }} WIB</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="bi bi-journal-x fs-1 text-muted"></i>
                        <p class="mt-2 mb-0 text-muted">Tidak ada data log pada tanggal ini.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{-- ========================================================= --}}
{{-- 2. TAMPILAN UNTUK MOBILE (CARDS) - d-block d-md-none   --}}
{{--    Hanya akan muncul di layar kecil (mobile)           --}}
{{-- ========================================================= --}}
<div class="d-block d-md-none">
    @forelse ($logs as $log)
        <div class="card shadow-sm mb-3" wire:key="mobile-{{ $log->id }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title mb-1">{{ $log->nomor_surat }}</h6>
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill mb-2">{{ $log->bidang }}</span>
                    </div>
                    <span class="text-muted small">{{ $log->created_at->format('H:i') }}</span>
                </div>
                <hr class="my-2">
                <div class="d-flex align-items-center">
                    @if($log->user)
                        <img src="{{ $log->user->image ? asset('storage/' . $log->user->image) : asset('img/default.png') }}" alt="Avatar" class="rounded-circle me-2" width="30" height="30" style="object-fit: cover;">
                        <small class="text-muted">Diarsip oleh: {{ $log->user->name }}</small>
                    @else
                        <small class="text-muted">-</small>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-journal-x fs-1 text-muted"></i>
            <p class="mt-2 mb-0 text-muted">Tidak ada data log pada tanggal ini.</p>
        </div>
    @endforelse
</div>