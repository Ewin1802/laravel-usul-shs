<!-- <!DOCTYPE html>
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
            transition: background-position 0.2s ease-out;

            background:
                linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)),
                url('{{ asset('img/peta.webp') }}');

            background-size: cover;
            background-attachment: fixed;
            background-position: center;

            color: white;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        /* HEADER */

        header {
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(12px);
        }

        .navbar {
            position:relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 25px;
            flex-wrap: wrap;

            background: rgba(255, 255, 255, 0.05);
            border-radius: 14px;

            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.15);

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
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
            font-size: 2.6rem;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #ffffff, #00eaff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            line-height: 1.8;
            color: #ddd;
            max-width: 520px;
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
            background: #00eaff;
            color: #00373b;
            box-shadow:
                0 0 10px #00eaff,
                0 0 20px #00eaff,
                0 0 40px #00eaff;

            transition: .3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);

            box-shadow:
                0 0 20px #00eaff,
                0 0 40px #00eaff,
                0 0 60px #00eaff;
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
        .menu-toggle {
            display: none;
            font-size: 30px;
            cursor: pointer;
            color: white;
        }

        /* RESPONSIVE */

        @media(max-width:768px) {

            .menu-toggle {
                display: block;
            }

            nav {
                display: none;
                width: 100%;
                flex-direction: column;
                gap: 12px;

                background: rgba(0, 0, 0, 0.9);
                backdrop-filter: blur(10px);

                margin-top: 15px;
                padding: 15px;
                border-radius: 10px;
            }

            nav.active {
                display: flex;
            }

            nav a {
                padding: 10px;
                font-size: 16px;
            }

            .hero {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        .logo img {
            height: 55px;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.9)) drop-shadow(0 0 20px rgba(255, 255, 255, 0.6));
            transition: 0.3s;
        }

        .logo img:hover {
            filter: drop-shadow(0 0 15px rgba(255, 255, 255, 1)) drop-shadow(0 0 30px rgba(255, 255, 255, 0.8));
        }


    </style>
</head>

<body>

    <header>
        <div class="container navbar">

            <div class="logo">
                <a href="#">
                    <img src="{{ asset('img/logo_usaha.png') }}" alt="Logo Usaha">
                </a>
            </div>

            <nav id="nav-menu">
                <a href="https://sipd-ri.kemendagri.go.id/auth/login">SIPD-RI</a>
                <a href="https://bolaangmongondowutara.e-bmd.co.id/">E-BMD</a>
                <a href="#">RK-BMD</a>
                <a href="#">LELANG-BMD</a>
            </nav>

            <div class="menu-toggle" onclick="toggleMenu()">
                ☰
            </div>

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
    <script>
        document.addEventListener("mousemove", function(e) {

            let x = (e.clientX / window.innerWidth) * 10;
            let y = (e.clientY / window.innerHeight) * 10;

            document.body.style.backgroundPosition =
                `${50 - x}% ${50 - y}%`;

        });
    </script>
    <script>
        function toggleMenu() {
            document.getElementById("nav-menu").classList.toggle("active");
        }
    </script>

</body>

</html> -->
