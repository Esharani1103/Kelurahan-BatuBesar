{{-- resources/views/user/_profil_konten.blade.php --}}
{{-- Partial reusable untuk 4 halaman profil: selayang, gambaran, visi, struktur --}}
{{-- Variabel yang diharapkan: $konten (instance ProfilKonten), $icon (emoji header) --}}

<div class="pk-wrap">

    <div class="pk-header">
        <div class="pk-title-row">
            <div class="pk-title-bar"></div>
            <h1 class="pk-title">{{ $icon ?? '📄' }} {{ $konten->judul }}</h1>
        </div>
    </div>

    <div class="pk-card">

        @if($konten->konten)
            <div class="pk-konten-text">
                {!! $konten->konten !!}
            </div>
        @else
            <p class="pk-empty-text">Konten belum tersedia. Admin dapat menambahkan informasi ini melalui panel admin.</p>
        @endif

        @if($konten->file)
        <div class="pk-file-attachment">
            <div class="pk-file-divider"></div>
            @if($konten->file_is_image)
                <div class="pk-file-image">
                    <img src="{{ $konten->file_url }}" alt="{{ $konten->judul }}">
                </div>
            @else
                <a href="{{ $konten->file_url }}" target="_blank" class="pk-file-doc">
                    <div class="pk-file-doc-icon">📄</div>
                    <div class="pk-file-doc-info">
                        <strong>{{ $konten->file_nama_asli ?? 'Lihat Dokumen' }}</strong>
                        <span>Klik untuk membuka / mengunduh</span>
                    </div>
                    <div class="pk-file-doc-arrow">→</div>
                </a>
            @endif
        </div>
        @endif

    </div>

</div>