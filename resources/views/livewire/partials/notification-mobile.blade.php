{{-- File: resources/views/livewire/partials/notification-mobile.blade.php --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="notificationOffcanvas" aria-labelledby="notificationOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="notificationOffcanvasLabel">Notifikasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        {{-- Daftar Notifikasi --}}
        <div style="max-height: 100%; overflow-y: auto;">
            @forelse($this->unreadNotifications as $notification)
                <a wire:key="mobile-notif-{{ $notification->id }}" class="d-block text-decoration-none text-dark p-3 border-bottom" href="#" wire:click.prevent="markAsRead('{{ $notification->id }}')">
                    <div class="d-flex w-100">
                        <div class="flex-shrink-0 me-3">
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
    </div>
    @if($this->unreadNotifications->isNotEmpty())
        <div class="offcanvas-footer p-3 bg-light border-top">
            <a href="#" wire:click.prevent="openAndMarkAllAsRead" class="btn btn-outline-primary w-100">Tandai semua dibaca</a>
        </div>
    @endif
</div>