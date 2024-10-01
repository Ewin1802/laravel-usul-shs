@extends('layouts.app')

@section('title', 'Buat Usulan Baru')

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
                <h1>Buat Usulan Baru ASB</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses SKPD</a></div>
                    <div class="breadcrumb-item"><a href="#">Usulan ASB</a></div>
                    <div class="breadcrumb-item">Buat Usulan ASB</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Petunjuk</h2>
                {{-- <p class="section-lead">Buat Usulan Baru disini</p> --}}
                <ul>
                    <li>Item yang diinput pada halaman ini berdasarkan surat usulan yang Anda upload sebelumnya, jika terdapat item yang diinput tidak sesuai dengan dasar surat maka tidak akan disetujui.</li>
                    <li>Spesifikasi yang diusulkan memang item yang belum pernah ada di SIPD.</li>
                    <li>Jika item sudah ada di SIPD namun rekening belanja tidak sesuai maka TIDAK PERLU membuat usulan baru, silahkan hubungi Admin BMD BPKPD.</li>
                    <li>Jika dalam proses usulan ingin menggunakan lebih dari satu Rekening Belanja, silahkan hubungi Admin BMD BPKPD.</li>
                </ul>

                <div class="card">
                    <form action="{{ route('asb.store')}}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>Form Usulan Analisis Standar Belanja</h4>
                        </div>

                        <div class="card-body">

                            <div class="form-row d-flex">
                                <div class="form-group flex-fill">
                                    <label for="uraian">Komponen <span style="color: red;">*</span></label>
                                    <select name="Uraian" id="uraian" class="form-control select2 @error('Uraian') is-invalid @enderror" required>
                                        <option value="">Pilih Komponen</option>
                                        @foreach($kelompoks as $kelompok)
                                            <option value="{{ $kelompok->Uraian }}" data-kode="{{ $kelompok->Kode }}">{{ $kelompok->Uraian }}</option>
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
                                    <input type="text" id="kode_komponen" class="form-control @error('Kode') is-invalid @enderror" name="Kode" readonly placeholder="Kode Komponen" required>
                                    @error('Kode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row d-flex">
                                <div class="form-group flex-fill">
                                    <label for="uraian">Spesifikasi <span style="color: red;">*</span></label>
                                    <input type="text"
                                           class="form-control @error('Spek') is-invalid @enderror"
                                           name="Spek" required>
                                    @error('Spek')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group flex-fill ml-3">
                                    <label for="satuan">Satuan <span style="color: red;">*</span></label>
                                    <select name="Satuan" id="satuan" class="form-control select2 @error('Satuan') is-invalid @enderror" required>
                                        <option value="">Pilih Satuan</option>
                                        @foreach($satuans as $satuan)
                                            <option value="{{ $satuan->satuan }}">{{ $satuan->satuan }}</option>
                                        @endforeach
                                    </select>
                                    @error('Satuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="uraian">Harga <span style="color: red;">*</span></label>
                                <input type="text"
                                id="harga"
                                class="form-control
                                @error('Harga')
                                    is-invalid
                                @enderror"
                                name="Harga" required>
                                @error('Harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Belanja">Kode Akun Belanja <span style="color: red;">*</span></label>
                                <select name="akun_belanja" id="belanja" class="form-control select2 @error('akun_belanja') is-invalid @enderror" required>
                                    <option value="">Pilih Belanja</option>
                                    @foreach($belanjas as $kelompok)
                                        <option value="{{ $kelompok->Belanja }}" data-kode="{{ $kelompok->Rekening }}">{{ $kelompok->Belanja }}</option>
                                    @endforeach
                                </select>
                                @error('akun_belanja')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="rekening_1">Kode Rekening</label>
                                <input type="text" id="kode_rekening" class="form-control @error('rekening_1') is-invalid @enderror" name="rekening_1" readonly required>
                                @error('rekening_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nilai_tkdn">Nilai Tingkat Komponen Dalam Negeri (input Harus di atas 40 dan tidak bisa melebihi 90) <span style="color: red;">*</span></label>
                                <input type="number"
                                       id="nilai_tkdn"
                                       class="form-control @error('nilai_tkdn') is-invalid @enderror"
                                       name="nilai_tkdn"
                                       min="41"
                                       max="90"
                                       step="1"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                @error('nilai_tkdn')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="document">Dasar Surat <span style="color: red;">*</span></label>
                                <select name="Document" id="document" class="form-control select2 @error('Document') is-invalid @enderror" required>
                                    <option value="">Pilih Dasar Surat</option>
                                    @foreach($documents as $doc)
                                        <option value="{{ $doc->judul }}">{{ $doc->judul }}</option>
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

    <script>
            $(document).ready(function() {
            // Inisialisasi Select2 untuk dropdown 'Uraian' dan 'Belanja'
            $('.select2').select2({
                placeholder: "Pilih Uraian",
                allowClear: true,
                minimumResultsForSearch: 0,
                theme: "bootstrap4"
            }).on('select2:open', function() {
                $('.select2-search__field').focus();
            });

            // Ketika opsi Uraian dipilih, otomatis isi kolom Kode Komponen
            $('#uraian').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var kode = selectedOption.data('kode'); // Ambil data-kode dari opsi yang dipilih

                // Isi input 'kode_komponen' dengan nilai 'kode' yang diambil
                $('#kode_komponen').val(kode);
            });

            // Ketika opsi Belanja dipilih, otomatis isi kolom Kode Rekening
            $('#belanja').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var kode = selectedOption.data('kode'); // Ambil data-kode dari opsi yang dipilih

                // Isi input 'rekening_1' dengan kode rekening yang sesuai
                $('#kode_rekening').val(kode);
            });

            // Submit form dan pastikan nilai yang benar dikirim
            $('form').on('submit', function(e) {
                let isValid = true;

                // Cek semua field yang wajib diisi
                $(this).find('[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault(); // Cegah submit jika ada field yang kosong
                    alert('Harap isi semua field yang diperlukan.');
                }
            });
        });
    </script>

    <script>
        document.getElementById('harga').addEventListener('input', function(e) {
            // Hanya izinkan input angka
            let value = e.target.value.replace(/[^0-9]/g, '');

            // Format angka dengan pemisah ribuan
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Update input dengan nilai yang diformat
            e.target.value = value;
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
