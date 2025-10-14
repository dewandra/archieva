@props(['icon', 'title', 'value', 'color' => 'primary'])

{{-- Mapping warna ke class yang sesuai --}}
@php
    $colorClasses = [
        'um-primary-blue' => ['bg' => 'bg-um-primary', 'icon' => 'text-white'],
        'um-yellow' => ['bg' => 'bg-warning', 'icon' => 'text-um-blue'], 
        'um-green' => ['bg' => 'bg-um-green', 'icon' => 'text-white']
    ];
    
    $bgClass = $colorClasses[$color]['bg'] ?? 'bg-primary';
    $iconClass = $colorClasses[$color]['icon'] ?? 'text-white';
    
    // Pastikan icon class ada prefix 'bi'
    $iconName = str_starts_with($icon, 'bi-') ? $icon : 'bi-' . $icon;
@endphp

<div class="card h-100 shadow-sm border-0">
    <div class="card-body d-flex align-items-center">
        <div class="stat-card-icon {{ $bgClass }} bg-opacity-10 me-3 flex-shrink-0">
            <i class="bi {{ $iconName }} {{ $iconClass }} fs-2"></i>
        </div>
        <div class="flex-grow-1">
            <h6 class="text-muted mb-1 fw-normal small">{{ $title }}</h6>
            <h2 class="mb-0 fw-bold">{{ $value }}</h2>
        </div>
    </div>
</div>