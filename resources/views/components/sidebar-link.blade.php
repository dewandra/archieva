@props(['active' => false])

<li class="nav-item">
    <a wire:navigate {{ $attributes->class(['nav-link', 'active' => $active]) }}>
        @if(isset($icon))
            <span class="icon">
                {{ $icon }}
            </span>
        @endif
        {{ $slot }}
    </a>
</li>