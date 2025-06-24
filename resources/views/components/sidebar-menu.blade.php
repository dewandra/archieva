{{-- KONTEN UTAMA: Daftar Menu Utama --}}
<ul class="nav nav-pills flex-column sidebar-nav flex-grow-1">
    @if(in_array(Auth::user()->role, [0,1]))
    <x-sidebar-link :href="route('homepage')" :active="request()->routeIs('homepage')">
        <x-slot name="icon"><i class="bi-house-door"></i></x-slot>
        Dashboard
    </x-sidebar-link>
    @endif
    @if(in_array(Auth::user()->role, [0, 1]))
    <x-sidebar-link :href="route('surat-masuk')" :active="request()->routeIs('surat-masuk')">
        <x-slot name="icon"><i class="bi bi-envelope"></i></x-slot>
        Surat Masuk
    </x-sidebar-link>
    <x-sidebar-link :href="route('surat-keluar')" :active="request()->routeIs('surat-keluar')">
        <x-slot name="icon"><i class="bi bi-envelope-open"></i></x-slot>
        Surat Keluar
    </x-sidebar-link>
    @endif
    <x-sidebar-link :href="route('request-surat')" :active="request()->routeIs('request-surat')">
        <x-slot name="icon"><i class="bi bi-pencil-square"></i></x-slot>
        Request Surat
    </x-sidebar-link>
    @if(in_array(Auth::user()->role, [0, 1]))
    <x-sidebar-link :href="route('log-surat')" :active="request()->routeIs('log-surat')">
        <x-slot name="icon"><i class="bi bi-journal-text"></i></x-slot>
        Log Surat
    </x-sidebar-link>
    @endif
</ul>

{{-- FOOTER: Menu Akun --}}
<ul class="nav nav-pills flex-column sidebar-nav mt-auto">
    <hr class="sidebar-divider">
    @if(Auth::user()->role == 0)
    <x-sidebar-link :href="route('list-user')" :active="request()->routeIs('list-user')">
        <x-slot name="icon"><i class="bi bi-people"></i></x-slot>
        Users
    </x-sidebar-link>
    @endif
    <x-sidebar-link :href="route('profile')" :active="request()->routeIs('profile')">
        <x-slot name="icon"><i class="bi bi-person-circle"></i></x-slot>
        Profile
    </x-sidebar-link>
</ul>
