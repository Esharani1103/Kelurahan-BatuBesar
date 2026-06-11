@extends('layouts.user')
@section('title', 'Data Warga')

@push('styles')
    @vite('resources/css/datawarga.css')
@endpush

@section('content')

<div class="dw-wrap">

    {{-- Header --}}
    <div class="dw-header">
        <div class="dw-title-row">
            <div class="dw-title-bar"></div>
            <h1 class="dw-title">Data Penduduk Kelurahan Batu Besar</h1>
        </div>
        <p class="dw-subtitle">Pilih kategori untuk melihat data kependudukan secara detail.</p>
    </div>

    {{-- Grid Menu --}}
    <div class="dw-grid">

        <a href="{{ route('user.data-warga.jumlah') }}" class="dw-card dw-blue">
            <div class="dw-icon-wrap">
                <img src="{{ asset('images/people.png') }}" alt="Jumlah"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span class="dw-emoji-fallback">👥</span>
            </div>
            <div class="dw-label">Jumlah Kependudukan</div>
            <div class="dw-sub">Lihat Detail →</div>
        </a>

        <a href="{{ route('user.data-warga.umur') }}" class="dw-card dw-yellow">
            <div class="dw-icon-wrap">
                <img src="{{ asset('images/Age.png') }}" alt="Umur"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span class="dw-emoji-fallback">🎂</span>
            </div>
            <div class="dw-label">Umur</div>
            <div class="dw-sub">Lihat Detail →</div>
        </a>

        <a href="{{ route('user.data-warga.agama') }}" class="dw-card dw-green">
            <div class="dw-icon-wrap">
                <img src="{{ asset('images/Trust.png') }}" alt="Agama"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span class="dw-emoji-fallback">🕌</span>
            </div>
            <div class="dw-label">Agama</div>
            <div class="dw-sub">Lihat Detail →</div>
        </a>

        <a href="{{ route('user.data-warga.pendidikan') }}" class="dw-card dw-purple">
            <div class="dw-icon-wrap">
                <img src="{{ asset('images/Education.png') }}" alt="Pendidikan"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span class="dw-emoji-fallback">🎓</span>
            </div>
            <div class="dw-label">Pendidikan</div>
            <div class="dw-sub">Lihat Detail →</div>
        </a>

        <a href="{{ route('user.data-warga.pekerjaan') }}" class="dw-card dw-teal">
            <div class="dw-icon-wrap">
                <img src="{{ asset('images/Portfolio.png') }}" alt="Pekerjaan"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span class="dw-emoji-fallback">💼</span>
            </div>
            <div class="dw-label">Pekerjaan</div>
            <div class="dw-sub">Lihat Detail →</div>
        </a>

    </div>

</div>

@endsection
