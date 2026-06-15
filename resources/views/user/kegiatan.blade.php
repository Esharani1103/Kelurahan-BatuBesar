@extends('layouts.user')
@section('title', 'Dokumentasi Kegiatan')

@push('styles')
    @vite('resources/css/kegiatan.css')
@endpush

@section('content')
<div class="kg-wrap">

    {{-- Header --}}
    <div class="kg-header">
        <div class="kg-title-row">
            <div class="kg-title-bar"></div>
            <h1 class="kg-title">Dokumentasi Kegiatan</h1>
        </div>
        <p class="kg-subtitle">
            Kumpulan dokumentasi kegiatan dan program kerja Kelurahan Batu Besar.
        </p>
    </div>

    {{-- Grid Kegiatan --}}
    @if($kegiatanList->count() > 0)
    <div class="kg-grid">
        @foreach($kegiatanList as $k)
        <div class="kg-card">
            <div class="kg-img">
                @if($k->foto)
                    <img src="{{ Storage::url($k->foto) }}" alt="{{ $k->judul }}">
                @else
                    <div class="kg-img-placeholder">📅</div>
                @endif
                @if($k->kategori)
                    <span class="kg-badge">{{ $k->kategori }}</span>
                @endif
                @unless($k->aktif)
                    <span class="kg-badge-arsip">Arsip</span>
                @endunless
            </div>
            <div class="kg-body">
                <div class="kg-date">📅 {{ $k->tanggal_indo }}</div>
                <h3 class="kg-card-title">{{ $k->judul }}</h3>
                @if($k->deskripsi)
                    <p class="kg-desc">{{ $k->deskripsi }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($kegiatanList->hasPages())
    <div class="kg-pagination">
        {{ $kegiatanList->links() }}
    </div>
    @endif

    @else
    <div class="kg-empty">
        <div style="font-size:48px;margin-bottom:12px">📅</div>
        <p>Belum ada dokumentasi kegiatan yang tersedia.</p>
    </div>
    @endif

</div>
@endsection