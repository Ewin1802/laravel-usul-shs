@extends('layouts.app')

@section('title', 'Upload Surat Usulan')
{{-- Favicon - Logo web disamping title --}}
<link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Upload Surat Usulan</h1>

                <div class="section-header-breadcrumb">
                    {{-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div> --}}
                    <div class="breadcrumb-item active"><a href="#">Akses SKPD</a></div>
                    <div class="breadcrumb-item"><a href="#">Surat Usulan</a></div>
                    <div class="breadcrumb-item">Upload Surat Usulan</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Petunjuk</h2>
                <ul>
                    <li>Surat Usulan yang diupload harus ditandatangani oleh Pimpinan dan dicap basah.</li>
                    <li>Nomor Surat tidak boleh sama dengan nomor yang pernah digunakan sebelumnya.</li>
                    <li>Tanggal Pengajuan disesuaikan dengan tanggal Surat Usulan.</li>
                    <li>Ukuran Dokumen yang diupload tidak melebihi 2 MB.</li>
                </ul>

                <div class="row justify-content-center mt-5">
                    <div class="col-lg-4">
                        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm rounded bg-light">
                            @csrf
                           

                            <div class="form-group mb-3">
                                <label for="judul" class="form-label">Nomor Surat:</label>
                                <input type="text" name="judul" id="judul" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tgl_pengajuan" class="form-label">Tanggal Pengajuan (disesuaikan dengan Tanggal Surat):</label>
                                <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="pdf_file" class="form-label">Pilih File PDF (ukuran tidak melebihi 2 MB):</label>
                                <input type="file" name="pdf_file" id="pdf_file" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Upload</button>
                        </form>
                    </div>

                    @if ($errors->any())
                        <div class="col-lg-4 mt-3">
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="col-lg-4 mt-3">
                            <div class="alert alert-success">
                                <strong>{{ session('success') }}</strong>
                            </div>
                        </div>
                    @endif
                </div>


                {{-- <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="judul">Nomor Surat:</label>
                        <input type="text" name="judul" id="judul" required>
                    </div>
                    <div>
                        <label for="tgl_pengajuan">Tanggal Pengajuan (disesuaikan dengan Tanggal Surat):</label>
                        <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" required>
                    </div>
                    <div>
                        <label for="pdf_file">Pilih File PDF (tidak bisa melebihi 2 MB):</label>
                        <input type="file" name="pdf_file" id="pdf_file" required>
                    </div>
                    <button type="submit">Upload</button>
                </form> --}}
            </div>
        </div>
    </section>
</div>
@endsection
