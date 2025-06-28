<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>{{ $title ?? 'Archieva' }}</title>
    @livewireStyles

    {{-- Sedikit style tambahan untuk memastikan footer menempel di bawah jika konten pendek --}}
    <style>
        .main-content-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
    </style>
</head>

<body>
    {{-- VERSI 1: SIDEBAR KHUSUS UNTUK TAMPILAN DESKTOP --}}
    <div class="sidebar-desktop d-none d-lg-flex flex-column p-3">
        <div class="sidebar-header mb-3">
            <a href="{{ route('homepage') }}">
                <img src="{{ asset('img/archievault3.jpeg') }}" class="img-fluid" style="max-width: 200px;" alt="Archievault Logo">
            </a>
        </div>
        <x-sidebar-menu />
    </div>

    {{-- VERSI 2: SIDEBAR KHUSUS UNTUK TAMPILAN MOBILE (Offcanvas) --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel" style="background-color: #123654; color: #fff;">
        <div class="offcanvas-header border-bottom border-secondary">
            <a href="{{ route('homepage') }}">
                <img src="{{ asset('img/archievault3.jpeg') }}" class="img-fluid" style="max-width: 200px;" alt="Archievault Logo">
            </a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-3">
            <x-sidebar-menu />
        </div>
    </div>

    {{-- KONTEN UTAMA HALAMAN --}}
    <div class="main-content-wrapper">
        <nav class="navbar navbar-light bg-light sticky-top border-bottom">
            <div class="container-fluid">
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" aria-controls="sidebarMobile">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <span class="navbar-brand h1 mb-0">{{ $title ?? 'Archieva' }}</span>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        @livewire('notification-indicator')
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger d-flex align-items-center" title="Logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-sm-inline ms-2">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <main class="p-3 p-md-4">
            {{ $slot }}
        </main>

        <footer class="mt-auto bg-white text-center text-muted py-3 border-top">
            Copyright &copy; {{ date('Y') }} 
            {{-- <a href="#" class="text-decoration-none fw-bold">{{ config('app.name', 'Archieva') }}</a>. --}}
            <a href="#" class="text-decoration-none fw-bold">Dewandra</a>.
            All Rights Reserved.
        </footer>
        
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>