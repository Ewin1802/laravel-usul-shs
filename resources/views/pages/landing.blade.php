<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Selamat Datang | UsahaBolmut</title>
  <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      color: white;
      background-image: url('{{ asset('img/peta.webp') }}');
      /* background-image: url('{{ asset('img/peta.jpg') }}'); */
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      position: relative;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      z-index: 0;
      backdrop-filter: blur(1.5px);
    }

    header, section, .features {
      position: relative;
      z-index: 1;
    }

    /* SPINNER STYLES */
    #loading-spinner {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: transparent; /* Tidak ada background hitam */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease;
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 6px solid rgba(255, 255, 255, 0.3); /* Warna putih semi-transparan */
        border-top: 6px solid #b0d9f9; /* Biru muda tema kamu */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }



    /* HEADER */
    header {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem 4rem;
    }

    .logo {
      font-family: 'Poppins', sans-serif;
      font-size: 2.5rem;
      color: #b0d9f9;
      margin-bottom: 10px;
      text-align: center;
    }

    nav {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
    }

    nav a {
      text-decoration: none;
      color: #ffffff;
      font-weight: 600;
      font-size: 1.1rem;
      letter-spacing: 0.5px;
      transition: color 0.3s ease, border-bottom 0.3s ease;
      position: relative;
      padding-bottom: 5px;
    }

    nav a::after {
      content: '';
      position: absolute;
      width: 0%;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: #b0d9f9;
      transition: width 0.3s;
    }

    nav a:hover {
      color: #b0d9f9;
    }

    nav a:hover::after {
      width: 100%;
    }

    /* HERO SECTION */
    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 3rem 4rem;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .hero .text {
      max-width: 50%;
    }

    .hero .text h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 2.8rem;
      margin-bottom: 1rem;
    }

    .hero .text p {
      color: #ccc;
      margin-bottom: 1.5rem;
      line-height: 1.6;
    }

    .hero .text .btn-main {
      padding: 12px 25px;
      background-color: #b0d9f9;
      border: none;
      border-radius: 30px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
    }

    .hero .product {
      max-width: 40%;
    }

    .hero .product img {
      width: 300px;
      height: auto;
    }

    /* DETAILS */
    .details {
      padding: 2rem 4rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .details .price {
      font-size: 1.5rem;
      font-weight: bold;
      color: #fff;
      text-align: right;
    }

    .details .stars {
      display: block;
      font-size: 1.2rem;
      color: gold;
      margin-top: 0.5rem;
    }

    /* FEATURES */
    .features {
      text-align: center;
      margin-top: 2rem;
      padding-bottom: 4rem;
    }

    .features span {
      margin: 0 30px;
      font-size: 1rem;
      color: #ddd;
    }
  </style>

  <style>
    @keyframes fadeInScale {
    from {opacity: 0; transform: scale(0.8);}
    to {opacity: 1; transform: scale(1);}
    }
    #audioModal button:hover {
    background-color: #357ABD;
    }
</style>


</head>
<body>

  <!-- LOADING SPINNER -->
  <div id="loading-spinner">
    <div class="spinner"></div>
  </div>

  <!-- HEADER -->
  <header>
    <div class="logo">APLIKASI PENUNJANG BMD</div>
    <nav>
      <a href="https://sipd-ri.kemendagri.go.id/auth/login">SIPD-RI</a>
      <a href="https://bolaangmongondowutara.e-bmd.co.id/">E-BMD</a>
      <a href="#">RK-BMD</a>
      <a href="#">LELANG-BMD</a>
    </nav>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="text">
      <h2>Standar Harga Satuan (SHS)</h2>
      <p>Standar Harga Satuan (SHS) berfungsi sebagai acuan dalam penyusunan Anggaran Belanja Pemerintah Daerah, memastikan efisiensi dan efektivitas penggunaan anggaran, serta mendorong transparansi dan akuntabilitas. <Br><Br>Catatan : Backsound hanya untuk membangkitkan semangat agar ceria setiap waktu.</p>
      {{-- <form action="{{ route('login') }}" method="GET" style="margin-top: 20px;">
        <button type="submit" class="btn-main">Mulai</button>
      </form> --}}
        <div style="display: inline-flex; gap: 10px; flex-wrap: wrap;">
            <form action="{{ route('login') }}" method="GET">
                <button type="submit" class="btn-main">Mulai</button>
            </form>
            <button class="btn-main" onclick="openModal()">Petunjuk</button>
        </div>

    </div>

    <div class="product">
      <img src="{{ asset('img/18th.png') }}" alt="Logo Pemda" style="width: 320px;">
    </div>

    <div class="details">
      <div class="price">
        BPKPD BOLMUT<br>
        BIDANG BMD<br>
        <span class="stars">★ ★ ★ ★ ★ ★ ★ ★ ★</span>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="features">
    <span>PERENCANAAN</span>
    <span>PENATAUSAHAAN</span>
    <span>PEMANFAATAN</span>
    <span>PENGAMANAN</span>
    <span>PENGHAPUSAN</span>
  </section>

  <!-- SPINNER SCRIPT -->
  <script>
        window.addEventListener('load', function() {
            const spinner = document.getElementById('loading-spinner');
            spinner.style.opacity = '0'; // fade out
            setTimeout(() => {
                spinner.style.display = 'none'; // remove spinner
            }, 500);
        });
    </script>

    <!-- MODAL -->
    <div id="readMoreModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
        <div style="background-color: #fff;
            color: #000;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            position: relative;
            max-height: 80vh;         /* Batasi tinggi maksimum modal */
            overflow-y: auto;">
            <h3 style="margin-top:0;">Blum Ada Akun?</h3>
            <ol style="padding-left: 20px; margin-top: 10px;">
                <li>Klik tombol <strong>"Mulai"</strong> untuk login ke dalam sistem.</li>
                <li>Silahkan Registrasi, Klik <strong>"Bekeng disini"</strong> Lanjutkan Registrasi.</li>
                <li>Pada Halaman Registrasi, isi <strong>Nama Lengkap, Email Aktif dan No Telepon yang bisa dihubungi.</strong></li>
                <li>Setelah berhasil Registrasi, Silahkan Hubungi Admin BMD untuk mendapatkan Akses SKPD.</li>
            </ol>
            <hr style="margin: 30px 0; border: none; border-top: 2px dashed #ccc;">
            <h3 style="margin-top:0;">Mo ba usul standar harga baru?</h3>
            <ol style="padding-left: 20px; margin-top: 10px;">
            <li>Klik tombol <strong>"Mulai"</strong> untuk login ke dalam sistem;</li>
            <li>Siapkan File PDF Surat Usulan disertai <strong>"Lampiran sebagai pendukung Harga Barang/Jasa/Honorarium yang Akan diusul"</strong>;</li>
            <li>Dasar/Pendukung usulan Barang bisa diambil dari e-catalogue/online shop yang discreenshot, atau bisa juga Brosur/Daftar Harga dari Toko;</li>
            <li>Jika Usulan dalam bentuk Honor/Jasa <strong>"Wajib"</strong> mempunyai Dasar Aturan dari Perpres 33 atau SBM dari Kemenkeu yang dianggap wajar/setara dengan Kabupaten/Kota (se- Prov. Sulut);</li>
            <li>Upload Surat Usulan pada Menu yang tersedia;</li>
            <li>Input Usulan pada Menu SSH SBU ASB: <strong>Barang (Input di SSH), Jasa (Input di SBU), Konstruksi (Input di ASB sesuai Petunjuk Dinas PUTR)</strong>;</li>
            <li><strong>SUDAH, Bagitu jo dulu!</strong> So kiring bibir ba jolaskan . . .</li>
        </ol>
            <button onclick="closeModal()" style="margin-top: 20px; padding: 10px 20px; background-color: #b0d9f9; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Tutup</button>
        </div>
    </div>


    <script>
        function openModal() {
            document.getElementById('readMoreModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('readMoreModal').style.display = 'none';
        }
    </script>

   <!-- AUDIO -->
    <audio id="audio-backsound" src="{{ asset('audio/leher.mp3') }}" loop></audio>

    <!-- MODAL -->
    <div id="audioModal" style="
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.75);
        backdrop-filter: blur(4px);
        z-index: 10000;
        justify-content: center;
        align-items: center;
        ">
        <div style="
            background-color: #ffffff;
            color: #333;
            padding: 40px 30px;
            border-radius: 20px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: fadeInScale 0.4s ease;
        ">
            <h2 style="color: #800000; font-weight: 700; font-size: 1.6rem;">
            {{-- ✨ CUMA MO KASE INGA ✨ --}}
            CUMA MO KASE INGA
            </h2>

            <p style="margin: 5px 0; font-size: 1rem; line-height: 1.5; color: #555;">
            Ajukan harga yang wajar serta didasari bukti dukung yang jelas.<br><br>
            Bukti Dukung berupa Aturan Perundang-undangan tentang pembayaran Jasa/Honorarium.<br>Jika yang diusulkan adalah Harga Barang, lampirkan Foto pada saat survei harga atau Daftar Harga resmi dari Toko.
            <br><br>File Bukti dukung disertakan dalam Surat Usulan dibuat dalam file Pdf (500Kb).
            </p>
            <button id="closeAudioBtn" style="
            margin-top: 15px;
            padding: 12px 30px;
            background-color: #47c363;
            border: none;
            color: #fff;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            ">Tutup</button>
        </div>
    </div>

<script>
  const backsound = document.getElementById('audio-backsound');
  const audioModal = document.getElementById('audioModal');
  const closeAudioBtn = document.getElementById('closeAudioBtn');

  window.addEventListener('load', () => {
    audioModal.style.display = 'flex';
  });

  closeAudioBtn.addEventListener('click', () => {
    audioModal.style.display = 'none';
    try {
      backsound.currentTime = 0;
      backsound.play()
        .then(() => console.log('Audio diputar'))
        .catch(err => console.log('Gagal memutar audio:', err));
    } catch (err) {
      console.log('Error audio:', err);
    }
  });
</script>




</body>
</html>
