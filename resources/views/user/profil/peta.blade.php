@extends('layouts.user')

@section('content')

<section class="profile-section">
    <div class="container">

        <!-- Judul -->
        <h3 class="fw-bold mb-4" style="color:#004225;">
            Peta Kelurahan
        </h3>

        <!-- Gambar peta -->
        <div class="text-center">
            <img src="{{ asset('images/peta.png') }}"
                 alt="Struktur Organisasi"
                 class="img-fluid shadow rounded"
                 style="max-width: 900px;">
        </div>

    </div>
</section>

@endsection