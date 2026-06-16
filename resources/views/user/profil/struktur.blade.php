@extends('layouts.user')

@section('content')

<section class="profile-section">
    <div class="container">

        <!-- JUDUL -->
        <h3 class="fw-bold mb-4" style="color:#004225;">
            Struktur Organisasi
        </h3>

        <!-- GAMBAR STRUKTUR -->
        <div class="text-center">
           <img src="{{ $profil->struktur_foto ? asset('storage/' . $profil->struktur_foto) : asset('images/struktur.png') }}"
     alt="Struktur Organisasi"
     class="img-fluid shadow rounded"
     style="max-width: 900px;">
        </div>

    </div>
</section>

@endsection