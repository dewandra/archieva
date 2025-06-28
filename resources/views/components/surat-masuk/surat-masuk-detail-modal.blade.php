@props(['surat', 'nomorAgenda'])

<div wire:ignore.self class="modal fade" id="detailSuratModal" tabindex="-1" aria-labelledby="detailSuratModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            {{-- Tambahkan @if untuk mencegah error saat $surat masih null --}}
            @if ($surat)
                <div class="modal-header bg-light border-bottom">
                    <div>
                        <h5 class="modal-title" id="detailSuratModalLabel">Detail Surat</h5>
                        <small class="text-muted">Nomor Surat: {{ $surat->nomor_surat }}</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-7">
                            <h6 class="text-primary">PERIHAL</h6>
                            <p class="h5 mb-4">{{ $surat->perihal }}</p>

                            <h6 class="text-primary">DETAIL</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150px"><i class="bi bi-person-fill me-2 text-muted"></i> Pengirim</td>
                                    <td>: {{ $surat->pengirim }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event-fill me-2 text-muted"></i> Tgl. Surat</td>
                                    <td>: {{ $surat->tanggal_surat->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-check-fill me-2 text-muted"></i> Tgl. Diterima</td>
                                    <td>: {{ $surat->tanggal_diterima->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-lock-fill me-2 text-muted"></i> Sifat</td>
                                    <td>: <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $surat->sifat }}</span></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-person-check-fill me-2 text-muted"></i> Diinput oleh</td>
                                    <td>: {{ $surat->user->name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <h6 class="text-primary">LAMPIRAN</h6>
                            @if ($surat->lampiran)
                                <div class="border rounded p-3 text-center">
                                    <i class="bi bi-file-earmark-arrow-down-fill text-success fs-1"></i>
                                    <p class="mb-2 mt-2 small text-muted">{{ Str::afterLast($surat->lampiran, '/') }}</p>
                                    <a href="{{ asset('storage/' . $surat->lampiran) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-download me-2"></i> Download Lampiran
                                    </a>
                                </div>
                            @else
                                <div class="border rounded p-3 text-center bg-light">
                                    <i class="bi bi-file-earmark-excel-fill text-muted fs-1"></i>
                                    <p class="mb-0 mt-2 text-muted">Tidak ada lampiran.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-primary">DISPOSISI</h6>
                    <p>Surat ini ditujukan ke bagian: 
                        @foreach($surat->tujuan_surat as $tujuan)
                            <span class="badge bg-secondary me-1">{{ $tujuan }}</span>
                        @endforeach
                    </p>
                    <p>Posisi Surat Saat Ini: <strong>{{ $surat->posisi_surat }}</strong></p>
                </div>
                <div class="modal-footer bg-light">
                    {{-- TOMBOL CETAK BARU --}}
                    <a href="{{ route('print.disposisi', ['surat' => $surat->id, 'nomorAgenda' => $nomorAgenda ]) }}" target="_blank" class="btn btn-success me-auto">
                        <i class="bi bi-printer-fill me-1"></i> Cetak Disposisi
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            @endif
        </div>
    </div>
</div>