<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Selamat Datang | UsahaBolmut</title>
  <link rel="icon" href="{{ asset('img/logo_pemda.png') }}" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    * {margin:0;padding:0;box-sizing:border-box;}
    body {
      font-family: 'Poppins', sans-serif;
      color: white;
      background: url('{{ asset('img/peta.webp') }}') center/cover fixed no-repeat;
      position: relative;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    body::before {
      content:"";position:fixed;top:0;left:0;width:100%;height:100%;
      background: rgba(0,0,0,0.5);
      backdrop-filter: blur(2px);
      z-index:0;
    }
    header, main, footer {z-index:1;position:relative;}

    /* NEON EFFECT (versi halus) */
  .neon-text {
    color: #f3f9fa;
    text-shadow:
      0 0 2px #03b3bc,
      0 0 4px #03b3bc,
      0 0 6px #00eaff;
    animation: flicker 3s infinite alternate;
  }
  @keyframes flicker {
    0%, 100% {opacity:1;}
    45%, 55% {opacity:0.85;}
  }

  .neon-btn {
    background:#03b3bc;
    color:#fff;
    border:none;
    padding:12px 28px;
    border-radius:30px;
    font-weight:600;
    font-size:1rem;
    cursor:pointer;
    transition:all .3s ease;
    box-shadow:0 0 6px #03b3bc, 0 0 10px #00eaff;
  }
  .neon-btn:hover {
    transform:scale(1.05);
    box-shadow:0 0 10px #03b3bc, 0 0 20px #00eaff;
  }

    nav a {
      text-decoration:none;
      color:#fff;
      font-weight:600;
      position:relative;
      transition:.3s;
      text-shadow:0 0 5px #03b3bc,0 0 10px #00eaff;
    }
    nav a:hover {
      color:#03b3bc;
      text-shadow:0 0 10px #03b3bc,0 0 20px #00eaff,0 0 40px #00eaff;
    }

    .features span {
      background:rgba(255,255,255,0.08);
      padding:10px 18px;
      border-radius:20px;
      transition:all .3s;
      text-shadow:0 0 6px #03b3bc,0 0 12px #00eaff;
    }
    .features span:hover {
      background:#03b3bc;
      color:#fff;
      transform:scale(1.15);
      box-shadow:0 0 15px #03b3bc,0 0 30px #00eaff;
    }

    /* SPINNER */
    #loading-spinner {
      position:fixed;top:0;left:0;width:100%;height:100%;
      display:flex;justify-content:center;align-items:center;
      background:rgba(0,0,0,0.4);
      z-index:9999;transition:opacity .5s ease;
    }
    .spinner {
      width:65px;height:65px;border:6px solid rgba(255,255,255,0.3);
      border-top:6px solid #03b3bc;border-radius:50%;
      animation:spin 1s linear infinite;
      box-shadow:0 0 15px #03b3bc,0 0 30px #00eaff;
    }
    @keyframes spin {to{transform:rotate(360deg)}}

    /* HEADER */
    header {
      padding:1.5rem 2rem;
      display:flex;flex-direction:column;align-items:center;
      text-align:center;
    }
    .logo {font-size:2rem;font-weight:700;margin-bottom:.5rem;}

    /* HERO */
    .hero {
      flex:1;
      display:grid;grid-template-columns:1fr 1fr;
      align-items:center;gap:2rem;
      padding:2rem 4rem;
    }
    .hero .text h1 {font-size:2.5rem;margin-bottom:1rem;}
    .hero .text p {color:#ccc;line-height:1.6;margin-bottom:1.5rem;}
    .hero .product img {
      width:100%;max-width:320px;display:block;margin:auto;
      transition:transform .6s ease, filter .3s ease;
      filter:drop-shadow(0 0 15px #00eaff);
    }
    .hero .product img:hover {
      transform:scale(1.15) rotate(3deg);
      filter:drop-shadow(0 0 25px #03b3bc);
    }

    /* FEATURES */
    .features {
      text-align:center;
      padding:2rem 1rem 3rem;
      font-size:1rem;color:#ddd;
      display:flex;flex-wrap:wrap;justify-content:center;gap:25px;
    }

    /* MODAL */
    @keyframes fadeInScale {from{opacity:0;transform:scale(.8)}to{opacity:1;transform:scale(1)}}
    #readMoreModal, #audioModal {
      display:none;position:fixed;top:0;left:0;width:100%;height:100%;
      justify-content:center;align-items:center;
      background:rgba(0,0,0,0.6);z-index:10000;
    }
    .modal-box {
        background:#fff;color:#333;padding:30px;
        border-radius:15px;max-width:600px;width:90%;
        box-shadow:0 0 8px #03b3bc,0 0 15px #00eaff;
        animation:fadeInScale .4s ease;
        overflow-y:auto;max-height:80vh;
    }
    .modal-box h3 {margin:0 0 15px;font-size:1.4rem;color:#03b3bc;}
    .modal-box button {
        margin-top:20px;padding:10px 20px;border:none;
        border-radius:8px;background:#03b3bc;color:#fff;
        font-weight:600;cursor:pointer;transition:.3s;
        box-shadow:0 0 6px #03b3bc,0 0 10px #00eaff;
    }
    .modal-box button:hover{
        transform:scale(1.05);
        box-shadow:0 0 10px #03b3bc,0 0 18px #00eaff;
    }
  </style>
</head>
<body>
  <!-- SPINNER -->
  <div id="loading-spinner"><div class="spinner"></div></div>

  <!-- HEADER -->
  <header data-aos="fade-down">
    <div class="logo neon-text">APLIKASI PENUNJANG BMD</div>
    <nav>
      <a href="https://sipd-ri.kemendagri.go.id/auth/login">SIPD-RI</a>
      <a href="https://bolaangmongondowutara.e-bmd.co.id/">E-BMD</a>
      <a href="#">RK-BMD</a>
      <a href="#">LELANG-BMD</a>
    </nav>
  </header>

  <!-- HERO -->
  <main class="hero">
    <div class="text" data-aos="fade-right">
      <h1 class="neon-text">Usulan Standar Harga</h1>
      <p>Website ini dibuat agar Proses pengusulan standar harga satuan (SHS) lebih mudah serta bisa diakses kapan saja selama koneksi internet Anda dalam keadaan baik-baik saja. SHS berfungsi sebagai acuan dalam penyusunan Anggaran Belanja Pemerintah Daerah, memastikan efisiensi, transparansi, dan akuntabilitas penggunaan anggaran.</p>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <form action="{{ route('login') }}" method="GET">
          <button type="submit" class="neon-btn">Mulai</button>
        </form>
        <button class="neon-btn" onclick="openModal()">Petunjuk</button>
      </div>
    </div>
    <div class="product" data-aos="zoom-in">
      <img src="{{ asset('img/sjlmap.jpg') }}" alt="Logo Pemda">
    </div>
  </main>

  <!-- FEATURES -->
  <section class="features">
    <span data-aos="fade-up">PERENCANAAN</span>
    <span data-aos="fade-up" data-aos-delay="100">PENATAUSAHAAN</span>
    <span data-aos="fade-up" data-aos-delay="200">PEMANFAATAN</span>
    <span data-aos="fade-up" data-aos-delay="300">PENGAMANAN</span>
    <span data-aos="fade-up" data-aos-delay="400">PENGHAPUSAN</span>
  </section>

  <!-- MODAL PETUNJUK -->
  <div id="readMoreModal">
    <div class="modal-box" data-aos="zoom-in">
      <h3>Blum Ada Akun?</h3>
      <ol>
        <li>Klik tombol <b>"Mulai"</b> untuk login ke sistem.</li>
        <li>Silahkan Registrasi lalu hubungi Admin BMD untuk aktivasi akses SKPD.</li>
      </ol>
      <hr style="margin:20px 0;border:none;border-top:1px solid #ddd;">
      <h3>Mo ba usul standar harga baru?</h3>
      <ol>
        <li>Siapkan Surat Usulan PDF dengan bukti pendukung harga barang/jasa/honorarium.</li>
        <li>Bukti dapat berupa e-catalogue, online shop, brosur, atau aturan resmi.</li>
        <li>Upload file & input usulan sesuai kategori (SSH, SBU, ASB).</li>
        <li><b>SUDAH, Bagitu jo dulu!</b></li>
      </ol>
      <button onclick="closeModal()">Tutup</button>
    </div>
  </div>

  <!-- AUDIO -->
  <audio id="audio-backsound" src="{{ asset('audio/Starbucks.m4a') }}" loop></audio>

  <!-- MODAL AUDIO -->
  <div id="audioModal">
    <div class="modal-box" style="max-width:400px;text-align:center;" data-aos="zoom-in">
      <h3 style="color:#800000;">CUMA MO KASE INGA</h3>
      <p style="font-size:.95rem;line-height:1.5;color:#444;">
        {{-- Ajukan harga wajar dengan bukti dukung jelas.
        Bukti bisa berupa aturan atau daftar harga resmi.<br><br>
        File bukti dukung wajib dilampirkan dalam surat usulan (PDF, maks 500Kb). --}}
        Anda yang mengusulkan standar harga saat ini, ANDA PULA YANG AKAN BERTANGGUNG JAWAB DIKEMUDIAN HARI.<br><br>
        Gunakan data dan informasi yang AKURAT, BENAR, dan WAJAR.
      </p>
      <button id="closeAudioBtn">Tutup</button>
    </div>
  </div>

  <!-- SCRIPT -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({duration:1000, once:true});

    // Spinner fade out
    window.addEventListener('load',()=>{
      const spinner=document.getElementById('loading-spinner');
      spinner.style.opacity='0';
      setTimeout(()=>{spinner.style.display='none';},500);
      // tampilkan modal audio
      document.getElementById('audioModal').style.display='flex';
    });

    // Modal petunjuk
    function openModal(){document.getElementById('readMoreModal').style.display='flex';}
    function closeModal(){document.getElementById('readMoreModal').style.display='none';}

    // Audio modal
    const backsound=document.getElementById('audio-backsound');
    const audioModal=document.getElementById('audioModal');
    document.getElementById('closeAudioBtn').addEventListener('click',()=>{
      audioModal.style.display='none';
      backsound.currentTime=0;
      backsound.play().catch(err=>console.log("Autoplay diblok:",err));
    });
  </script>
</body>
</html>
