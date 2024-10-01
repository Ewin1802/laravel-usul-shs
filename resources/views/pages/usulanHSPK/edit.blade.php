@extends('layouts.app')

@section('title', 'Edit Usulan HSPK')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Favicon - Logo web disamping title --}}
<link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Usulan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses ADMIN</a></div>
                    <div class="breadcrumb-item"><a href="#">Usulan HSPK</a></div>
                    <div class="breadcrumb-item">Edit Usulan HSPK</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Petunjuk</h2>

                <ul>
                    <li>Spesifikasi yang diusulkan memang item yang belum pernah ada di SIPD.</li>
                    <li>Jika item sudah ada di SIPD namun rekening belanja tidak sesuai maka TIDAK PERLU membuat usulan baru, silahkan hubungi Admin SHS.</li>
                    <li>Jika dalam proses usulan ingin menggunakan lebih dari satu Rekening Belanja, silahkan hubungi Admin SHS.</li>
                </ul>

                <div class="card">
                    <form action="{{ route('hspk_user.ubah', $usulan->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Tambahkan ini untuk mengganti metode POST menjadi PUT -->

                        <div class="card-header">
                            <h4>Edit Usulan Standar Harga</h4>
                        </div>

                        <div class="card-body">

                            <div class="form-row d-flex">
                                <div class="form-group flex-fill">
                                    <label for="uraian">Komponen <span style="color: red;">*</span></label>
                                    <select name="Uraian" id="uraian" class="form-control select2 @error('Uraian') is-invalid @enderror" required>
                                        <option value="">Pilih Komponen</option>
                                        @foreach($kelompoks as $kelompok)
                                            <option value="{{ $kelompok->Uraian }}" {{ $kelompok->Uraian == $usulan->Uraian ? 'selected' : '' }} data-kode="{{ $kelompok->Kode }}">{{ $kelompok->Uraian }}</option>
                                        @endforeach
                                    </select>
                                    @error('Uraian')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group flex-fill ml-3">
                                    <label>&nbsp;</label>
                                    <input type="text" id="kode_komponen" class="form-control @error('Kode') is-invalid @enderror" name="Kode" value="{{ old('Kode', $usulan->Kode) }}" readonly placeholder="Kode Komponen" required>
                                    @error('Kode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row d-flex">
                                {{-- Spesifikasi --}}
                                <div class="form-group flex-fill">
                                    <label for="uraian">Spesifikasi <span style="color: red;">*</span></label>
                                    <input type="text"
                                           class="form-control @error('Spek') is-invalid @enderror"
                                           name="Spek"
                                           value="{{ old('Spek', $usulan->Spek) }}"
                                           required>
                                    @error('Spek')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- Satuan --}}
                                <div class="form-group flex-fill ml-3">
                                    <label for="satuan">Satuan <span style="color: red;">*</span></label>
                                    <select name="Satuan" id="satuan" class="form-control select2 @error('Satuan') is-invalid @enderror" required>
                                        <option value="">Pilih Satuan</option>
                                        @foreach($satuans as $satuan)
                                            <option value="{{ $satuan->satuan }}" {{ $satuan->satuan == $usulan->Satuan ? 'selected' : '' }}>{{ $satuan->satuan }}</option>
                                        @endforeach
                                    </select>
                                    @error('Satuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Harga --}}
                            <div class="form-group">
                                <label for="uraian">Harga <span style="color: red;">*</span></label>
                                <input type="text"
                                       id="harga"
                                       class="form-control @error('Harga') is-invalid @enderror"
                                       name="Harga"
                                       value="{{ old('Harga', $usulan->Harga) }}"
                                       required>
                                @error('Harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- Nama Akun Belanja --}}
                            <div class="form-group">
                                <label for="akun_belanja">Kode Akun Belanja <span style="color: red;">*</span></label>
                                <select name="akun_belanja" id="belanja" class="form-control select2 @error('akun_belanja') is-invalid @enderror" required>
                                    <option value="">Pilih Belanja</option>
                                    @foreach($belanjas as $kelompok)
                                        <option value="{{ $kelompok->Belanja }}" {{ $kelompok->Belanja == $usulan->akun_belanja ? 'selected' : '' }} data-kode="{{ $kelompok->Rekening }}">{{ $kelompok->Belanja }}</option>
                                    @endforeach
                                </select>
                                @error('akun_belanja')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- Kode Akun Belanja --}}
                            <div class="form-group">
                                <label for="rekening_1">Kode Rekening</label>
                                <input type="text" id="kode_rekening" class="form-control @error('rekening_1') is-invalid @enderror" name="rekening_1" value="{{ old('rekening_1', $usulan->rekening_1) }}" readonly required>
                                @error('rekening_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- Nilai TKDN --}}
                            <div class="form-group">
                                <label for="nilai_tkdn">Nilai Tingkat Komponen Dalam Negeri <span style="color: red;">*</span></label>
                                <input type="number"
                                       id="nilai_tkdn"
                                       class="form-control @error('nilai_tkdn') is-invalid @enderror"
                                       name="nilai_tkdn"
                                       min="41"
                                       max="90"
                                       value="{{ old('nilai_tkdn', $usulan->nilai_tkdn) }}"
                                       required>
                                @error('nilai_tkdn')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- Dasar Surat --}}
                            <div class="form-group">
                                <label for="document">Dasar Surat <span style="color: red;">*</span></label>
                                <select name="Document" id="document" class="form-control select2 @error('Document') is-invalid @enderror" required>
                                    <option value="">Pilih Dasar Surat</option>
                                    @foreach($documents as $doc)
                                        <option value="{{ $doc->judul }}" {{ $doc->judul == $usulan->Document ? 'selected' : '' }}>{{ $doc->judul }}</option>
                                    @endforeach
                                </select>
                                @error('Document')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>


                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    {{-- dokumen --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: "Pilih Uraian",
                allowClear: true,
                minimumResultsForSearch: 0,
                theme: "bootstrap4"
            }).on('select2:open', function() {
                $('.select2-search__field').focus();
            });

            // Ketika uraian dipilih, otomatis isi kolom Kode Komponen
            $('#uraian').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var kode = selectedOption.data('kode');

                $('#kode_komponen').val(kode); // Isi input kode komponen
            });

            // Ketika belanja dipilih, otomatis isi kolom Kode Rekening
            $('#belanja').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var kode = selectedOption.data('kode');

                $('#kode_rekening').val(kode); // Isi input kode rekening
            });
        });
    </script>

    {{-- harga --}}
    <script>
        // Saat mengetik, tambahkan pemisah ribuan
        document.getElementById('harga').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, ''); // Hapus semua karakter kecuali angka

            // Format angka dengan pemisah ribuan
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Update input dengan nilai yang diformat
            e.target.value = value;
        });

        // Saat form di-submit, hapus pemisah ribuan agar nilai yang dikirim hanya angka
        document.querySelector('form').addEventListener('submit', function() {
            let hargaInput = document.getElementById('harga');
            let hargaValue = hargaInput.value.replace(/\./g, ''); // Hapus semua titik
            hargaInput.value = hargaValue; // Update nilai input tanpa titik
        });
    </script>

    <script>
        document.getElementById('belanja').addEventListener('change', function() {
            // Ambil opsi yang dipilih
            var selectedOption = this.options[this.selectedIndex];

            // Ambil nilai data-kode dari opsi yang dipilih
            var kodeRekening = selectedOption.getAttribute('data-kode');

            // Set nilai kode rekening ke input Rekening 1
            document.getElementById('kode_rekening').value = kodeRekening;
        });
    </script>

    <script>
        document.getElementById('usulanForm').addEventListener('submit', function(event) {
            let isValid = true;

            // Cek semua field yang wajib diisi
            this.querySelectorAll('[required]').forEach(function(input) {
                if (!input.value) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Cegah pengajuan form jika ada field yang kosong
            if (!isValid) {
                event.preventDefault();
                alert('Harap isi semua field yang diperlukan.');
            }
        });

        // Isi otomatis Kode Komponen dan Kode Rekening ketika dipilih
        document.getElementById('uraian').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            document.getElementById('kode_komponen').value = selectedOption.dataset.kode || '';
        });

        document.getElementById('belanja').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            document.getElementById('kode_rekening').value = selectedOption.dataset.kode || '';
        });
    </script>

@endpush
