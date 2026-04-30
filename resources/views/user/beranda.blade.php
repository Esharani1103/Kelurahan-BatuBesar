@extends('layouts.user')

@section('content')

<!-- ===== HERO ===== -->
<section>
    <img src="{{ asset('images/hero.png') }}"
         class="img-fluid w-100"
         alt="Hero Image">
</section>

<!-- ===== PROFIL ===== -->
<section class="py-5">
    <div class="container">
    
        <!-- Judul-->
        <div class="text-center mb-5">
            <h3 class="fw-bold">KELURAHAN BATU BESAR</h3>
    </div>

    <!-- Deskripsi-->
    <div class="row align-items-start">

        <div class="col-md-6 mb-3 mb-md-0">
                <p>
                    Batu Besar merupakan Kampung Tua yang menurut keterangan dari Warga dan Tokoh Masyarakat setempat, orang yang pertama kali membuka lahan dan menetap di Kampung Melayu adalah M. AKIB (Alm), yang hidup antara tahun 1835 – 1927 M, beliau berasal dari Malaka / Malaysia yang wafat dan dimakamkan di daerah Teluk Kampung Melayu atau 
                    tepatnya di RT.001 RW.008 Kampung Melayu Batu Besar, adapun anak keturunan dari Bapak M. AKIB saat ini  masih menetap di kampung tersebut.
                </p>
            </div>

            <!--gambar-->
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/image 15.png') }}" class="img-fluid rounded shadow-sm">
            </div>

        </div>
    </div>
</section>

<!-- ===== MENU ICON ===== -->
<div class="container text-center py-5">
    <div class="row">

        <!-- ICON KEGIATAN -->
        <div class="col-6 col-md-4 mb-4">
            <a href="{{ route('user.kegiatan') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Business Documentation.png') }}"
                     width="80"
                     class="img-fluid mb-2">
                <p>Kegiatan</p>
            </a>
        </div>

        <!-- ICON PROFIL -->
        <div class="col-6 col-md-4 mb-4">
            <a href="{{ route('user.profil') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Profiles.png') }}"
                     width="80"
                     class="img-fluid mb-2">
                <p>Profil</p>
            </a>
        </div>

        <!-- ICON DATA WARGA -->
        <div class="col-6 col-md-4 mb-4">
            <a href="{{ route('user.data-warga') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Business Report.png') }}"
                     width="80"
                     class="img-fluid mb-2">
                <p>Data Warga</p>
            </a>
        </div>

        <!-- ICON LAPORAN RT -->
        <div class="col-6 col-md-4">
            <a href="{{ route('user.laporan-rt') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Complaint.png') }}"
                     width="80"
                     class="img-fluid mb-2">
                <p>Laporan RT</p>
            </a>
        </div>

        <!--ICON LAYANAN -->
        <div class="col-6 col-md-4 mb-4">
            <a href="{{ route('user.layanan') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Communication.png') }}"
                width="80"
                class="img-fluid mb-2">
                <p>Layanan</p>
            </a>
        </div>

    </div>
</div>

<!-- ===== GALERI ===== -->
<section class="py-5">
    <div class="container">

        <h4 class="text-center mb-4">GALERI KEGIATAN</h4>

        <div class="row g-3">

            @for ($i = 0; $i < 3; $i++)
                <div class="col-12 col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top">
                        <div class="card-body text-center">
                            <p>Hari Santri</p>
                        </div>
                    </div>
                </div>
            @endfor

        </div>

    </div>
</section>

@endsection
