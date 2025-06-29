<div class="dropdown">
    <button wire:poll.15s="updateCount" class="btn btn-outline-secondary position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
        <i class="bi bi-bell-fill"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">{{ $unreadCount }}</span>
        @endif
    </button>
    
    <ul wire:ignore.self class="dropdown-menu dropdown-menu-end shadow border-light py-0" style="width: 360px;">
        
        <li class="px-3 py-2 bg-light border-bottom">
            <span class="fw-bold">Notifikasi</span>
        </li>

        <li class="p-0">
            <div style="max-height: 320px; overflow-y: auto;">
                @forelse($this->unreadNotifications as $notification)
                    <a wire:key="{{ $notification->id }}" class="dropdown-item p-3 border-bottom" href="#" wire:click.prevent="markAsRead('{{ $notification->id }}')">
                        <div class="d-flex w-100">
                            <div class="flex-shrink-0 me-3">
                                {{-- PERBAIKAN: Menambahkan kelas 'text-white' pada ikon --}}
                                <div class="d-flex align-items-center justify-content-center rounded-circle @if(isset($notification->data['requester_name'])) bg-primary @else bg-success @endif" style="width: 40px; height: 40px;">
                                    @if(isset($notification->data['requester_name']))
                                        <i class="bi bi-person-fill text-white"></i> 
                                    @else 
                                        <i class="bi bi-check-circle-fill text-white"></i> 
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1" style="font-size: 0.9rem; white-space: normal; word-wrap: break-word;">
                                    @if(isset($notification->data['requester_name']))
                                        <span class="fw-bold">{{ $notification->data['requester_name'] }}</span> {{ $notification->data['message'] }} 
                                    @else 
                                        {{ $notification->data['message'] }} 
                                    @endif
                                </p>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5 px-3">
                        <i class="bi bi-check2-circle fs-2 text-success"></i>
                        <p class="text-muted mt-2">Tidak ada notifikasi baru.</p>
                    </div>
                @endforelse
            </div>
        </li>

        @if($this->unreadNotifications->isNotEmpty())
            <li class="bg-light border-top">
                <a href="#" wire:click.prevent="openAndMarkAllAsRead" class="dropdown-item text-center small py-2 text-primary fw-bold">Tandai semua dibaca</a>
            </li>
        @endif
    </ul>
</div>

{{-- Tidak perlu ada @push('styles') sama sekali --}}