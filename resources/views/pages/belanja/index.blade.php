@extends('layouts.app')

@section('title', 'Rek. Belanja')
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
                <h1>Rekening Belanja</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses Admin</a></div>
                    <div class="breadcrumb-item"><a href="#">Dokumen</a></div>
                    <div class="breadcrumb-item">Rek. Belanja</div>
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
                    Pada halaman ini, Anda dapat melakukan import file excel Rekening Belanja.
                </p>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rekening Belanja</h4>
                            </div>
                            <div class="card-body">
                                {{-- <div class="float-left">
                                    <select class="form-control selectric">
                                        <option>Action For Selected</option>
                                        <option>Move to Draft</option>
                                        <option>Move to Pending</option>
                                        <option>Delete Pemanently</option>
                                    </select>
                                </div> --}}

                                <div class="float-right">
                                    <form method="GET" action="{{ route('belanja.index') }}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Cari Item Belanja" name="belanja" value="{{ request('belanja') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                                    Import Excel File
                                </button>
                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Rekening</th>
                                            <th>Belanja</th>

                                        </tr>
                                        @foreach ($belanjas as $index => $bel)
                                        <tr>
                                            <td>
                                                {{ ($belanjas->currentPage() - 1) * $belanjas->perPage() + $index + 1 }}
                                            </td>
                                            <td>
                                                {{$bel->Rekening}}
                                            </td>
                                            <td>
                                                {{$bel->Belanja}}
                                            </td>


                                        </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $belanjas->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<!-- Modal -->

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Rek Belanja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="importForm" action="{{ route('belanja.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Upload Excel File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

{{--
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Versi penuh -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}


@endpush
