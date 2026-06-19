@extends('layouts.user')
@section('title', 'Struktur Organisasi')

@push('styles')
    @vite('resources/css/profil-konten.css')
@endpush

@section('content')
    @include('user._profil_konten', ['konten' => $konten, 'icon' => '🏛️'])
@endsection
