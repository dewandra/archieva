{{-- File: resources/views/layouts/print.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Cetak Laporan' }}</title>
    @vite(['resources/sass/app.scss'])
    <style>
        html, body {
            height: 100%; /* Penting agar body bisa menjadi referensi tinggi */
            margin: 0;
            padding: 0;
            background-color: #fff !important;
        }
        
        /* === INI KUNCI UTAMANYA === */
        .page-container {
            display: flex; /* Mengaktifkan Flexbox */
            flex-direction: column; /* Mengatur item agar tersusun dari atas ke bawah */
            justify-content: space-between; /* Mendorong item pertama ke atas dan item terakhir ke bawah */
            min-height: 95vh; /* Memaksa container setinggi halaman cetak (sisakan margin) */
        }
        /* ========================== */

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <main class="container py-3">
        @yield('content')
    </main>
</body>
</html>