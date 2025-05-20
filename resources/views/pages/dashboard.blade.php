@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    {{-- Favicon - Logo web disamping title --}}
    <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
    <style>
        /* Card shadow and transition for hover effect */
        .card:hover {
            transform: translateY(-10px);
            transition: 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Card custom color for each section */
        .card-icon.bg-primary {
            background: #80c4b3 !important;
        }

        .rules-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 40px 0;
        }

        .rules-card h2.section-title {
            color: #800000;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .rules-card ul {
            list-style-type: none;
            padding-left: 0;
            font-size: 16px;
            color: #555;

        }

        .rules-card ul li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }

        .rules-card ul li::before {
            content: "✓";
            color: #800000;
            font-weight: bold;
            position: absolute;
            left: 0;
            top: 0;
            font-size: 18px;
        }

    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard - Usulan Standar Harga Satuan</h1>
            </div>
            <div class="rules-card">
                <h2 class="section-title">MOHON DIBACA !!!</h2>
                <ul class="section-lead">
                    <li>Usulan harga dalam bentuk Pembelian BARANG (SSH) harus melampirkan Price List/Nota/Catatan dari Pihak Penjual atau bisa juga dalam bentuk screenshot dari Online Shop (e-catalog dll).</li>
                    <li>Usulan harga dalam bentuk Pembayaran JASA/HONORARIUM (SBU) agar melampirkan Aturan yang mendukung Pembayaran Jasa/Honor tersebut.</li>
                    <li>Jika Ada yang mengusulkan terkait Pembangunan/Rehabilitasi Gedung Kantor (ASB Fisik) perlu dikoordinasikan dengan Dinas PUTR sebagai Dinas Teknis.</li>
                    <li>Lampiran yang disebutkan diatas dibentuk dalam 1 file pdf bersama dengan Surat Usulan yang sudah tertanda dan cap SKPD kemudian di upload pada menu Usulan (Pdf).</li>
                </ul>
            </div>



            {{-- <div class="row">
                <!-- Admin SKPD Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Admin SKPD</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalSkpd }} Akun
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengguna Umum Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pengguna Umum</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUser }} Akun
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usulan Baru SSH Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Usulan Baru SSH</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsulbaruShs }} Usulan belum diperiksa
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usulan Baru SBU Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Usulan Baru SBU</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsulbaruSbu }} Usulan belum diperiksa
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usulan Baru ASB Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Usulan Baru ASB</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsulbaruAsb }} Usulan belum diperiksa
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usulan Baru ASB Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Usulan Baru HSPK</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsulbaruHspk }} Usulan belum diperiksa
                            </div>
                        </div>
                    </div>
                </div>

            </div> --}}



        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
