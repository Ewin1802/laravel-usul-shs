@extends('layouts.app')

@section('title', 'Edit Data Kelompok')
{{-- Favicon - Logo web disamping title --}}
<link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
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


@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Ubah Data Kelompok</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses ADMIN</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Kelompok</a></div>
                    <div class="breadcrumb-item">Ubah Data Kelompok</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Petunjuk</h2>

                <ul>
                    <li>Ubah Data Kelompok sesuai dengan Standar Regional.</li>

                </ul>

                <div class="card">
                    <form action="{{ route('kelompok.update', $kel->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Tambahkan ini untuk mengganti metode POST menjadi PUT -->

                        <div class="card-header">
                            <h4>Edit Data SKPD</h4>
                        </div>

                        <div class="card-body">

                            <div class="form-row d-flex">
                                {{-- Kode --}}
                                <div class="form-group flex-fill">
                                    <label for="Kode">Kode <span style="color: red;">*</span></label>
                                    <input type="text"
                                           class="form-control @error('Kode') is-invalid @enderror"
                                           name="Kode"
                                           value="{{ old('Kode', $kel->Kode) }}"
                                           required>
                                    @error('Kode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- Uraian --}}
                                <div class="form-group flex-fill">
                                    <label for="Uraian">Uraian <span style="color: red;">*</span></label>
                                    <input type="text"
                                           class="form-control @error('Uraian') is-invalid @enderror"
                                           name="Uraian"
                                           value="{{ old('Uraian', $kel->Uraian) }}"
                                           required>
                                    @error('Uraian')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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


@endpush
