@extends('layouts.user')

@section('content')


<div class="profile-section" style="min-height: 60vh;">

    <div class="text-center mb-5">
        <h3 class="fw-bold">PROFIL KELURAHAN</h3>
    </div>

    <div class="row text-center g-4 justify-content-center">

        <!-- ICON 1 -->
        <div class="col-6 col-md-3">
            <a href="{{ route('user.profil.selayang') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Handle With Care.png') }}"
                     width="80"
                     class="mb-2">
                <p>Selayang Pandang</p>
            </a>
        </div>

        <!-- ICON 2 -->
        <div class="col-6 col-md-3">
            <a href="{{ route('user.profil.visi') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Innovation.png') }}"
                     width="80"
                     class="mb-2">
                <p>Visi Misi</p>
            </a>
        </div>

        <!-- ICON 3 -->
        <div class="col-6 col-md-3">
            <a href="{{ route('user.profil.struktur') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Hierarchy.png') }}"
                     width="80"
                     class="mb-2">
                <p>Struktur Organisasi</p>
            </a>
        </div>

        <!-- ICON 4 -->
        <div class="col-6 col-md-3">
            <a href="{{ route('user.profil.peta') }}" class="text-decoration-none text-dark">
                <img src="{{ asset('images/Address.png') }}"
                     width="80"
                     class="mb-2">
                <p>Peta Kelurahan</p>
            </a>
        </div>

    </div>

</div>

@endsection