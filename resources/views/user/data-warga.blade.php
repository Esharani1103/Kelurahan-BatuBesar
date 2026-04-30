@extends('layouts.user')

@section('content')

<div class="container py-5">

    <!-- Judul -->
    <h3 class="fw-bold text-success">
        Data Penduduk Kelurahan Batu Besar
    </h3>
    <hr style="border:2px solid #1f5e3b; width:100%;">

    <!-- CARD MENU -->
    <div class="card shadow p-4">

        <div class="row text-center">

            <!-- JUMLAH -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('user.data-warga.jumlah') }}" class="text-decoration-none">
                    <div class="menu-box bg-primary">
                        <h5>Jumlah Kependudukan</h5>
                        <img src="{{ asset('images/people.png') }}" width="40">
                        <div class="detail">Lihat Detail</div>
                    </div>
                </a>
            </div>

            <!-- UMUR -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('user.data-warga.umur') }}" class="text-decoration-none">
                    <div class="menu-box bg-warning">
                        <h5>Umur</h5>
                        <img src="{{ asset('images/Age.png') }}" width="40">
                        <div class="detail">Lihat Detail</div>
                    </div>
                </a>
            </div>

            <!-- AGAMA -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('user.data-warga.agama') }}" class="text-decoration-none">
                    <div class="menu-box bg-success">
                        <h5>Agama</h5>
                        <img src="{{ asset('images/Trust.png') }}" width="40">
                        <div class="detail">Lihat Detail</div>
                    </div>
                </a>
            </div>

            <!-- PENDIDIKAN -->
            <div class="col-md-6">
                <a href="{{ route('user.data-warga.pendidikan') }}" class="text-decoration-none">
                    <div class="menu-box bg-purple">
                        <h5>Pendidikan</h5>
                        <img src="{{ asset('images/Education.png') }}" width="40">
                        <div class="detail">Lihat Detail</div>
                    </div>
                </a>
            </div>

            <!-- PEKERJAAN -->
            <div class="col-md-6">
                <a href="{{ route('user.data-warga.pekerjaan') }}" class="text-decoration-none">
                    <div class="menu-box bg-info">
                        <h5>Pekerjaan</h5>
                        <img src="{{ asset('images/Portfolio.png') }}" width="40">
                        <div class="detail">Lihat Detail</div>
                    </div>
                </a>
            </div>

        </div>

    </div>

</div>

@endsection