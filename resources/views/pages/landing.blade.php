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
      <p>Standar Harga Satuan (SHS) berfungsi sebagai acuan dalam penyusunan Anggaran Belanja Pemerintah Daerah, memastikan efisiensi dan efektivitas penggunaan anggaran, serta mendorong transparansi dan akuntabilitas. Proses Usulan Standar Harga harus mengacu pada Peraturan Perundang-undangan yang berlaku atau bisa juga mengambil dasar harga dari survei dilapangan.</p>
      <form action="{{ route('login') }}" method="GET" style="margin-top: 20px;">
        <button type="submit" class="btn-main">Login</button>
      </form>
    </div>

    <div class="product">
      <img src="{{ asset('img/18th.png') }}" alt="Logo Pemda" style="width: 320px;">
    </div>

    <div class="details">
      <div class="price">
        BPKPD BOLMUT<br>
        BIDANG BMD<br>
        <span class="stars">★ ★ ★ ★ ★ ★ ★ ★</span>
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



</body>
</html>
