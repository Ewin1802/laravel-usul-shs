@extends('layouts.app')

@section('title', 'Usulan SHS SKPD')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        {{-- Favicon - Logo web disamping title --}}
        <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Standar Satuan Harga (SSH)</h1>
                <div class="section-header-button">
                    <a href="{{ route('shs.create') }}"
                        class="btn btn-primary">Buat Usulan Baru</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses SKPD</a></div>
                    <div class="breadcrumb-item">Usulan SSH</div>
                </div>
            </div>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Petunjuk</h2>
                <ul>
                    <li>Anda dapat mengajukan Usulan Standar baru dengan cara klik tombol "Buat Usulan Baru".</li>
                    <li>Jika Status "Proses Usul" berarti item tersebut masih dalam tahap pemeriksaan dan masih bisa diubah, "Disetujui" sudah dalam tahap penginputan di SIPD, dan "Ditolak" berarti usulan Anda tidak disetujui.</li>
                </ul>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Silahkan Periksa Usulan Anda</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{route('shs.index')}}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Pencarian" name="spek"
                                                value="{{ request('spek') }}">
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
                                            <th>Komponen</th>
                                            <th>Harga</th>
                                            <th>Dasar Surat</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($shs as $s)
                                            <tr>
                                                <td>
                                                    {{ $s->Uraian }} <br>
                                                    <strong>Spek : {{ $s->Spek }}</strong> <br>
                                                    Satuan : {{ $s->Satuan }}
                                                </td>
                                                <td>{{ number_format((float) $s->Harga, 0, ',', '.') }}</td>
                                                <td>{{ $s->Document }}</td>
                                                <td>
                                                    @php
                                                        $status = $s->ket;
                                                        $displayText = $status; // default

                                                        if ($status == 'Proses Usul') {
                                                            $displayText = 'Menunggu Verifikasi Admin';
                                                        } elseif ($status == 'Verified') {
                                                            $displayText = 'Menunggu Persetujuan Pimpinan';
                                                        } elseif ($status == 'Ditolak') {
                                                            $displayText = 'Usulan tidak memenuhi syarat';
                                                        } elseif ($status == 'Disetujui') {
                                                            $displayText = 'Usulan Disetujui';
                                                        }
                                                    @endphp

                                                    @if($status == 'Proses Usul')
                                                        <span style="color: #07c9c9;"><strong>{{ $displayText }}</strong></span>
                                                    @elseif($status == 'Disetujui')
                                                        <span style="color: #029925;"><strong>{{ $displayText }}</strong></span>
                                                    @elseif($status == 'Ditolak')
                                                        <span style="color: #ff0000;"><strong>{{ $displayText }}</strong></span>
                                                    @elseif($status == 'Verified')
                                                        <span style="color: #e0a800;"><strong>{{ $displayText }}</strong></span>
                                                    @else
                                                        <span><strong>{{ $displayText }}</strong></span>
                                                    @endif
                                                </td>
                                                <td>{{ $s->alasan }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <!-- Tombol View -->
                                                        <a href='#' class="btn btn-sm btn-icon btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalView"
                                                            data-uraian="{{ $s->Uraian }}"
                                                            data-doc="{{ $s->Document }}"
                                                            data-speck="{{ $s->Spek }}"
                                                            data-satuan="{{ $s->Satuan }}"
                                                            data-akun_belanja="{{ $s->akun_belanja }}"
                                                            data-rekening_1="{{ $s->rekening_1 }}"
                                                            data-ket="{{ $s->ket }}"
                                                            data-user="{{ $s->user }}"
                                                            data-alasan="{{ $s->alasan }}">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                        <a href='{{ route('shs_user.edit', $s->id) }}'
                                                            class="btn btn-sm btn-info btn-icon ml-2
                                                            @if($s->ket == 'Ditolak' || $s->ket == 'Disetujui' || $s->ket == 'Verified') disabled @endif">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        @if($s->ket == 'Proses Usul')
                                                            <form action="{{ route('shs.hapus', $s->id) }}" method="POST" class="ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger btn-icon" onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </table>
                                </div>

                                <div class="float-right">
                                    {{ $shs->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal View -->
    <div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="modalViewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewLabel">Detail Usulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Dasar Surat:</strong>
                        <p id="doc"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Uraian:</strong>
                        <p id="uraian"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Spesifikasi:</strong>
                        <p id="speck"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Satuan:</strong>
                        <p id="satuan"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Akun Belanja:</strong>
                        <p id="akun_belanja"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Rekening Belanja:</strong>
                        <p id="rekening_1"></p>
                    </div>

                    <div class="mb-3">
                        <strong>Diajukan oleh:</strong>
                        <p id="user"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <p id="ket"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Catatan:</strong>
                        <p id="alasan"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    // VIEW
    <script>
            document.addEventListener('DOMContentLoaded', function () {
            var modalView = document.getElementById('modalView');

            modalView.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                // Ambil data dari tombol yang diklik
                var doc = button.getAttribute('data-doc');
                var uraian = button.getAttribute('data-uraian');
                var speck = button.getAttribute('data-speck');
                var satuan = button.getAttribute('data-satuan');
                var akun_belanja = button.getAttribute('data-akun_belanja');
                var rekening_1 = button.getAttribute('data-rekening_1');
                var ket = button.getAttribute('data-ket');
                var user = button.getAttribute('data-user');
                var alasan = button.getAttribute('data-alasan');

                // Isi data ke dalam modal
                modalView.querySelector('#doc').textContent = doc;
                modalView.querySelector('#uraian').textContent = uraian;
                modalView.querySelector('#speck').textContent = speck;
                modalView.querySelector('#satuan').textContent = satuan;
                modalView.querySelector('#akun_belanja').textContent = akun_belanja;
                modalView.querySelector('#rekening_1').textContent = rekening_1;
                modalView.querySelector('#ket').textContent = ket;
                modalView.querySelector('#user').textContent = user;
                modalView.querySelector('#alasan').textContent = alasan;

                // Warna merah jika Ditolak
                var ketElement = modalView.querySelector('#ket');
                if (ket === 'Ditolak') {
                    ketElement.style.color = 'red';
                } else {
                    ketElement.style.color = '';
                }
            });
        });
    </script>
@endpush
