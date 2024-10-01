@extends('layouts.app')

@section('title', 'Export SBU')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
        {{-- Favicon - Logo web disamping title --}}
    <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Export Usulan Standar Biaya Umum</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Export</a></div>
                    <div class="breadcrumb-item">Export Usulan Standar Biaya Umum</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')

                        @if (session('success'))
                            <div class="alert alert-success">
                                {!! session('success') !!}
                            </div>
                        @endif

                    </div>
                </div>
                <h2 class="section-title">Petunjuk</h2>
                <p class="section-lead">
                    Anda dapat mengeksport seluruh Usulan SBU saat ini dari SKPD menjadi file Excell dan di import pada SIPD-RI.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Usulan SKPD - SBU</h4>
                            </div>
                            <div class="float-right ml-4">
                                    <a href="javascript:void(0);" id="export-link" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i> Export to Excel
                                    </a>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{route('sbu.export_sbu')}}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Pencarian" name="spek">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Uraian Komponen</th>
                                            <th>Spesifikasi</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Dasar Surat</th>
                                            <th>SKPD</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach ($export_sbu as $s)
                                        <tr>
                                            <td>
                                                {{$s->Uraian}}
                                            </td>
                                            <td>
                                                {{$s->Spek}}
                                            </td>
                                            <td>
                                                {{$s->Satuan}}
                                            </td>

                                            <td>{{ number_format((float) $s->Harga, 0, ',', '.') }}</td>
                                            <td>
                                                {{$s->Document}}
                                            </td>
                                            <td>
                                                {{$s->skpd}}
                                            </td>
                                            <td>
                                                @if($s->ket == 'Proses Usul')
                                                    <span style="color: #d0cdcd;"><strong>{{ $s->ket }}</strong></span> <!-- Warna abu-abu tua -->
                                                @elseif($s->ket == 'Disetujui')
                                                    <span style="color: #07e93b;"><strong>{{ $s->ket }}</strong></span> <!-- Warna hijau -->
                                                @elseif($s->ket == 'Ditolak')
                                                    <span style="color: #ff0000;"><strong>{{ $s->ket }}</strong></span> <!-- Warna merah -->
                                                @else
                                                    <span><strong>{{ $s->ket }}</strong></span> <!-- Default warna hitam -->
                                                @endif
                                            </td>

                                        </tr>
                                        @endforeach

                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $export_sbu->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script>
        document.getElementById('export-link').addEventListener('click', function() {
            fetch("{{ route('sbu.export') }}")
                .then(response => response.blob())
                .then(blob => {
                    // Dapatkan tanggal dan waktu saat ini
                    let date = new Date();
                    let formattedDate = date.getFullYear() +
                                        ('0' + (date.getMonth() + 1)).slice(-2) +
                                        ('0' + date.getDate()).slice(-2) + '_' +
                                        ('0' + date.getHours()).slice(-2) +
                                        ('0' + date.getMinutes()).slice(-2) +
                                        ('0' + date.getSeconds()).slice(-2);
                    let fileName = formattedDate + '_export_sbu.xlsx';

                    // Buat elemen link, arahkan ke blob, dan 'klik' secara programatik
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = fileName;  // Tetapkan nama file yang dihasilkan
                    link.click();

                    // Segarkan halaman setelah unduhan
                    setTimeout(function() {
                        location.reload();
                    }, 500);  // Sesuaikan waktu sesuai kebutuhan
                })
                .catch(console.error);
        });
    </script>

@endpush
