<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('homepage') }}" class="sidebar-brand">
            <img src="{{ asset('img/archievault3.jpeg') }}" width="200" alt="Archievault Logo">
        </a>
    </div>

    <div class="d-flex flex-column justify-content-between" style="height: calc(100% - 80px);">
        {{-- Menu Navigasi Utama --}}
        <ul class="nav nav-pills flex-column sidebar-nav">

            {{-- BISA DILIHAT OLEH SEMUA ROLE --}}
            @if(in_array(Auth::user()->role, [0,1]))
            <x-sidebar-link :href="route('homepage')" :active="request()->routeIs('homepage')">
                <x-slot name="icon">
                    <i class="bi-house-door"></i>
                </x-slot>
                Dashboard
            </x-sidebar-link>
            @endif

            {{-- HANYA BISA DILIHAT OLEH ADMIN (0) DAN ARSIP (1) --}}
            @if(in_array(Auth::user()->role, [0, 1]))
            <x-sidebar-link :href="route('surat-masuk')" :active="request()->routeIs('surat-masuk')">
                <x-slot name="icon">
                    <i class="bi bi-envelope"></i>
                </x-slot>
                Surat Masuk
            </x-sidebar-link>

            <x-sidebar-link :href="route('surat-keluar')" :active="request()->routeIs('surat-keluar')">
                <x-slot name="icon">
                    <i class="bi bi-envelope-open"></i>
                </x-slot>
                Surat Keluar
            </x-sidebar-link>
            @endif

            {{-- BISA DILIHAT OLEH SEMUA ROLE --}}
            <x-sidebar-link :href="route('request-surat')" :active="request()->routeIs('request-surat')">
                <x-slot name="icon">
                    <i class="bi bi-pencil-square"></i>
                </x-slot>
                Request Surat
            </x-sidebar-link>

            {{-- HANYA BISA DILIHAT OLEH ADMIN (0) DAN ARSIP (1) --}}
            @if(in_array(Auth::user()->role, [0, 1]))
            <x-sidebar-link :href="route('log-surat')" :active="request()->routeIs('log-surat')">
                <x-slot name="icon">
                    <i class="bi bi-journal-text"></i>
                </x-slot>
                Log Surat
            </x-sidebar-link>
            @endif
        </ul>

        {{-- Menu Akun (Profile & Logout) --}}
        <ul class="nav nav-pills flex-column sidebar-nav mt-auto mb-3">
            <hr class="sidebar-divider">
            {{-- HANYA BISA DILIHAT OLEH ADMIN (ROLE 0) --}}
            @if(Auth::user()->role == 0)
            <x-sidebar-link :href="route('list-user')" :active="request()->routeIs('list-user')">
                <x-slot name="icon">
                    <i class="bi bi-people"></i>
                </x-slot>
                Users
            </x-sidebar-link>
            @endif
            <x-sidebar-link :href="route('profile')" :active="request()->routeIs('profile')">
                <x-slot name="icon">
                    <i class="bi bi-person-circle"></i>
                </x-slot>
                Profile
            </x-sidebar-link>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="nav-link" 
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>