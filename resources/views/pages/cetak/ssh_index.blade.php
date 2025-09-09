<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekap Usulan SSH</title>
    <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
    <style>
        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #fff;
            color: #333;
            font-size: 12px;
        }

        /* Atur ukuran kertas cetak */
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 25px;
            position: relative;
        }
        .header img {
            position: absolute;
            left: 0;
            width: 80px;
        }
        .header h1 {
            font-size: 14px;
            margin: 0;
            color: #555;
            letter-spacing: 1px;
        }
        .header h2 {
            font-size: 22px;
            margin: 3px 0;
            color: #0d6efd;
            font-weight: bold;
        }
        .header h3 {
            font-size: 16px;
            margin: 0;
            color: #444;
        }

        /* Table */
        .table-container {
            margin-top: 30px;
        }
        .table-container h4 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #0d6efd;
            text-align: left;
            border-left: 4px solid #0d6efd;
            padding-left: 8px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            table-layout: fixed; /* <-- biar auto fit */
            word-wrap: break-word;
        }
        .table th {
            background: #0d6efd;
            color: #fff;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
            padding: 6px;
        }
        .table td {
            border: 1px solid #ddd;
            padding: 5px 6px;
            font-size: 10px;
            vertical-align: top;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tbody tr:hover {
            background-color: #eef6ff;
        }

        /* Footer cetak */
        .cetak-info {
            margin-top: 30px;
            font-size: 11px;
            text-align: right;
            color: #555;
        }

        /* Untuk cetak */
        @media print {
            body {
                padding: 0;
            }
            .header {
                border-bottom: 2px solid #000;
            }
            .table th {
                background-color: #444 !important;
                color: #fff !important;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header" style="display: flex; align-items: center; justify-content: center; position: relative; margin-bottom: 10px;">
        <img src="{{ public_path('img/logo_pemda.png') }}" alt="Logo Pemda"
            style="position: absolute; left: 0; width: 70px; height: auto; top: 10px;">
        <div style="text-align: center; padding-top: 10px;">
            <h1 style="font-size: 16px; margin: 0;">LAPORAN</h1>
            <h2 style="font-size: 24px; margin: 0;">USULAN STANDAR HARGA</h2>
            <h3 style="font-size: 18px; margin: 0;">KABUPATEN BOLAANG MONGONDOW UTARA</h3>
            <h3 style="font-size: 18px; margin: 0;">TAHUN ANGGARAN {{ $year }}</h3>
        </div>
    </div>

    <!-- Tabel -->
    <div class="table-container">
        <h4>Rekap Usulan SSH</h4>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 25%;">Spesifikasi</th>
                    <th style="width: 7%;">Satuan</th>
                    <th style="width: 10%;">Harga</th>
                    <th style="width: 12%;">No. Surat</th>
                    <th style="width: 14%;">Instansi</th>
                    <th style="width: 12%;">Diajukan oleh</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 8%;">Persetujuan</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($shscetaks as $pdf)
                    <tr>
                        <td style="text-align: center;">{{ $i++ }}</td>
                        <td>{{ $pdf->Spek }}</td>
                        <td style="text-align: center;">{{ $pdf->Satuan }}</td>
                        <td style="text-align: right;">Rp {{ number_format($pdf->Harga, 0, ',', '.') }}</td>
                        <td>{{ $pdf->Document }}</td>
                        <td>{{ $pdf->skpd }}</td>
                        <td>{{ $pdf->user }}</td>
                        <td style="text-align: center;">{{ $pdf->ket }}</td>
                        <td>{{ $pdf->disetujui }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer info cetak -->
    <div class="cetak-info">
        <p>*Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s') }}</p>
    </div>

</body>
</html>
