@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">

    <style>
        /* DASHBOARD STATS */

        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 35px rgba(0, 0, 0, .15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: white;
            font-size: 24px;
        }

        .bg-shs {
            background: #2ecc71;
        }

        .bg-sbu {
            background: #f39c12;
        }

        .bg-asb {
            background: #3498db;
        }

        /* RULES */

        .rules-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
        }

        .rules-card h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #04909c;
            font-weight: 600;
        }

        .rules-card ul {
            padding-left: 0;
            list-style: none;
        }

        .rules-card li {
            margin-bottom: 10px;
            padding-left: 18px;
            position: relative;
            color: #555;
        }

        .rules-card li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #04909c;
            font-weight: bold;
        }

        /* TABLE */

        .dashboard-table {
            background: white;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
            overflow: hidden;
        }
    </style>
@endpush


@section('main')

    <div class="main-content">

        <section class="section">

            <div class="section-header">
                <h1>Dashboard Usulan Standar Harga</h1>
            </div>


            {{-- STATISTIK --}}
            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-12">

                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">

                            <div class="stat-icon bg-shs mr-3">
                                <i class="fas fa-box"></i>
                            </div>

                            <div>
                                <h6 class="text-muted">Usulan SSH</h6>
                                <h3>{{ $totalShs }}</h3>
                                <small>Belum Disetujui</small>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="col-lg-4 col-md-6 col-sm-12">

                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">

                            <div class="stat-icon bg-sbu mr-3">
                                <i class="fas fa-user-tie"></i>
                            </div>

                            <div>
                                <h6 class="text-muted">Usulan SBU</h6>
                                <h3>{{ $totalSbu }}</h3>
                                <small>Belum Disetujui</small>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="col-lg-4 col-md-6 col-sm-12">

                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">

                            <div class="stat-icon bg-asb mr-3">
                                <i class="fas fa-building"></i>
                            </div>

                            <div>
                                <h6 class="text-muted">Usulan ASB</h6>
                                <h3>{{ $totalAsb }}</h3>
                                <small>Belum Disetujui</small>
                            </div>

                        </div>
                    </div>

                </div>

            </div>



            {{-- TABEL USULAN SSH TERBARU --}}
            <div class="card dashboard-table mt-4">

                <div class="card-header">
                    <h4>Usulan SSH Terbaru</h4>
                </div>

                <div class="card-body p-0 table-responsive">

                    <table class="table table-striped mb-0">

                        <thead>

                            <tr>
                                <th>Uraian</th>
                                <th>Spek</th>
                                <th>Harga</th>
                                <th>Dokumen</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($latestShs as $data)
                                <tr>

                                    <td>{{ $data->Uraian }}</td>

                                    <td>{{ $data->Spek }}</td>

                                    <td>
                                        Rp {{ number_format($data->Harga) }}
                                    </td>

                                    <td>{{ $data->Document }}</td>

                                    <td>

                                        @if ($data->ket == 'Proses Usul')
                                            <span class="badge badge-warning">Proses</span>
                                        @elseif($data->ket == 'Disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>



            {{-- KETENTUAN UMUM --}}
            <div class="rules-card mt-4">

                <h2>KETENTUAN UMUM</h2>

                <ul>

                    <li>Semua usulan WAJIB mempunyai Lampiran Pendukung Penetapan Harga.</li>

                    <li>Usulan harga dalam bentuk Pembelian BARANG (SSH) harus melampirkan Price List/Nota dari pihak
                        penjual atau screenshot marketplace.</li>

                    <li>Usulan harga dalam bentuk Pembayaran JASA/HONORARIUM (SBU) wajib melampirkan aturan yang mendukung.
                    </li>

                    <li>Usulan pembangunan atau rehabilitasi gedung (ASB Fisik) harus berkoordinasi dengan Dinas PUTR
                        sebagai dinas teknis.</li>

                </ul>

            </div>



            {{-- CARA PENGUSULAN --}}
            <div class="rules-card">

                <h2>CARA PENGUSULAN STANDAR HARGA</h2>

                <ul>

                    <li>User baru harus menghubungi Admin BMD untuk mendapatkan akses SKPD.</li>

                    <li>Surat usulan dan lampiran dibuat dalam satu file PDF maksimal 500Kb.</li>

                    <li>Upload melalui menu <b>Upload Usulan</b>.</li>

                    <li>Input usulan melalui menu SSH, SBU, atau ASB sesuai kategori.</li>

                </ul>

            </div>



            {{-- ALUR PERSETUJUAN --}}
            <div class="rules-card">

                <h2>ALUR PERSETUJUAN USULAN</h2>

                <ul>

                    <li>Usulan dilakukan oleh masing-masing SKPD.</li>

                    <li>Verifikasi dilakukan oleh Bidang BMD berdasarkan ketentuan umum.</li>

                    <li>Jika tidak memenuhi syarat, usulan dapat langsung ditolak oleh verifikator.</li>

                    <li>Persetujuan akhir dilakukan oleh Kepala BPKPD.</li>

                </ul>

            </div>


        </section>

    </div>


    {{-- AUDIO BACKSOUND --}}
    <audio id="audio-backsound" src="{{ asset('audio/Starbucks.m4a') }}" autoplay loop></audio>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let audio = document.getElementById('audio-backsound');

            audio.play().catch(function(e) {

                console.log("Autoplay mungkin diblokir browser");

            });

        });
    </script>


@endsection


@push('scripts')
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
@endpush
