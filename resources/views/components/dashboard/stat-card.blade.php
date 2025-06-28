{{-- File: resources/views/components/dashboard/stat-card.blade.php --}}
@props([
    'icon',
    'title',
    'value',
    'color' => 'primary'
])

<div class="card h-100">
    <div class="card-body d-flex align-items-center">
        <div class="stat-card-icon bg-{{ $color }} bg-opacity-10 text-{{$color}} me-3">
            <i class="bi {{ $icon }}"></i>
        </div>
        <div>
            <h4 class="fw-bold mb-1">{{ $value }}</h4>
            <p class="text-muted mb-0">{{ $title }}</p>
        </div>
    </div>
</div>