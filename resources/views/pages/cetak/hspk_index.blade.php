<!DOCTYPE html>
<html>
<head>
    <title>Rekap Usulan Standar Harga</title>
    {{-- Favicon - Logo web disamping title --}}
    <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
    <style>
        body {
            font-family: 'Bookman Old Style', serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header {
            margin-bottom: 20px;
        }
        .header img {
            margin-right: 10px;
            height: Auto; /* Atur tinggi logo sesuai kebutuhan */
            /* width: Auto;   Atur lebar logo agar otomatis sesuai rasio */
        }
        .header h1 {
            font-size: 16px;
            margin: 0;
        }
        .header h2 {
            font-size: 26px;
            margin: 0;
        }
        .header h3 {
            font-size: 20px;
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            font-size: 12px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: center;
            width: auto;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table-container {
            margin-top: 40px;
        }
        .table-container h4 {
            margin: 10px 0;
            font-size: 18px;
        }
        .cetak-info {
            margin-top: 20px;
            font-size: 14px;
            text-align: right;
            /* margin-right: 40px; */
        }

    </style>
</head>
<body>

    <div class="header" style="display: flex; align-items: center; justify-content: center; position: relative;">
        <img src="{{ public_path('img/logo_pemda.png') }}" alt="Logo Pemda" style="position: absolute; left: 0; width: 100px;">
        <div style="text-align: center;">
            <h1>LAPORAN</h1>
            <h2>USULAN STANDAR HARGA</h2>
            <h3>KAB. BOLAANG MONGONDOW UTARA</h3>
            <h3>TAHUN ANGGARAN {{ $year }}</h3>
        </div>
    </div>



    <div class="table-container">
        <h4>Harga Satuan Pokok Kegiatan (HSPK)</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Spesifikasi</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Nomor Surat Usulan</th>
                    <th>Status</th>
                    <th>Instansi</th>
                    <th>Diajukan oleh</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp

                @foreach($hspkcetaks as $pdf)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $pdf->Spek }}</td>
                        <td>{{ $pdf->Satuan }}</td>
                        <td>Rp {{ number_format($pdf->Harga, 0, ',', '.') }}</td> <!-- Format harga dengan titik -->
                        <td>{{ $pdf->Document }}</td>
                        <td>{{ $pdf->ket }}</td>
                        <td>{{ $pdf->skpd }}</td>
                        <td>{{ $pdf->user }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>


    <div class="cetak-info">
        <p>*Dicetak pada tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
    </div>

</body>
</html>

