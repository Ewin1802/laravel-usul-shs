@extends('layouts.app')

@section('title', 'Usulan ASB - ADMIN')

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
                <h1>Proses Usulan Analisis Standar Belanja (ASB)</h1>
                <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#yearModal">
                    Download Laporan
                </button>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Proses Usulan</a></div>
                    <div class="breadcrumb-item">Proses Usulan Analisis Standar Belanja</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Petunjuk</h2>
                <p class="section-lead">
                    Anda dapat mengelola semua Usulan Analisis Standar Belanja, seperti mengedit, menghapus, dan lainnya.
                </p>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Usulan Analisis Standar Belanja</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <form method="GET" action="{{ route('asb.admin_asb') }}">
                                        <select class="form-control selectric" name="filter" onchange="this.form.submit()">
                                            <option value="Semua" {{ request('filter') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                            <option value="Usul Baru" {{ request('filter') == 'Usul Baru' ? 'selected' : '' }}>Usul Baru</option>
                                            <option value="Disetujui" {{ request('filter') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="Ditolak" {{ request('filter') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{route('asb.admin_asb')}}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Cari Spek" name="spek">
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
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($admin_asb as $s)
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

                                            {{-- <td>
                                                {{$s->Harga}}
                                            </td> --}}
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
                                            <td>
                                                <div class="dropdown text-center">
                                                    <button class="btn btn-sm btn-secondary" type="button" id="dropdownMenuASB{{ $s->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="dropdownMenuASB{{ $s->id }}">

                                                        {{-- View --}}
                                                        <a href="#"
                                                            class="dropdown-item text-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalView"
                                                            data-doc="{{ $s->Document }}"
                                                            data-uraian="{{ $s->Uraian }}"
                                                            data-speck="{{ $s->Spek }}"
                                                            data-satuan="{{ $s->Satuan }}"
                                                            data-akun_belanja="{{ $s->akun_belanja }}"
                                                            data-rekening_1="{{ $s->rekening_1 }}"
                                                            data-ket="{{ $s->ket }}"
                                                            data-user="{{ $s->user }}"
                                                            data-alasan="{{ $s->alasan }}">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>

                                                        {{-- Edit --}}
                                                        <a href="{{ route('asb_admin.edit', $s->id) }}"
                                                            class="dropdown-item text-info
                                                                @if($s->ket == 'Ditolak' || $s->ket == 'Disetujui' || $s->ket == 'Verified') disabled @endif">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        {{-- Verifikasi --}}
                                                        <a href="#"
                                                            class="dropdown-item text-success
                                                                @if($s->ket == 'Ditolak' || $s->ket == 'Disetujui' || $s->ket == 'Verified') disabled @endif"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalVerifikasi"
                                                            data-url="{{ route('asb.verified', $s->id) }}">
                                                            <i class="fas fa-check-circle"></i> Verifikasi
                                                        </a>

                                                        {{-- Tolak --}}
                                                        <a href="#"
                                                            class="dropdown-item text-warning
                                                                @if($s->ket == 'Ditolak' || $s->ket == 'Disetujui' || $s->ket == 'Verified') disabled @endif"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalTolak"
                                                            data-url="{{ route('asb.tolak', $s->id) }}">
                                                            <i class="fas fa-hand-paper"></i> Tolak
                                                        </a>

                                                        {{-- Hapus --}}
                                                        <form action="{{ route('asb.hapus', $s->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger
                                                                @if($s->ket == 'Disetujui' || $s->ket == 'Verified') disabled @endif">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach

                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $admin_asb->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="modalVerifikasi" tabindex="-1" aria-labelledby="modalVerifikasiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formVerifikasi" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalVerifikasiLabel">Alasan Verifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tolak -->
    <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formTolak" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
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
                        <strong>Status:</strong>
                        <p id="ket"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Diajukan oleh:</strong>
                        <p id="user"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Keterangan Tambahan:</strong>
                        <p id="alasan"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk memilih tahun -->
    <div class="modal fade" id="yearModal" tabindex="-1" role="dialog" aria-labelledby="yearModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="yearModalLabel">Pilih Tahun</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <!-- Form untuk memilih tahun -->
            <form id="yearForm" action="{{ url('/asb/generate-pdf') }}" method="GET" target="_blank">
                <div class="form-group">
                <label for="year">Tahun:</label>
                <select class="form-control" id="year" name="year" required>
                    <option value="" disabled selected>Pilih tahun</option>
                    @php
                    $currentYear = date('Y');
                    for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                        echo "<option value='$year'>$year</option>";
                    }
                    @endphp
                </select>
                </div>
            </form>
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-primary" onclick="submitForm()">Download</button>
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

    {{-- verifikasi --}}
    <script>
            document.addEventListener('DOMContentLoaded', function () {
            var modalVerifikasi = document.getElementById('modalVerifikasi');

            modalVerifikasi.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var url = button.getAttribute('data-url');
                var form = document.getElementById('formVerifikasi');

                // Atur action form dengan URL dinamis
                form.action = url;
            });
        });
    </script>

    // TOLAK
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modalTolak = document.getElementById('modalTolak');
            modalTolak.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var url = button.getAttribute('data-url');
                var form = document.getElementById('formTolak');
                form.action = url;
            });
        });
    </script>

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

                // Isi data ke dalam modal dengan menggunakan textContent
                modalView.querySelector('#doc').textContent = doc;
                modalView.querySelector('#uraian').textContent = uraian;
                modalView.querySelector('#speck').textContent = speck;
                modalView.querySelector('#satuan').textContent = satuan;
                modalView.querySelector('#akun_belanja').textContent = akun_belanja;
                modalView.querySelector('#rekening_1').textContent = rekening_1;
                modalView.querySelector('#ket').textContent = ket;
                modalView.querySelector('#user').textContent = user;
                modalView.querySelector('#alasan').textContent = alasan;

                // Jika nilai ket adalah "Ditolak", ubah warna teks menjadi merah
                var ketElement = modalView.querySelector('#ket');
                if (ket === 'Ditolak') {
                    ketElement.style.color = 'red';
                } else {
                    // Kembalikan ke warna default jika tidak "Ditolak"
                    ketElement.style.color = '';
                }
            });
        });
    </script>

    {{-- pilih tahun --}}
    <script>
        function submitForm() {
            document.getElementById("yearForm").submit();
        }
    </script>

    <script>
        document.querySelectorAll('.dropdown').forEach(function (el) {
            el.addEventListener('shown.bs.dropdown', function (e) {
                const dropdownMenu = e.target.querySelector('.dropdown-menu');
                const rect = dropdownMenu.getBoundingClientRect();

                if (rect.bottom > window.innerHeight) {
                    e.target.classList.add('dropup');
                } else {
                    e.target.classList.remove('dropup');
                }
            });
        });
    </script>


@endpush
