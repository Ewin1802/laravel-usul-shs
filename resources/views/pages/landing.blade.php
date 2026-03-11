<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USAHA | Usulan Standar Harga</title>

    <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('{{ asset('img/peta.webp') }}') center/cover fixed no-repeat;
            color: white;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(6px);
            z-index: -1;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        /* HEADER */

        header {
            padding: 25px 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }

        nav {
            display: flex;
            gap: 25px;
        }

        nav a {
            text-decoration: none;
            color: #eee;
            font-weight: 500;
            transition: .3s;
        }

        nav a:hover {
            color: #00eaff;
        }

        /* HERO */

        .hero {
            padding: 80px 0 60px 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero h1 {
            font-size: 2.4rem;
            margin-bottom: 20px;
        }

        .hero p {
            line-height: 1.7;
            color: #ddd;
            margin-bottom: 25px;
        }

        .hero img {
            width: 100%;
            max-width: 480px;
            margin: auto;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            transition: transform .4s;
        }

        .hero img:hover {
            transform: scale(1.05);
        }

        /* BUTTON */

        .btn {
            padding: 12px 26px;
            border-radius: 30px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: .95rem;
            transition: .3s;
        }

        .btn-primary {
            background: #00c9d8;
            color: white;
        }

        .btn-primary:hover {
            background: #00a9b6;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #00c9d8;
            color: #00eaff;
        }

        .btn-outline:hover {
            background: #00c9d8;
            color: white;
        }

        /* FEATURES */

        .features {
            margin-top: 60px;
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
        }

        .feature {
            padding: 10px 20px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.08);
            font-size: .9rem;
        }

        /* SECTION */

        .section {
            margin-top: 90px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 50px;
            backdrop-filter: blur(10px);
        }

        .section h2 {
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .section p {
            line-height: 1.8;
            color: #ddd;
        }

        /* MODAL */

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background: white;
            color: #333;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
        }

        .modal-box h3 {
            margin-bottom: 15px;
        }

        .modal-box button {
            margin-top: 20px;
            padding: 10px 18px;
            border: none;
            background: #00c9d8;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        /* FOOTER */

        footer {
            margin-top: 80px;
            padding: 30px;
            text-align: center;
            color: #bbb;
            font-size: .85rem;
        }

        /* RESPONSIVE */

        @media(max-width:900px) {

            .hero {
                grid-template-columns: 1fr;
                text-align: center;
            }

            nav {
                justify-content: center;
                margin-top: 10px;
            }

        }
    </style>
</head>

<body>

    <header>
        <div class="container navbar">

            <div class="logo">
                USAHA
            </div>

            <nav>
                <a href="https://sipd-ri.kemendagri.go.id/auth/login">SIPD-RI</a>
                <a href="https://bolaangmongondowutara.e-bmd.co.id/">E-BMD</a>
                <a href="#">RK-BMD</a>
                <a href="#">LELANG-BMD</a>
            </nav>

        </div>
    </header>


    <section class="hero container">

        <div data-aos="fade-right">

            <h1>Usulan Standar Harga Satuan</h1>

            <p>
                Website ini digunakan untuk mendukung proses pengusulan Standar Harga Satuan (SHS) agar lebih mudah
                serta file surat usulan tidak mudah hilang dan dapat diakses kapan saja selama koneksi internet
                tersedia.
            </p>

            <p>
                Dalam perencanaan Anggaran Pendapatan dan Belanja Daerah, SHS merupakan batasan tertinggi yang tidak
                dapat dilampaui kecuali dalam kondisi tertentu seperti perubahan aturan SHSR atau kenaikan harga pasar.
            </p>

            <div style="display:flex;gap:10px;flex-wrap:wrap;">

                <form action="{{ route('login') }}" method="GET">
                    <button class="btn btn-primary">Mulai</button>
                </form>

                <button class="btn btn-outline" onclick="openModal()">Petunjuk</button>

            </div>

            <div class="features">

                <div class="feature">PERENCANAAN</div>
                <div class="feature">PENATAUSAHAAN</div>
                <div class="feature">PEMANFAATAN</div>
                <div class="feature">PENGAMANAN</div>
                <div class="feature">PENGHAPUSAN</div>

            </div>

        </div>

        <div data-aos="zoom-in">
            <img src="{{ asset('img/sjlmap.jpg') }}">
        </div>

    </section>



    <section class="section container" data-aos="fade-up">

        <h2>Landasan Aturan SHS Regional (Perpres No 72 Tahun 2025)</h2>

        <p>

            Kepala Daerah dapat menambah item belanja lain yang tidak diatur dalam Perpres dengan menggunakan standar
            harga yang wajar, efisien, transparan, dan akuntabel untuk menghindari perbedaan harga yang ekstrem.

            <br><br>

            Hal ini disebutkan pada Perpres No 72 Tahun 2025 tentang SHSR Pasal 3:

            <br><br>

            (1) Kepala daerah menetapkan standar harga satuan biaya honorarium, perjalanan dinas dalam negeri, rapat
            atau pertemuan di dalam dan di luar kantor, pengadaan kendaraan dinas, dan pemeliharaan berpedoman pada
            standar harga satuan regional sebagaimana diatur dalam Pasal 1 dengan memperhatikan prinsip efisiensi,
            efektivitas, kepatutan, dan kewajaran.

            <br><br>

            (2) Kepala daerah dapat menetapkan standar harga satuan selain sebagaimana dimaksud pada ayat (1) dengan
            memperhatikan prinsip efisiensi, efektivitas, kepatutan, dan kewajaran sesuai dengan ketentuan peraturan
            perundang-undangan.

        </p>

    </section>



    <footer>

        Sistem Usulan Standar Harga Satuan (USAHA)

    </footer>



    <div id="modal" class="modal">

        <div class="modal-box">

            <h3>Petunjuk</h3>

            <ol>

                <li>Klik tombol <b>Mulai</b> untuk login.</li>

                <li>Registrasi akun terlebih dahulu.</li>

                <li>Hubungi Admin BMD untuk aktivasi akses SKPD.</li>

                <li>Upload surat usulan PDF beserta bukti harga.</li>

                <li>Bukti bisa berupa e-catalogue, online shop, brosur, atau aturan resmi.</li>

            </ol>

            <button onclick="closeModal()">Tutup</button>

        </div>

    </div>



    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        function openModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>

</body>

</html>
