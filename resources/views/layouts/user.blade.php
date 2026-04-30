<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kelurahan Batu Besar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #F9F9F9;
        }

        .footer-custom {
            background-color: #262626;
        }

        .navbar-custom {
            background-color: #004225;
        }
        .profile-section {
        min-height: calc(100vh - 200px);
        padding-top: 100px;
        padding-bottom: 100px;
        }
        .konten-profil {
    max-width: 900px;   /* supaya tidak terlalu lebar */
       }

    .judul-profil {
    color: #004225;
    font-size: 36px;      /* lebih besar */
    font-weight: 700;
    margin-bottom: 30px;
    }

     .deskripsi-profil {
    font-size: 18px;
    line-height: 1.9;
    text-align: justify;
    margin-bottom: 25px;
    }
    .judul-profil {
    color: #004225;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 25px;
}

.box-visi {
    font-size: 20px;
    line-height: 1.8;
    font-style: italic;
    background-color: #f4f7f5;
    padding: 30px;
    border-left: 6px solid #004225;
    border-radius: 6px;
}

.box-misi ol {
    font-size: 18px;
    line-height: 1.8;
    padding-left: 20px;
}

.navbar-custom .nav-link {
    color: white !important;
    font-weight: 500;
    position: relative;
    padding: 8px 18px;
}

/* GARIS BAWAH (default tersembunyi) */
.navbar-custom .nav-link::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -5px;
    width: 0%;
    height: 3px;
    background-color: white;
    transition: 0.3s ease;
}

/* Saat hover */
.navbar-custom .nav-link:hover::after {
    width: 100%;
}

/* Saat halaman aktif */
.navbar-custom .nav-link.active::after {
    width: 100%;
}

.menu-box{
    color:white;
    padding:25px;
    border-radius:6px;
    transition:0.3s;

    display:flex;
    flex-direction:column;
    justify-content:center;

    min-height:180px;
}

.menu-box h5{
    font-weight:600;
    min-height:48px;
}

.menu-box img{
    margin:10px auto;
}

.menu-box .detail{
    background:rgba(0,0,0,0.2);
    padding:6px;
    margin-top:auto;
}

.menu-box:hover{
    transform:scale(1.05);
}

.bg-purple{
    background:#6f42c1;
}
    </style>
  </head>
<body>

<!-- ===== NAVBAR (GLOBAL) ===== -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.beranda') }}">
            Kelurahan
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto gap-lg-5">
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ route('user.beranda') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ route('user.profil') }}">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ route('user.data-warga') }}">Data Warga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ route('user.laporan-rt') }}">Laporan RT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ route('user.layanan') }}">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ route('user.kegiatan') }}">Kegiatan</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== CONTENT ===== -->
@yield('content')

<!-- ===== FOOTER ===== -->
<footer class="footer-custom text-white pt-5">

    <div class="container">
        <div class="row align-items-center">

            <!-- KOLOM MAP -->
            <div class="col-md-5 mb-2 text-center text-md-start">
                <a href="https://maps.google.com/?q=Kelurahan+Batu+Besar+Batam"
                   target="_blank">
                    <img src="{{ asset('images/maps.png') }}"
                         alt="Lokasi Kelurahan"
                         class="img-fluid rounded w-100"
                         style="max-width: 350px;">
                </a>
            </div>

            <!-- KOLOM INFO -->
            <div class="col-md-7">
                <h4 class="fw-bold">KELURAHAN BATU BESAR</h4>
                <p class="mb-1">
                    Jalan Kelurahan Batu, Batu Besar, Kecamatan Nongsa, Kota Batam, Kepulauan Riau 29465
                </p>
                <p class="mb-1">
                    Kepulauan Riau 29465
                </p>
                <p>
                    batubesar@gmail.com
                </p>
            </div>

        </div>

        <!-- GARIS -->
        <hr class="border-light">

        <!-- COPYRIGHT -->
        <div class="text-center pb-3">
            <small>2025 Kelurahan Batu Besar.</small>
        </div>
    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>