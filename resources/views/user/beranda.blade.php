{{-- resources/views/beranda.blade.php --}}
@extends('layouts.user')

@section('title', 'Beranda')

@push('styles')
    @vite([
        'resources/css/beranda.css',
        'resources/css/statistik.css'
        
    ])
    
@endpush

@section('content')

{{-- ===== STATS BAR 
<div id="statsbar">
  <div class="statsbar-label">
    <svg viewBox="0 0 24 24"><path d="M3 3v18h18M7 16l4-4 4 4 4-6"/></svg>
    Data Kelurahan
  </div>
  <div class="statsbar-items">
    <div class="stat-bar-item">
      <div class="sbi-icon" style="background:rgba(224,48,48,.2)">📋</div>
      <div class="sbi-text">
        <span class="sbi-num">{{ $statistik['surat_bulan_ini']->nilai ?? '0' }}</span>
        <span class="sbi-label">Surat Bulan Ini</span>
      </div>
    </div>
    <div class="stat-bar-item">
      <div class="sbi-icon" style="background:rgba(10,140,110,.2)">🏙️</div>
      <div class="sbi-text">
        <span class="sbi-num">{{ $statistik['luas_wilayah']->nilai ?? '~12 km²' }}</span>
        <span class="sbi-label">Luas Wilayah</span>
      </div>
    </div>
    <div class="stat-bar-item">
      <div class="sbi-icon" style="background:rgba(200,150,26,.2)">⭐</div>
      <div class="sbi-text">
        <span class="sbi-num">{{ date('Y') }}</span>
        <span class="sbi-label">Tahun Anggaran</span>
      </div>
    </div>
    <div class="stat-bar-item">
      <div class="sbi-icon" style="background:rgba(40,196,100,.2)">🏛️</div>
      <div class="sbi-text">
        <span class="sbi-num">Nongsa</span>
        <span class="sbi-label">Kecamatan</span>
      </div>
    </div>
    <div class="stat-bar-item">
      <div class="sbi-icon" style="background:rgba(150,100,220,.2)">🌐</div>
      <div class="sbi-text">
        <span class="sbi-num">29466</span>
        <span class="sbi-label">Kode Pos</span>
      </div>
    </div>
  </div>
</div>
--}}

{{-- ===== SECTION STATISTIK BERGERAK ===== --}}
<div id="statSection">
  <div class="stat-section-bg">
    <div class="stat-orb stat-orb1"></div>
    <div class="stat-orb stat-orb2"></div>
    <div class="stat-orb stat-orb3"></div>
    <div class="stat-grid-lines"></div>
  </div>
  <div class="stat-section-inner">
    <div class="stat-section-label">
      <span class="stat-pulse-dot"></span>
      Data Real-Time Kelurahan Batu Besar
    </div>
    <div class="stat-cards-row">

      <div class="stat-big-card"
           data-target="{{ $statistik['penduduk']->nilai ?? 4820 }}"
           data-suffix="" data-id="ctr1">
        <div class="sbc-icon-wrap" style="--c1:#28c464;--c2:#0b5c2e">
          <svg viewBox="0 0 24 24" fill="white" width="28" height="28">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
          </svg>
        </div>
        <div class="sbc-body">
          <div class="sbc-num" id="ctr1">0</div>
          <div class="sbc-label">Total Penduduk</div>
          <div class="sbc-sub">Jiwa terdaftar</div>
        </div>
        <div class="sbc-bar-wrap">
          <div class="sbc-bar" style="--pct:78%;--col:#28c464"></div>
          <span>78% aktif</span>
        </div>
        <div class="sbc-sparkline">
          <svg viewBox="0 0 80 30" preserveAspectRatio="none">
            <polyline points="0,25 13,20 26,22 39,15 52,18 65,10 80,8" fill="none" stroke="rgba(40,196,100,.6)" stroke-width="2" stroke-linecap="round"/>
            <polyline points="0,25 13,20 26,22 39,15 52,18 65,10 80,8 80,30 0,30" fill="rgba(40,196,100,.12)"/>
          </svg>
        </div>
      </div>

      <div class="stat-big-card"
           data-target="{{ $statistik['kk']->nilai ?? 1246 }}"
           data-suffix="" data-id="ctr2">
        <div class="sbc-icon-wrap" style="--c1:#ffc72c;--c2:#8a6000">
          <svg viewBox="0 0 24 24" fill="white" width="28" height="28">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
        </div>
        <div class="sbc-body">
          <div class="sbc-num" id="ctr2">0</div>
          <div class="sbc-label">Kepala Keluarga</div>
          <div class="sbc-sub">Kartu Keluarga aktif</div>
        </div>
        <div class="sbc-bar-wrap">
          <div class="sbc-bar" style="--pct:91%;--col:#ffc72c"></div>
          <span>91% terdata</span>
        </div>
        <div class="sbc-sparkline">
          <svg viewBox="0 0 80 30" preserveAspectRatio="none">
            <polyline points="0,28 13,22 26,25 39,18 52,20 65,12 80,9" fill="none" stroke="rgba(255,199,44,.6)" stroke-width="2" stroke-linecap="round"/>
            <polyline points="0,28 13,22 26,25 39,18 52,20 65,12 80,9 80,30 0,30" fill="rgba(255,199,44,.12)"/>
          </svg>
        </div>
      </div>

      <div class="stat-big-card"
           data-target="{{ $statistik['rw']->nilai ?? 6 }}"
           data-suffix=" RW" data-id="ctr3">
        <div class="sbc-icon-wrap" style="--c1:#3ab5f0;--c2:#0a4a7a">
          <svg viewBox="0 0 24 24" fill="white" width="28" height="28">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
          </svg>
        </div>
        <div class="sbc-body">
          <div class="sbc-num" id="ctr3">0</div>
          <div class="sbc-label">Rukun Warga</div>
          <div class="sbc-sub">Membawahi {{ $statistik['rt']->nilai ?? 24 }} RT</div>
        </div>
        <div class="sbc-bar-wrap">
          <div class="sbc-bar" style="--pct:100%;--col:#3ab5f0"></div>
          <span>{{ $statistik['rw']->nilai ?? 6 }} RW aktif</span>
        </div>
        <div class="sbc-sparkline">
          <svg viewBox="0 0 80 30" preserveAspectRatio="none">
            <polyline points="0,20 13,18 26,16 39,14 52,12 65,10 80,8" fill="none" stroke="rgba(58,181,240,.6)" stroke-width="2" stroke-linecap="round"/>
            <polyline points="0,20 13,18 26,16 39,14 52,12 65,10 80,8 80,30 0,30" fill="rgba(58,181,240,.12)"/>
          </svg>
        </div>
      </div>

      <div class="stat-big-card"
           data-target="{{ $statistik['rt']->nilai ?? 24 }}"
           data-suffix=" RT" data-id="ctr4">
        <div class="sbc-icon-wrap" style="--c1:#f06040;--c2:#7a2010">
          <svg viewBox="0 0 24 24" fill="white" width="28" height="28">
            <path d="M12 3L2 12h3v9h6v-5h2v5h6v-9h3L12 3zm0 12.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
          </svg>
        </div>
        <div class="sbc-body">
          <div class="sbc-num" id="ctr4">0</div>
          <div class="sbc-label">Rukun Tetangga</div>
          <div class="sbc-sub">Tersebar di {{ $statistik['rw']->nilai ?? 6 }} RW</div>
        </div>
        <div class="sbc-bar-wrap">
          <div class="sbc-bar" style="--pct:100%;--col:#f06040"></div>
          <span>{{ $statistik['rt']->nilai ?? 24 }} RT aktif</span>
        </div>
        <div class="sbc-sparkline">
          <svg viewBox="0 0 80 30" preserveAspectRatio="none">
            <polyline points="0,22 13,20 26,18 39,16 52,14 65,11 80,8" fill="none" stroke="rgba(240,96,64,.6)" stroke-width="2" stroke-linecap="round"/>
            <polyline points="0,22 13,20 26,18 39,16 52,14 65,11 80,8 80,30 0,30" fill="rgba(240,96,64,.12)"/>
          </svg>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- ===== MAIN LAYOUT ===== --}}
<div class="main-wrap">

  {{-- ===== SIDEBAR KIRI ===== --}}
  <aside class="sidebar-left">

    {{-- Aparatur Carousel --}}
    <div class="sidebar-card fi">
      <div class="sidebar-card-header">
        <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
        <h3>Aparatur Kelurahan</h3>
      </div>
      <div class="aparatur-carousel" id="apcWrap">
        <div class="apc-counter" id="apcCounter">1 / {{ $aparatur->count() }}</div>
        <button class="apc-nav apc-prev" onclick="apcMove(-1)">‹</button>
        <button class="apc-nav apc-next" onclick="apcMove(1)">›</button>
        <div class="apc-track" id="apcTrack">
          @foreach($aparatur as $ap)
            <div class="apc-slide">
              <div class="apc-bg-ring"></div>
              <div class="apc-avatar">
                @if($ap->foto)
                  <img src="{{ Storage::url($ap->foto) }}" alt="{{ $ap->nama }}">
                @else
                  {{ strtoupper(substr($ap->nama, 0, 2)) }}
                @endif
              </div>
              <div class="apc-name">{{ $ap->nama }}</div>
              <span class="apc-jabatan">{{ $ap->jabatan }}</span>
              <div class="apc-nip">{{ $ap->nip }}</div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="apc-dots" id="apcDots">
        @foreach($aparatur as $i => $ap)
          <button class="apc-dot {{ $i === 0 ? 'on' : '' }}"
                  onclick="apcGo({{ $i }})"></button>
        @endforeach
      </div>
    </div>

    {{-- Info Kelurahan --}}
    <div class="sidebar-card fi">
      <div class="sidebar-card-header">
        <svg viewBox="0 0 24 24"><path d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5S13.4 11.5 12 11.5z"/></svg>
        <h3>Info Kelurahan</h3>
      </div>
      <div class="info-desa-list">
        <div class="info-desa-row"><span>Kecamatan</span><span>Nongsa</span></div>
        <div class="info-desa-row"><span>Kota</span><span>Batam</span></div>
        <div class="info-desa-row"><span>Provinsi</span><span>Kepri</span></div>
        <div class="info-desa-row"><span>Kode Pos</span><span>29465</span></div>
        <div class="info-desa-row"><span>Luas Wilayah</span><span>~12 km²</span></div>
        <div class="info-desa-row"><span>Jumlah RT</span><span>{{ $statistik['rt']->nilai ?? 24 }} RT</span></div>
        <div class="info-desa-row"><span>Jumlah RW</span><span>{{ $statistik['rw']->nilai ?? 6 }} RW</span></div>
      </div>
    </div>

    {{-- Kode Pos Wilayah --}}
    <div class="sidebar-card fi">
      <div class="sidebar-card-header">
        <svg viewBox="0 0 24 24" fill="rgba(255,255,255,.85)">
          <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
        </svg>
        <h3>Kode Pos Wilayah</h3>
      </div>
      <div class="info-desa-list">
        @foreach($kodepos as $kp)
          <div class="info-desa-row">
            <span>{{ $kp['wilayah'] }}</span>
            <span>{{ $kp['kode'] }}</span>
          </div>
        @endforeach
      </div>
    </div>

      {{-- Jam Operasional --}}
    <div class="sidebar-card fi">
      <div class="sidebar-card-header">
        <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.85)" stroke-width="2">
          <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        <h3>Jam Operasional</h3>
      </div>
      <div class="jam-sidebar">
        <div class="jam-sidebar-row"><span>Senin – Kamis</span><span class="jam-sidebar-waktu">08.00 – 16.00</span></div>
        <div class="jam-sidebar-row"><span>Jumat</span><span class="jam-sidebar-waktu">08.30 – 16.30</span></div>
        <div class="jam-sidebar-row"><span>Istirahat</span><span class="jam-sidebar-tutup">12.00 - 13.00</span></div>
        <div class="jam-sidebar-row"><span>Sabtu, Minggu & Libur</span><span class="jam-sidebar-tutup">Tutup</span></div>
        <div class="status-sidebar" id="statusSidebar">
          <div class="status-dot" id="sdot"></div>
          <span id="statusTxt">Memuat status…</span>
        </div>
      </div>
    </div>
    

  </aside>

  {{-- ===== KONTEN TENGAH ===== --}}
  <main class="center-col">

    {{-- Video Profil --}}
    <div class="video-section fi">
      <div class="section-header">
        <div class="section-header-left">
          <div class="section-header-icon">
            <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
          </div>
          <h2>Video Profil Kelurahan</h2>
        </div>
        <div class="section-header-actions">
          @auth
            <button class="btn-sm" onclick="document.getElementById('vInput').click()">⬆ Upload Video</button>
          @endauth
        </div>
      </div>
      <div class="video-wrap">
        @if($video && $video->url_youtube)
          <iframe src="https://www.youtube.com/embed/{{ $video->url_youtube }}"
                  frameborder="0" allowfullscreen style="width:100%;height:100%;"></iframe>
        @elseif($video && $video->file_video)
          <video controls src="{{ Storage::url($video->file_video) }}"
                 style="width:100%;height:100%;object-fit:cover;"></video>
        @else
          <div class="video-placeholder-big" id="vidPlaceholder">
            <div class="play-circle">
              <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            </div>
            <p>Video Profil Kelurahan Batu Besar</p>
            <small>Belum ada video yang diunggah</small>
          </div>
        @endif
      </div>
      @auth
        <input type="file" id="vInput" accept="video/*" style="display:none"
               onchange="handleVid(event)">
      @endauth
    </div>
          

   
        {{-- ================================================================
SECTION: BERITA & KEGIATAN

TODO untuk rekan:
Section ini sengaja dinonaktifkan sementara.

Aktifkan kembali dengan menghapus komentar Blade
yang membungkus blok ini.

1. Buat model Kegiatan:
   php artisan make:model Kegiatan -m

2. Isi migration (create_kegiatans_table):
   $table->id();
   $table->string('judul');
   $table->string('kategori');
   $table->text('isi');
   $table->string('foto')->nullable();
   $table->date('tanggal');
   $table->integer('views')->default(0);
   $table->boolean('publikasi')->default(true);
   $table->timestamps();

3. Tambahkan di UserController::beranda():
   'berita' => \App\Models\Kegiatan::where('publikasi', true)
                   ->latest('tanggal')
                   ->take(6)
                   ->get(),

4. Tambahkan route di web.php:
   Route::get('/berita/{id}', ...)

5. Buat Admin Controller:
   php artisan make:controller Admin/KegiatanController --resource

6. Pastikan route berikut tersedia:
   - route('user.beranda')
   - route('berita.show', $id)

Catatan:
$b->foto menggunakan Storage::url().
Pastikan menjalankan:
php artisan storage:link

================================================================ --}}
        



    {{-- Syarat Dokumen --}}
    <div class="syarat-section fi">
      <div class="section-header">
        <div class="section-header-left">
          <div class="section-header-icon">
            <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-5 5h8v2H8zm0-4h5v2H8z"/></svg>
          </div>
          <h2>Persyaratan Dokumen</h2>
        </div>
      </div>
      <div class="syarat-grid">
        @foreach($syarat as $s)
  <div class="syarat-item">
    <h4>
      <span>{{ $s->ikon }}</span>
      {{ $s->judul }}
    </h4>

    <ul>
      @foreach($s->items as $item)
        <li>{{ $item->teks }}</li>
      @endforeach
    </ul>
  </div>
@endforeach
      </div>
    </div>

 
    {{-- Petugas Kelurahan 
    <div class="petugas-section fi" id="petugasSec">
      <div class="petugas-header">
        <h2>Petugas Kelurahan</h2>
        <p>Tim profesional siap melayani Anda</p>
      </div>
      <div class="petugas-grid">
        @foreach($aparatur as $ap)
          <div class="petugas-card">
            <div class="petugas-av">
              @if($ap->foto)
                <img src="{{ Storage::url($ap->foto) }}" alt="{{ $ap->nama }}"
                     style="width:100%;height:100%;object-fit:cover;border-radius:50%">
              @else
                {{ strtoupper(substr($ap->nama, 0, 2)) }}
              @endif
            </div>
            <div class="petugas-name">{{ $ap->nama }}</div>
            <div class="petugas-role">{{ $ap->jabatan }}</div>
            <div class="petugas-nip">{{ $ap->nip }}</div>
          </div>
        @endforeach
      </div>
    </div>
   --}}

     {{-- Kegiatan, Peta & Lokasi Kantor (3 kolom sejajar) --}}
    <div class="peta-jam-grid peta-jam-grid-3 fi">
 
       {{-- Kolom 1: Kegiatan (carousel) --}}
      <div class="peta-card kegiatan-card">
        <div class="section-header">
          <div class="section-header-left">
            <div class="section-header-icon">
              <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            </div>
            <h2>Kegiatan</h2>
          </div>
          <div class="section-header-actions">
            <a href="{{ route('user.kegiatan') }}" class="btn-sm">📁 Lihat Semua</a>
          </div>
        </div>
 
        @if($kegiatan->count() > 0)
        <div class="kegiatan-carousel" id="kgcWrap">
          <div class="apc-counter" id="kgcCounter">1 / {{ $kegiatan->count() }}</div>
          @if($kegiatan->count() > 1)
            <button class="apc-nav apc-prev" onclick="kgcMove(-1)">‹</button>
            <button class="apc-nav apc-next" onclick="kgcMove(1)">›</button>
          @endif
          <div class="kgc-track" id="kgcTrack">
            @foreach($kegiatan as $k)
              <div class="kgc-slide">
                <div class="kgc-img">
                  @if($k->gambar)
                    <img src="{{ Storage::url($k->gambar) }}" alt="{{ $k->judul }}">
                  @else
                    <div class="kgc-img-placeholder">📅</div>
                  @endif
                </div>
                <div class="kgc-body">
                  <div class="kgc-date">📅 {{ $k->tanggal_indo }}</div>
                  <div class="kgc-title">{{ $k->judul }}</div>
                  @if($k->deskripsi)
                    <p class="kgc-desc">{{ Str::limit($k->deskripsi, 80) }}</p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @if($kegiatan->count() > 1)
        <div class="apc-dots" id="kgcDots">
          @foreach($kegiatan as $i => $k)
            <button class="apc-dot {{ $i === 0 ? 'on' : '' }}" onclick="kgcGo({{ $i }})"></button>
          @endforeach
        </div>
        @endif
        @else
        <div class="kegiatan-empty">
          <div style="font-size:32px;margin-bottom:8px">📅</div>
          <p>Belum ada kegiatan terbaru.</p>
        </div>
        @endif
      </div>
 
      {{-- Kolom 2: Peta Wilayah --}}
      <div class="peta-card">
        <div class="section-header">
          <div class="section-header-left">
            <div class="section-header-icon">
              <svg viewBox="0 0 24 24"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/></svg>
            </div>
            <h2>Peta Lokasi</h2>
          </div>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15957.319!2d104.1806!3d1.1559!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da73a2d7cda9ab%3A0x6a43f1e4a0f5e72e!2sKelurahan%20Batu%20Besar%2C%20Nongsa%2C%20Batam%20City!5e0!3m2!1sid!2sid!4v1700000000"
                allowfullscreen loading="lazy"></iframe>
        <div style="padding:12px 16px;background:#f9fbfa;border-top:1px solid var(--border);font-size:12.5px;color:var(--txt2)">
          📍 Kampung Melayu, Kec. Nongsa, Kota Batam, Kepri 29465
        </div>
      </div>
 
      {{-- Kolom 3: Lokasi Kantor --}}
      <div class="peta-card">
        <div class="section-header">
          <div class="section-header-left">
            <div class="section-header-icon">
              <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <h2>Lokasi Kantor</h2>
          </div>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.4!2d104.1820!3d1.1545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da73a2d7cda9ab%3A0x6a43f1e4a0f5e72e!2sKantor+Kelurahan+Batu+Besar!5e0!3m2!1sid!2sid!4v1700000001"
                allowfullscreen loading="lazy"></iframe>
        <div style="padding:12px 16px;background:#f9fbfa;border-top:1px solid var(--border);font-size:12.5px;color:var(--txt2)">
          🏛 Jl. Kelurahan Batu Besar, Nongsa, Batam 29465
        </div>
      </div>
 
    </div>

  </main>
</div>

{{-- FAB Admin (hanya untuk user yang login) --}}
@auth
  <button class="fab-admin" id="fabAdmin" title="Mode Admin" onclick="toggleAdmin()">⚙</button>
@endauth

@endsection

@push('scripts')
<script>
// ===== JAM KERJA STATUS =====
function updateStatus() {
  const now = new Date(), h = now.getDay(), m = now.getHours() * 60 + now.getMinutes();
  const buka = (h >= 1 && h <= 4 && m >= 450 && m < 960) || (h === 5 && m >= 450 && m < 990);
  const dot = document.getElementById('sdot'), txt = document.getElementById('statusTxt');
  if (buka) {
    dot.className = 'status-dot buka'; txt.textContent = 'Kantor Sedang Buka'; txt.style.color = '#4dff8a';
  } else {
    dot.className = 'status-dot tutup'; txt.textContent = 'Kantor Sedang Tutup'; txt.style.color = '#ff8080';
  }
}
updateStatus(); setInterval(updateStatus, 60000);

// ===== APARATUR CAROUSEL =====
let apcIdx = 0, apcTimer = null;
const apcTotal = {{ $aparatur->count() }};
function apcRender() {
  document.getElementById('apcTrack').style.transform = `translateX(-${apcIdx * 100}%)`;
  document.getElementById('apcCounter').textContent = `${apcIdx + 1} / ${apcTotal}`;
  document.querySelectorAll('.apc-dot').forEach((d, i) => d.classList.toggle('on', i === apcIdx));
}
function apcGo(n)    { apcIdx = n; apcRender(); resetApcTimer(); }
function apcMove(dir){ apcIdx = (apcIdx + dir + apcTotal) % apcTotal; apcRender(); resetApcTimer(); }
function resetApcTimer() {
  clearInterval(apcTimer);
  apcTimer = setInterval(() => { apcIdx = (apcIdx + 1) % apcTotal; apcRender(); }, 3500);
}
resetApcTimer();


// ===== KEGIATAN CAROUSEL =====
let kgcIdx = 0, kgcTimer = null;
const kgcTotal = {{ $kegiatan->count() }};
if (kgcTotal > 0) {
  window.kgcRender = function() {
    document.getElementById('kgcTrack').style.transform = `translateX(-${kgcIdx * 100}%)`;
    const counter = document.getElementById('kgcCounter');
    if (counter) counter.textContent = `${kgcIdx + 1} / ${kgcTotal}`;
    document.querySelectorAll('#kgcDots .apc-dot').forEach((d, i) => d.classList.toggle('on', i === kgcIdx));
  };
  window.kgcGo = function(n) { kgcIdx = n; kgcRender(); resetKgcTimer(); };
  window.kgcMove = function(dir) { kgcIdx = (kgcIdx + dir + kgcTotal) % kgcTotal; kgcRender(); resetKgcTimer(); };
  function resetKgcTimer() {
    clearInterval(kgcTimer);
    if (kgcTotal > 1) {
      kgcTimer = setInterval(() => { kgcIdx = (kgcIdx + 1) % kgcTotal; kgcRender(); }, 4500);
    }
  }
  resetKgcTimer();
}

// ===== STATISTIK COUNTER =====
function animateCounter(el, target, suffix, duration) {
  const start = performance.now();
  function step(now) {
    const p = Math.min((now - start) / duration, 1);
    const ease = p === 1 ? 1 : 1 - Math.pow(2, -10 * p);
    el.textContent = Math.round(ease * target).toLocaleString('id-ID') + (suffix || '');
    if (p < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}
function initStatSection() {
  const section = document.getElementById('statSection');
  if (!section) return;
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        document.querySelectorAll('[data-target]').forEach(card => {
          const el = document.getElementById(card.dataset.id);
          if (el) animateCounter(el, parseInt(card.dataset.target), card.dataset.suffix, 1800);
        });
        document.querySelectorAll('.sbc-bar').forEach(bar => {
          setTimeout(() => bar.classList.add('animated'), 200);
        });
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.2 });
  obs.observe(section);
}
initStatSection();

// ===== ADMIN MODE (hanya tersedia jika auth) =====
@auth
let isAdmin = false;
function toggleAdmin() {
  isAdmin = !isAdmin;
  const btn = document.getElementById('fabAdmin');
  btn.textContent = isAdmin ? '✕' : '⚙';
  btn.classList.toggle('active', isAdmin);
  btn.title = isAdmin ? 'Keluar Mode Admin' : 'Mode Admin';
}
@endauth
</script>
@endpush