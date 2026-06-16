@extends('layouts.user')

@section('content')

<section class="profile-section">
    <div class="container konten-profil">

        <h2 class="judul-profil">
            {{ $profil->selayang_judul ?: 'Selayang Pandang' }}
        </h2>

        @forelse (preg_split('/\r\n|\r|\n/', $profil->selayang_isi ?: '') as $paragraf)
            @if (trim($paragraf) !== '')
                <p class="deskripsi-profil">{{ $paragraf }}</p>
            @endif
        @empty
            <p class="deskripsi-profil">
                Batu Besar merupakan Kampung Tua yang menurut keterangan dari Warga dan Tokoh Masyarakat setempat.
            </p>
        @endforelse

    </div>
</section>

 @endsection