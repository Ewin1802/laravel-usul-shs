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
        :root {

            --primary: #0f766e;
            --primary-light: #14b8a6;

            --secondary: #0ea5e9;

            --gold: #d4af37;

            --white: #ffffff;

            --text: #eef4f8;

            --text-light: #d7e3ea;

            --dark: #08131f;

            --glass: rgba(255, 255, 255, .08);

            --glass-border: rgba(255, 255, 255, .10);

            --shadow:
                0 20px 60px rgba(0, 0, 0, .28);

            --radius: 24px;

        }

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

        }

        html {

            scroll-behavior: smooth;

        }

        body {

            font-family: 'Poppins', sans-serif;

            color: var(--text);

            min-height: 100vh;

            overflow-x: hidden;

            background:

                linear-gradient(130deg,
                    rgba(5, 15, 32, .86),
                    rgba(5, 30, 48, .74),
                    rgba(2, 70, 78, .62)),

                url('{{ asset('img/peta.webp') }}');

            background-size: cover;

            background-position: center;

            background-attachment: fixed;

        }

        body::before {

            content: "";

            position: fixed;

            inset: 0;

            pointer-events: none;

            background:

                radial-gradient(circle at top right,
                    rgba(20, 184, 166, .16),
                    transparent 30%),

                radial-gradient(circle at bottom left,
                    rgba(14, 165, 233, .12),
                    transparent 35%);

        }

        img {

            max-width: 100%;

            display: block;

        }

        a {

            text-decoration: none;

        }

        .container {

            width: min(92%, 1280px);

            margin: auto;

        }

        /*======================
HEADER
======================*/

        header {

            position: sticky;

            top: 0;

            z-index: 999;

            padding: 18px 0;

        }

        .navbar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 40px;

            padding: 18px 32px;

            border-radius: 22px;

            background: rgba(8, 20, 35, .60);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, .08);

            box-shadow: var(--shadow);

        }

        .logo {

            display: flex;

            align-items: center;

        }

        .logo img {

            height: 60px;

            transition: .35s;

        }

        .logo img:hover {

            transform: scale(1.05);

        }

        nav {

            display: flex;

            align-items: center;

            gap: 10px;

        }

        nav a {

            color: white;

            padding: 12px 18px;

            border-radius: 12px;

            font-weight: 500;

            transition: .35s;

        }

        nav a:hover {

            background: rgba(255, 255, 255, .08);

            color: #7dd3fc;

        }

        .menu-toggle {

            display: none;

            color: white;

            font-size: 32px;

            cursor: pointer;

        }

        /*======================
BUTTON
======================*/

        .btn {

            padding: 15px 32px;

            border: none;

            cursor: pointer;

            border-radius: 999px;

            font-weight: 600;

            font-size: .95rem;

            transition: .35s;

        }

        .btn-primary {

            color: white;

            background:

                linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));

            box-shadow:

                0 15px 35px rgba(15, 118, 110, .35);

        }

        .btn-primary:hover {

            transform: translateY(-4px);

        }

        .btn-outline {

            background: transparent;

            color: white;

            border: 1px solid rgba(255, 255, 255, .18);

        }

        .btn-outline:hover {

            background: white;

            color: #111827;

        }

        /*======================
SECTION
======================*/

        section {

            position: relative;

        }

        .section {

            margin-top: 90px;

            padding: 60px;

            border-radius: 30px;

            background: rgba(9, 20, 38, .52);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, .08);

            box-shadow: var(--shadow);

        }

        .section h2 {

            font-size: 2rem;

            margin-bottom: 25px;

        }

        .section p {

            color: var(--text-light);

            line-height: 2;

        }

        /*======================
MODAL
======================*/

        .modal {

            display: none;

            position: fixed;

            inset: 0;

            background: rgba(0, 0, 0, .72);

            justify-content: center;

            align-items: center;

            z-index: 9999;

            backdrop-filter: blur(8px);

        }

        .modal-box {

            width: min(620px, 92%);

            background: white;

            color: #1f2937;

            border-radius: 26px;

            padding: 40px;

        }

        .modal-box h3 {

            margin-bottom: 20px;

        }

        .modal-box ol {

            line-height: 2;

        }

        .modal-box button {

            margin-top: 25px;

            padding: 12px 24px;

            border: none;

            border-radius: 12px;

            cursor: pointer;

            color: white;

            background:

                linear-gradient(135deg,
                    var(--primary),
                    var(--secondary));

        }

        /*======================
FOOTER
======================*/

        footer {

            padding: 50px 20px;

            text-align: center;

            color: #cbd5e1;

        }

        /*=================================================
HERO
=================================================*/

        .hero {

            min-height: 82vh;

            display: grid;

            grid-template-columns: 1.1fr .9fr;

            align-items: center;

            gap: 70px;

            padding: 70px 0;

        }

        .hero-left {

            position: relative;

            z-index: 2;

        }

        .hero-badge {

            display: inline-flex;

            align-items: center;

            gap: 10px;

            padding: 10px 20px;

            margin-bottom: 28px;

            border-radius: 999px;

            background: rgba(20, 184, 166, .12);

            border: 1px solid rgba(20, 184, 166, .25);

            color: #bff8ef;

            font-size: .85rem;

            font-weight: 600;

        }

        .hero-title {

            font-size: 3.5rem;

            font-weight: 700;

            line-height: 1.18;

            margin-bottom: 28px;

            color: white;

        }

        .hero-title span {

            background:

                linear-gradient(90deg,
                    #ffffff,
                    #8ef6ff,
                    #14b8a6);

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;

        }

        .hero-description {

            color: var(--text-light);

            line-height: 2;

            font-size: 1.02rem;

            margin-bottom: 18px;

            max-width: 620px;

        }

        .hero-buttons {

            display: flex;

            gap: 16px;

            flex-wrap: wrap;

            margin-top: 35px;

        }

        .hero-feature {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 18px;

            margin-top: 55px;

        }

        .hero-card {

            background: rgba(255, 255, 255, .06);

            border: 1px solid rgba(255, 255, 255, .08);

            border-radius: 20px;

            padding: 22px;

            transition: .35s;

            backdrop-filter: blur(15px);

        }

        .hero-card:hover {

            transform: translateY(-8px);

            background: rgba(255, 255, 255, .10);

        }

        .hero-card h4 {

            color: white;

            font-size: 1rem;

            margin-bottom: 8px;

        }

        .hero-card p {

            color: #cbd5e1;

            font-size: .88rem;

            line-height: 1.6;

        }

        .hero-right {

            position: relative;

        }

        .hero-image {

            position: relative;

            overflow: hidden;

            border-radius: 28px;

            border: 1px solid rgba(255, 255, 255, .08);

            box-shadow:

                0 30px 70px rgba(0, 0, 0, .35);

        }

        .hero-image img {

            width: 100%;

            transition: .6s;

        }

        .hero-image:hover img {

            transform: scale(1.05);

        }

        .hero-right::before {

            content: "";

            position: absolute;

            width: 250px;

            height: 250px;

            border-radius: 50%;

            background: rgba(20, 184, 166, .25);

            filter: blur(90px);

            right: -60px;

            top: -50px;

        }

        .hero-right::after {

            content: "";

            position: absolute;

            width: 180px;

            height: 180px;

            border-radius: 50%;

            background: rgba(14, 165, 233, .20);

            filter: blur(80px);

            left: -40px;

            bottom: -30px;

        }

        @media(max-width:992px) {

            .hero {

                grid-template-columns: 1fr;

                text-align: center;

            }

            .hero-description {

                margin: auto;

            }

            .hero-buttons {

                justify-content: center;

            }

            .hero-feature {

                grid-template-columns: repeat(3, 1fr);

            }

        }

        @media(max-width:768px) {

            .hero {

                padding: 35px 0 50px;

                gap: 40px;

            }

            .hero-title {

                font-size: 2.3rem;

            }

            .hero-feature {

                grid-template-columns: 1fr;

            }

            .hero-description {

                font-size: .95rem;

            }

        }

        /*======================
        RESPONSIVE
        ======================*/

        @media(max-width:992px) {

            .navbar {

                padding: 16px 22px;

            }

        }

        @media(max-width:768px) {

            .menu-toggle {

                display: block;

            }

            nav {

                display: none;

                width: 100%;

                margin-top: 20px;

                padding-top: 20px;

                border-top: 1px solid rgba(255, 255, 255, .08);

                flex-direction: column;

                gap: 10px;

            }

            nav.active {

                display: flex;

            }

            nav a {

                width: 100%;

                text-align: center;

            }

            .section {

                padding: 35px 25px;

            }

        }

        /*==================================================
HEADER PREMIUM
==================================================*/

        header {

            position: sticky;

            top: 18px;

            z-index: 999;

        }

        .navbar {

            position: relative;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 30px;

            min-height: 82px;

            padding: 14px 28px;

        }

        .logo {

            display: flex;

            align-items: center;

            gap: 18px;

        }

        .logo a {

            display: flex;

            align-items: center;

        }

        .logo img {

            height: 62px;

            width: auto;

            transition: .35s;

        }

        .logo img:hover {

            transform: scale(1.05);

        }

        nav {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-left: auto;

        }

        nav a {

            position: relative;

            padding: 13px 20px;

            border-radius: 14px;

            color: white;

            font-size: .95rem;

            font-weight: 500;

            transition: .35s;

        }

        nav a::after {

            content: "";

            position: absolute;

            left: 18px;

            right: 18px;

            bottom: 8px;

            height: 2px;

            border-radius: 50px;

            background: linear-gradient(90deg,
                    var(--primary),
                    var(--secondary));

            transform: scaleX(0);

            transition: .35s;

        }

        nav a:hover {

            background: rgba(255, 255, 255, .08);

        }

        nav a:hover::after {

            transform: scaleX(1);

        }

        .menu-toggle {

            display: none;

            width: 52px;

            height: 52px;

            border-radius: 16px;

            background: rgba(255, 255, 255, .08);

            border: 1px solid rgba(255, 255, 255, .10);

            justify-content: center;

            align-items: center;

            cursor: pointer;

            transition: .3s;

        }

        .menu-toggle:hover {

            background: rgba(255, 255, 255, .14);

        }

        @media(max-width:992px) {

            nav {

                gap: 6px;

            }

            nav a {

                padding: 12px 16px;

                font-size: .9rem;

            }

        }

        @media(max-width:768px) {

            header {

                top: 10px;

            }

            .navbar {

                flex-wrap: wrap;

                padding: 18px;

            }

            .logo img {

                height: 54px;

            }

            .menu-toggle {

                display: flex;

                margin-left: auto;

            }

            nav {

                display: none;

                width: 100%;

                margin-top: 20px;

                padding: 18px;

                border-radius: 18px;

                background: rgba(7, 17, 31, .92);

                backdrop-filter: blur(16px);

                border: 1px solid rgba(255, 255, 255, .08);

                flex-direction: column;

                gap: 8px;

            }

            nav.active {

                display: flex;

                animation: fadeMenu .35s ease;

            }

            nav a {

                width: 100%;

                padding: 15px;

                text-align: center;

                border-radius: 14px;

            }

        }

        @keyframes fadeMenu {

            from {

                opacity: 0;

                transform: translateY(-12px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

            }

        }

        /*==================================================
REGULATION SECTION
==================================================*/

        .section-header {

            text-align: center;

            max-width: 900px;

            margin: 0 auto 60px;

        }

        .section-subtitle {

            display: inline-flex;

            align-items: center;

            gap: 10px;

            padding: 10px 22px;

            border-radius: 999px;

            margin-bottom: 20px;

            background: rgba(20, 184, 166, .10);

            border: 1px solid rgba(20, 184, 166, .25);

            color: #a7f3d0;

            font-size: .82rem;

            font-weight: 600;

            letter-spacing: .8px;

            text-transform: uppercase;

        }

        .section-title {

            font-size: 2.4rem;

            color: white;

            margin-bottom: 20px;

        }

        .section-description {

            color: var(--text-light);

            line-height: 2;

            max-width: 760px;

            margin: auto;

        }

        .rule-grid {

            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 30px;

            margin-top: 45px;

        }

        .rule-card {

            position: relative;

            padding: 35px;

            border-radius: 24px;

            overflow: hidden;

            background: rgba(255, 255, 255, .05);

            border: 1px solid rgba(255, 255, 255, .08);

            transition: .35s;

            backdrop-filter: blur(18px);

        }

        .rule-card::before {

            content: "";

            position: absolute;

            left: 0;

            top: 0;

            width: 6px;

            height: 100%;

            background: linear-gradient(180deg,

                    var(--primary),

                    var(--secondary));

        }

        .rule-card:hover {

            transform: translateY(-10px);

            background: rgba(255, 255, 255, .08);

            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);

        }

        .rule-number {

            width: 54px;

            height: 54px;

            border-radius: 18px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 25px;

            background: linear-gradient(135deg,

                    var(--primary),

                    var(--secondary));

            color: white;

            font-weight: 700;

            font-size: 1.1rem;

        }

        .rule-card h3 {

            color: white;

            margin-bottom: 18px;

            font-size: 1.2rem;

        }

        .rule-card p {

            color: var(--text-light);

            line-height: 2;

        }

        @media(max-width:900px) {

            .rule-grid {

                grid-template-columns: 1fr;

            }

            .section-title {

                font-size: 2rem;

            }

        }

        @media(max-width:768px) {

            .rule-card {

                padding: 28px;

            }

            .section-header {

                margin-bottom: 40px;

            }

        }
    </style>
</head>

<body>

    <header>

        <div class="container">

            <div class="navbar">

                <div class="logo">

                    <a href="#">

                        <img src="{{ asset('img/logo_usaha.png') }}" alt="USAHA">

                    </a>

                </div>

                <nav id="nav-menu">

                    <a href="https://sipd-ri.kemendagri.go.id/auth/login">

                        SIPD-RI

                    </a>

                    <a href="https://bolaangmongondowutara.e-bmd.co.id/">

                        E-BMD

                    </a>

                    <a href="#">

                        RK-BMD

                    </a>

                    <a href="#">

                        LELANG-BMD

                    </a>

                </nav>

                <div class="menu-toggle" onclick="toggleMenu()">

                    ☰

                </div>

            </div>

        </div>

    </header>


    <section class="hero container">

        <div class="hero-left" data-aos="fade-right">

            <div class="hero-badge">

                Kabupaten Bolaang Mongondow Utara

            </div>

            <h1 class="hero-title">

                Usulan

                <span>

                    Standar Harga Satuan

                </span>

            </h1>

            <p class="hero-description">

                Website ini digunakan untuk mendukung proses pengusulan Standar Harga Satuan (SHS) agar lebih mudah
                serta file surat usulan tidak mudah hilang dan dapat diakses kapan saja selama koneksi internet
                tersedia.

            </p>

            <p class="hero-description">

                Dalam perencanaan Anggaran Pendapatan dan Belanja Daerah, SHS merupakan batasan tertinggi yang tidak
                dapat dilampaui kecuali dalam kondisi tertentu seperti perubahan aturan SHSR atau kenaikan harga pasar.

            </p>

            <div class="hero-buttons">

                <form action="{{ route('login') }}" method="GET">

                    <button class="btn btn-primary">

                        Mulai

                    </button>

                </form>

                <button class="btn btn-outline" onclick="openModal()">

                    Petunjuk

                </button>

            </div>

            <div class="hero-feature">

                <div class="hero-card">

                    <h4>

                        Perencanaan

                    </h4>

                    <p>

                        Mendukung penyusunan usulan SHS secara terstruktur.

                    </p>

                </div>

                <div class="hero-card">

                    <h4>

                        Arsip Digital

                    </h4>

                    <p>

                        Dokumen usulan tersimpan dengan aman dan mudah dicari.

                    </p>

                </div>

                <div class="hero-card">

                    <h4>

                        Transparan

                    </h4>

                    <p>

                        Seluruh proses dapat dipantau dengan lebih mudah.

                    </p>

                </div>

            </div>

        </div>

        <div class="hero-right" data-aos="zoom-in">

            <div class="hero-image">

                <img src="{{ asset('img/sjlmap.jpg') }}" alt="SHS">

            </div>

        </div>

    </section>



    <section class="section container" data-aos="fade-up">

        <div class="section-header">

            <span class="section-subtitle">

                LANDASAN HUKUM

            </span>

            <h2 class="section-title">

                Landasan Aturan SHS Regional
                (Perpres No 72 Tahun 2025)

            </h2>

            <p class="section-description">

                Kepala Daerah dapat menambah item belanja lain yang tidak diatur
                dalam Perpres dengan menggunakan standar harga yang wajar,
                efisien, transparan, dan akuntabel untuk menghindari
                perbedaan harga yang ekstrem.

            </p>

        </div>

        <div class="rule-grid">

            <div class="rule-card" data-aos="fade-up" data-aos-delay="100">

                <div class="rule-number">

                    01

                </div>

                <h3>

                    Perpres No 72 Tahun 2025

                </h3>

                <p>

                    Hal ini disebutkan pada
                    Perpres Nomor 72 Tahun 2025
                    tentang SHSR Pasal 3.

                </p>

            </div>

            <div class="rule-card" data-aos="fade-up" data-aos-delay="200">

                <div class="rule-number">

                    02

                </div>

                <h3>

                    Pasal 3 Ayat (1)

                </h3>

                <p>

                    Kepala daerah menetapkan standar harga satuan biaya
                    honorarium, perjalanan dinas dalam negeri,
                    rapat atau pertemuan di dalam dan di luar kantor,
                    pengadaan kendaraan dinas,
                    dan pemeliharaan berpedoman pada standar harga satuan
                    regional sebagaimana diatur dalam Pasal 1 dengan
                    memperhatikan prinsip efisiensi,
                    efektivitas, kepatutan,
                    dan kewajaran.

                </p>

            </div>

            <div class="rule-card" data-aos="fade-up" data-aos-delay="300">

                <div class="rule-number">

                    03

                </div>

                <h3>

                    Pasal 3 Ayat (2)

                </h3>

                <p>

                    Kepala daerah dapat menetapkan standar harga satuan
                    selain sebagaimana dimaksud pada ayat (1)
                    dengan memperhatikan prinsip efisiensi,
                    efektivitas,
                    kepatutan,
                    dan kewajaran
                    sesuai ketentuan peraturan perundang-undangan.

                </p>

            </div>

            <div class="rule-card" data-aos="fade-up" data-aos-delay="400">

                <div class="rule-number">

                    04

                </div>

                <h3>

                    Tujuan Penerapan SHS

                </h3>

                <p>

                    Standar Harga Satuan menjadi pedoman
                    dalam proses perencanaan dan penganggaran daerah
                    sehingga penyusunan belanja lebih efisien,
                    transparan,
                    serta dapat dipertanggungjawabkan.

                </p>

            </div>

        </div>

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
                <li>Hubungi Admin BMD untuk akses SKPD.</li>
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

</html>
