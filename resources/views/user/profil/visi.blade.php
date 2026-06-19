@extends('layouts.user')
@section('title', 'Visi & Misi')

@push('styles')
    @vite('resources/css/profil-konten.css')
@endpush

@section('content')
    @include('user._profil_konten', ['konten' => $konten, 'icon' => '🎯'])
@endsection
