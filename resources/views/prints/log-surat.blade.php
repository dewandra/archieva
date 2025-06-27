{{-- File: resources/views/prints/log-surat.blade.php --}}
@extends('layouts.print')

<style>
    .print-table {
        width: 100%;
        /* Pastikan tabel menggunakan lebar penuh container */
        table-layout: fixed;
        /* <-- KUNCI #1: Paksa browser mengikuti lebar kolom yg kita tentukan */
        font-size: 9pt;
        border-color: #333 !important;
    }

    .print-table th,
    .print-table td {
        padding: 5px 8px;
        border-color: #333 !important;
        vertical-align: middle;
        word-wrap: break-word;
        /* <-- KUNCI #2: Izinkan teks panjang untuk turun baris jika perlu */
    }

    .print-table thead th {
        background-color: #E9ECEF !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>

@section('content')
    {{-- Bungkus semuanya dengan .page-container --}}
    <div class="page-container">

        {{-- BAGIAN 1: KONTEN UTAMA (KOP SURAT & TABEL) --}}
        <div>
            {{-- KOP SURAT (tidak ada perubahan) --}}
            <header style="border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center;">
                <h4 style="margin: 0; font-weight: bold;">Badan Koordinasi Wilayah Pemerintahan dan Pembangunan Jawa Timur
                    III ( BAKORWIL III ) Malang</h4>
                <p style="margin: 0; font-size: 14px;">Jl. Simpang Ijen No.2, Oro-oro Dowo, Kec. Klojen, Kota Malang, Jawa
                    Timur 65119 | Telp: (0341) 551321</p>
            </header>

            {{-- JUDUL LAPORAN (tidak ada perubahan) --}}
            <div class="text-center mb-4">
                <h5 class="text-decoration-underline" style="font-weight: bold;">BUKU AGENDA LOG SURAT</h5>
                <p class="mb-0">Periode: {{ $selectedDate->isoFormat('D MMMM Y') }}</p>
            </div>

            {{-- TABEL DATA (tidak ada perubahan) --}}
            <table class="table table-bordered print-table">
                {{-- ... Isi tabel Anda ... --}}
                {{-- Definisikan lebar setiap kolom di sini --}}
                <colgroup>
                    <col style="width: 5%;">
                    <col style="width: 30%;">
                    <col style="width: 25%;">
                    <col style="width: 25%;">
                    <col style="width: 15%;">
                </colgroup>
                <thead class="text-center">
                    <tr>
                        <th style="width: 10%;">No.</th>
                        <th style="width: 25%;">Nomor Surat</th>
                        <th style="width: 40%;">Bidang</th>
                        <th style="width: 10%;">Diarsip Oleh</th>
                        <th style="width: 25%;">Waktu Arsip</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $index => $log)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $log->nomor_surat }}</td>
                            <td>{{ $log->bidang }}</td>
                            <td>{{ $log->user->name ?? '-' }}</td>
                            <td class="text-center">{{ $log->created_at->format('H:i') }} WIB</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 fst-italic">-- Tidak ada data tercatat pada tanggal
                                ini --</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{-- BAGIAN 2: BLOK FOOTER DAN TANDA TANGAN (AKAN SELALU DI BAWAH) --}}
        <div class="footer-section">
            <div class="row">
                {{-- Bagian Kiri: Info Aplikasi --}}
                <div class="col-7" style="font-size: 9px; color: #555;">
                    <i>Dokumen ini dicetak melalui aplikasi **Archievault**.</i>
                </div>

                {{-- Bagian Kanan: Tanda Tangan --}}
                <div class="col-5 text-center" style="font-size: 12px;">
                    <p class="mb-1">Malang, {{ now()->isoFormat('D MMMM Y') }}</p>
                    <p>Mengetahui,</p>
                    <div style="height: 60px;"></div>
                    <p class="fw-bold text-decoration-underline mb-0">(_________________________)</p>
                    <p>Kepala Bagian Kearsipan</p>
                </div>
            </div>
        </div>

    </div>
@endsection
