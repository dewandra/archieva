<div class="dropdown">
    <button wire:poll.15s="updateCount" class="btn btn-outline-secondary position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
        <i class="bi bi-bell-fill"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">{{ $unreadCount }}</span>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="width: 320px;">
        <li class="px-3 py-2 fw-bold">Notifikasi</li>
        <li><hr class="dropdown-divider m-0"></li>
        <div style="max-height: 400px; overflow-y: auto;">
            @forelse($this->unreadNotifications as $notification)
                <li wire:key="{{ $notification->id }}"><a class="dropdown-item py-2" href="#" wire:click.prevent="markAsRead('{{ $notification->id }}')"><div class="d-flex align-items-start">
                    @if(isset($notification->data['requester_name'])) <i class="bi bi-person-fill bg-primary text-white rounded-circle p-2 me-2"></i> @else <i class="bi bi-check-circle-fill bg-success text-white rounded-circle p-2 me-2"></i> @endif
                    <div><p class="mb-0 small" style="line-height: 1.4;">@if(isset($notification->data['requester_name']))<span class="fw-bold">{{ $notification->data['requester_name'] }}</span> {{ $notification->data['message'] }} @else {{ $notification->data['message'] }} @endif</p><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small></div>
                </div></a></li>
            @empty
                <li><p class="text-center text-muted small my-4">Tidak ada notifikasi baru.</p></li>
            @endforelse
        </div>
    </ul>
</div>