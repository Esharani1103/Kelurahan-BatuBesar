    @extends('layouts.user')
    @section('title', 'Profil Kelurahan')

    @push('styles')
        @vite('resources/css/profil.css')
    @endpush

    @section('content')
    <div class="profil-wrap">

        {{-- Hero Header --}}
        <div class="profil-hero">
            <div class="profil-hero-bg"></div>
            <div class="profil-hero-inner">
                <div class="profil-hero-badge">Pemerintah Kota Batam · Kec. Nongsa</div>
                <h1 class="profil-hero-title">Profil Kelurahan<br><span>Batu Besar</span></h1>
                <p class="profil-hero-desc">
                    Kelurahan Batu Besar merupakan salah satu Kampung Tua yang menyimpan
                    kekayaan sejarah dan budaya Melayu di pesisir utara Pulau Batam,
                    Kecamatan Nongsa, Kota Batam, Kepulauan Riau.
                </p>
            </div>
        </div>

        {{-- Gambaran Umum --}}
        <div class="profil-umum">
            <div class="profil-section-label">Gambaran Umum</div>
            <div class="profil-umum-grid">
                <div class="profil-umum-text">
                    <h2>{{ $profil->gambaran_judul ?: 'Mengenal Kelurahan Batu Besar' }}</h2>

    @forelse (preg_split('/\r\n|\r|\n/', $profil->gambaran_isi ?: '') as $paragraf)
        @if (trim($paragraf) !== '')
            <p>{{ $paragraf }}</p>
        @endif
    @empty
        <p>
            Batu Besar merupakan Kampung Tua yang pertama kali ditemukan oleh Suku Melayu,
            yang mana pada awalnya Kampung ini menjadi tempat persinggahan para nelayan
            dan pedagang yang melintas di perairan Nongsa.
        </p>
    @endforelse
                </div>
                
            </div>
        </div>

        {{-- Menu Profil --}}
        <div class="profil-menu-section">
            <div class="profil-section-label">Informasi Profil</div>
            <div class="profil-menu-grid">

                <a href="{{ route('user.profil.selayang') }}" class="profil-card">
                    <div class="profil-card-icon" style="background:linear-gradient(135deg,#0b5c2e,#1fa050)">
                        <img src="{{ asset('images/Handle With Care.png') }}" alt="Selayang Pandang"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                        <span style="display:none;font-size:32px">🌿</span>
                    </div>
                    <div class="profil-card-body">
                        <h3>Selayang Pandang</h3>
                        <p>Sejarah dan gambaran umum Kelurahan Batu Besar dari masa ke masa.</p>
                    </div>
                    <div class="profil-card-arrow">→</div>
                </a>

                <a href="{{ route('user.profil.visi') }}" class="profil-card">
                    <div class="profil-card-icon" style="background:linear-gradient(135deg,#1a6bb5,#2486d9)">
                        <img src="{{ asset('images/Innovation.png') }}" alt="Visi Misi"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                        <span style="display:none;font-size:32px">💡</span>
                    </div>
                    <div class="profil-card-body">
                        <h3>Visi &amp; Misi</h3>
                        <p>Arah dan tujuan pembangunan Kelurahan Batu Besar.</p>
                    </div>
                    <div class="profil-card-arrow">→</div>
                </a>

                <a href="{{ route('user.profil.struktur') }}" class="profil-card">
                    <div class="profil-card-icon" style="background:linear-gradient(135deg,#7c3aed,#9d5cf7)">
                        <img src="{{ asset('images/Hierarchy.png') }}" alt="Struktur Organisasi"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                        <span style="display:none;font-size:32px">🏛️</span>
                    </div>
                    <div class="profil-card-body">
                        <h3>Struktur Organisasi</h3>
                        <p>Susunan aparatur dan perangkat Kelurahan Batu Besar.</p>
                    </div>
                    <div class="profil-card-arrow">→</div>
                </a>

                <a href="{{ route('user.profil.peta') }}" class="profil-card">
                    <div class="profil-card-icon" style="background:linear-gradient(135deg,#0e7490,#0891b2)">
                        <img src="{{ asset('images/Address.png') }}" alt="Peta Kelurahan"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                        <span style="display:none;font-size:32px">🗺️</span>
                    </div>
                    <div class="profil-card-body">
                        <h3>Peta Kelurahan</h3>
                        <p>Peta wilayah dan batas administrasi Kelurahan Batu Besar.</p>
                    </div>
                    <div class="profil-card-arrow">→</div>
                </a>

            </div>
        </div>

    </div>
    @endsection