@props(['users'])

<div class="table-responsive">
                <table class="table table-borderless table-hover align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr wire:key="{{ $user->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('img/default.png') }}"
                                            alt="Avatar" class="rounded-circle me-3" width="45" height="45"
                                            style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold">{{ $user->name }}</div>
                                            <div class="text-muted">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($user->role == 0)
                                        <span
                                            class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Admin</span>
                                    @elseif ($user->role == 1)
                                        <span
                                            class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Arsip</span>
                                    @else
                                        <span
                                            class="badge bg-success-subtle text-success-emphasis rounded-pill">Bidang</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            {{-- Tombol Edit --}}
                                            <li>
                                                <a class="dropdown-item" href="#" wire:click="showEditModal({{ $user->id }})">
                                                    <i class="bi bi-pencil-square me-2"></i> Edit Role
                                                </a>
                                            </li>
                                            {{-- Tombol Hapus --}}
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" wire:click="confirmDelete({{ $user->id }})">
                                                    <i class="bi bi-trash3-fill me-2"></i> Hapus User
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    Tidak ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $users->links() }}
            </div>