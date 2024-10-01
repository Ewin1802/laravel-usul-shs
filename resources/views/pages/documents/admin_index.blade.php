@extends('layouts.app')

@section('title', 'Documents')
{{-- Favicon - Logo web disamping title --}}
<link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dokumen Surat Usulan</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Akses ADMIN</a></div>
                    <div class="breadcrumb-item"><a href="#">Surat Usulan</a></div>
                    <div class="breadcrumb-item">Dokumen Surat Usulan</div>
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
                    Semua Surat Usulan.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Semua Dokumen Surat Usulan</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('docs_admin') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Cari Dasar Surat" name="judul">
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
                                            <th>SKPD</th>
                                            <th>Nomor Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Diajukan oleh</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($docs as $doc)
                                        <tr>
                                            <td>{{ $doc->skpd }}</td>
                                            <td>{{ $doc->judul }}</td>
                                            <td>{{ $doc->tgl_pengajuan }}</td>
                                            <td>{{ $doc->user }}</td>
                                            <td>
                                                <button class="btn btn-primary" onclick="showPDFModal('{{ $doc->file_path }}')">Preview</button>
                                                <button class="btn btn-success" onclick="downloadPDF('{{ $doc->file_path }}', '{{ $doc->file_name }}')">Download</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $docs->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="pdf-controls" class="d-flex justify-content-between align-items-center mb-2">
                        <button id="prev-page" class="btn btn-secondary">Previous</button>
                        <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
                        <button id="next-page" class="btn btn-secondary">Next</button>
                    </div>
                    <canvas id="pdf-canvas"></canvas>
                    <div id="pdf-loader">Loading PDF...</div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script>
        let pdfDoc = null,
            pageNum = 1,
            pageIsRendering = false,
            pageNumIsPending = null;

        const scale = 1.2,
              canvas = document.getElementById('pdf-canvas'),
              ctx = canvas.getContext('2d');

        function renderPage(num) {
            pageIsRendering = true;

            // Get page
            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({ scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderCtx = {
                    canvasContext: ctx,
                    viewport
                };

                page.render(renderCtx).promise.then(() => {
                    pageIsRendering = false;

                    if (pageNumIsPending !== null) {
                        renderPage(pageNumIsPending);
                        pageNumIsPending = null;
                    }
                });

                // Output current page
                document.getElementById('page-num').textContent = num;
            });

            document.getElementById('pdf-loader').style.display = 'none';
        }

        function queueRenderPage(num) {
            if (pageIsRendering) {
                pageNumIsPending = num;
            } else {
                renderPage(num);
            }
        }

        function showPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }

        function showNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }

        let pdfDocUrl = ''; // Variabel global untuk menyimpan URL PDF

        function showPDFModal(pdfUrl) {
            pdfDocUrl = pdfUrl; // Menyimpan URL PDF

            document.getElementById('pdf-loader').style.display = 'block';

            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                document.getElementById('page-count').textContent = pdfDoc.numPages;

                pageNum = 1;
                renderPage(pageNum);

                // Menampilkan modal
                var myModal = new bootstrap.Modal(document.getElementById('pdfModal'), {
                    keyboard: false
                });
                myModal.show();
            }).catch(function(error) {
                console.error('Error during PDF loading: ' + error);
                document.getElementById('pdf-loader').style.display = 'none';
            });
        }

        function downloadPDF(pdfUrl, fileName) {
            const link = document.createElement('a');
            link.href = pdfUrl;
            link.download = fileName; // Menggunakan nama file yang diambil dari parameter
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }


        // document.getElementById('download-pdf').addEventListener('click', function() {
        //     downloadPDF(pdfDocUrl);
        // });

        document.getElementById('prev-page').addEventListener('click', showPrevPage);
        document.getElementById('next-page').addEventListener('click', showNextPage);
    </script>
@endpush
