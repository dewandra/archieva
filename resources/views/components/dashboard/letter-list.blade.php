{{-- File: resources/views/components/dashboard/letter-list.blade.php --}}
@props(['title', 'letters', 'dateKey', 'mainKey', 'subKey', 'icon', 'color'])

<div class="card h-100 letter-list">
    <div class="card-header bg-white pt-4 border-0">
        <h5 class="card-title fw-bold">{{ $title }}</h5>
    </div>
    <div class="card-body pt-0">
        <ul class="list-group list-group-flush">
            @forelse ($letters as $letter)
                <li class="list-group-item d-flex align-items-center border-0 px-0">
                    <div class="item-icon bg-{{ $color }} bg-opacity-10 text-{{ $color }} me-3">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="fw-bold mb-0 text-dark">{{ Str::limit($letter->{$mainKey}, 35) }}</p>
                        <small class="text-muted">{{ $letter->{$subKey} }}</small>
                    </div>
                    <small class="text-muted">{{ $letter->{$dateKey}->diffForHumans() }}</small>
                </li>
            @empty
                <li class="list-group-item text-center text-muted border-0 py-5">
                    <i class="bi bi-folder2-open fs-2"></i>
                    <p class="mt-2 mb-0">Tidak ada data.</p>
                </li>
            @endforelse
        </ul>
    </div>
</div>