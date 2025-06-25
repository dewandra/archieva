@props(['groupedSurat'])

            @if($groupedSurat->isNotEmpty())
                <div class="row flex-nowrap" style="overflow-x: auto; padding-bottom: 1rem;">
                    {{-- Loop untuk setiap kolom tanggal --}}
                    @foreach ($groupedSurat as $tanggal => $items)
                        <div class="col-md-4">
                            <div class="border rounded p-2 h-100">
                                <h6 class="text-center bg-light p-2 rounded mb-2">
                                    {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}
                                </h6>
                                <table class="table table-sm table-hover">
                                    <thead class="text-muted small text-uppercase">
                                        <tr>
                                            <th>No</th>
                                            <th>Klasifikasi</th>
                                            <th>Pencatat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr wire:key="{{ $item->id }}">
                                                <td class="fw-bold">{{ $item->nomor_surat }}</td>
                                                <td>{{ $item->klasifikasi }}</td>
                                                <td><span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $item->user?->name }}</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-light btn-sm" title="Edit" wire:click="showEditModal({{ $item->id }})">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button class="btn btn-light btn-sm text-danger" title="Hapus" wire:click="confirmDelete({{ $item->id }})">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center p-5">
                    <i class="bi bi-journal-x fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada data surat keluar yang tercatat.</p>
                </div>
            @endif