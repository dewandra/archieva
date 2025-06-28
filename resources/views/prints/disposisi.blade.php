{{-- File: resources/views/prints/disposisi.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Cetak Disposisi' }}</title>
    {{-- Kita tidak akan memuat file CSS apa pun untuk memastikan tidak ada style yang mengganggu --}}
    <style>
        /* Reset margin dan padding dasar dari body */
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif; /* Font dasar browser */
        }
    </style>
</head>
<body onload="window.print()">

    {{-- 
      Div pembungkus utama dengan margin atas dan kiri yang presisi.
      - margin-top: 161px (sesuai mt-[161px])
      - margin-left: 56px (sesuai ml-14 di Tailwind)
    --}}
    <div style="margin-top: 161px; margin-left: 56px;">
    
        {{-- Tabel Pertama --}}
        <table style="font-size: 15px; width: 700px; border-collapse: collapse;">
            <tbody>
                <tr style="height: 50px;">
                    <td style="width: 90px;"></td>
                    <td style="width: 300px; text-align: left;">
                        <b>{{ $surat->pengirim }}</b>
                    </td>
                    <td style="width: 105px;"></td>
                    <td style="text-align: left;">
                        <b>{{ $surat->tanggal_diterima->format('d-m-Y') }}</b>
                    </td>
                </tr>
                <tr style="height: 50px;">
                    <td style="width: 90px;"></td>
                    <td style="text-align: left;">
                        <b>{{ $surat->tanggal_surat->format('d-m-Y') }}</b>
                    </td>
                    <td style="width: 105px;"></td>
                    <td style="text-align: left;">
                        {{-- Menggunakan ID sebagai nomor agenda --}}
                        <b>{{ $nomorAgenda }}</b>
                    </td>
                </tr>
                <tr style="height: 50px;">
                    <td style="width: 90px;"></td>
                    <td style="text-align: left;">
                        <b>{{ $surat->nomor_surat }}</b>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        {{-- 
          Jarak antara dua tabel.
          - margin-top: 24px (sesuai mt-6 di Tailwind)
        --}}
        <div style="margin-top: 24px;">
            <table style="width: 700px; border-collapse: collapse;">
                <tbody>
                    <tr style="height: 10px;"></tr>
                    <tr style="height: 50px;">
                        <td style="width: 90px;"></td>
                        <td style="text-align: left;">
                            <b>{{ $surat->perihal }}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>