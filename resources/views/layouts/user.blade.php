{{-- resources/views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Kelurahan Batu Besar') – Kec. Nongsa, Kota Batam</title>

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

  {{-- Tailwind + JS bawaan Laravel (JANGAN HAPUS) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- CSS Kelurahan (diproses Vite juga) --}}
  @vite('resources/css/kelurahan.css')

  @vite('resources/css/topbar.css')

  {{-- CSS tambahan per-halaman (opsional) --}}
  @stack('styles')
</head>
<body>

  {{-- ===== TOP BAR ===== --}}
  <div id="topbar">
    <a href="{{ route('user.beranda') }}" class="tb-logo">
      <div class="tb-logo-seal">BB</div>
      <div class="tb-logo-text">
        <b>KELURAHAN BATU BESAR</b>
        <span>Kec. Nongsa · Kota Batam</span>
      </div>
    </a>

    <div class="tb-ticker">
      <div class="ticker-track" id="tickerTrack">
        @foreach(($ticker ?? []) as $item)
          <span><b>{{ $item->ikon }}</b>{{ $item->teks }}</span>
        @endforeach
        {{-- Duplikasi untuk animasi loop mulus --}}
        @foreach(($ticker ?? []) as $item)
          <span><b>{{ $item->ikon }}</b>{{ $item->teks }}</span>
        @endforeach
      </div>
    </div>

    <div class="tb-right">
      <div class="tb-search">
        <svg viewBox="0 0 24 24" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" placeholder="Cari informasi…" id="searchInput">
      </div>
      <div class="tb-clock">
        <b id="clockTime">--:--:--</b>
        <span id="clockDate">--</span>
      </div>
      <span class="tb-sun">☀️</span>
      <a href="{{ route('admin.login') }}" class="tb-admin-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
          <path d="M20 8v6M23 11h-6"/>
        </svg>
        <span>Login Admin</span>
      </a>
    </div>
  </div>
 

  {{-- ===== NAVBAR ===== --}}
  <nav id="navbar">
    <div class="navbar-inner">
      <a href="{{ route('user.beranda') }}"
         class="nav-item {{ request()->routeIs('beranda') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Beranda
      </a>
      <div class="nav-divider"></div>
      <div class="nav-dropdown">
    <a href="{{ route('user.profil') }}"
       class="nav-item {{ request()->routeIs('user.profil*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Profil
        <span class="dropdown-toggle">▼</span>
    </a>

    <div class="dropdown-menu">
        <a href="{{ route('user.profil') }}">Gambaran Umum</a>
        <a href="{{ route('user.profil.selayang') }}">Selayang Pandang</a>
        <a href="{{ route('user.profil.visi') }}">Visi & Misi</a>
        <a href="{{ route('user.profil.struktur') }}">Struktur Organisasi</a>
        <a href="{{ route('user.profil.peta') }}">Peta Kelurahan</a>
    </div>
</div>
      <a href="{{ route('user.data-warga') }}"
         class="nav-item {{ request()->routeIs('data-warga') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Data Warga
      </a>
      <a href="{{ route('user.kegiatan') }}"
         class="nav-item {{ request()->routeIs('kegiatan') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Kegiatan
      </a>
      <a href="{{ route('user.layanan') }}"
         class="nav-item {{ request()->routeIs('layanan') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        Saran &amp; Aduan
        @php $jumlahAduan = \App\Models\Layanan::where('status','baru')->count(); @endphp
        @if($jumlahAduan > 0)
          <span class="nav-badge">{{ $jumlahAduan }}</span>
        @endif
      </a>
      <div class="nav-right">
        <button class="nav-ham" id="navHam" onclick="toggleNavMobile()">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </nav>

  {{-- Navbar mobile --}}
  <div class="nav-mobile" id="navMobile">
    <a href="{{ route('user.beranda') }}"    onclick="closeNavMobile()">
      <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Beranda
    </a>
    <div class="nav-dropdown">
    <a href="{{ route('user.profil') }}"
       class="nav-item {{ request()->routeIs('user.profil*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>

        Profil

        <span class="dropdown-toggle">▼</span>
    </a>

    <div class="dropdown-menu">
        <a href="{{ route('user.profil') }}">Gambaran Umum</a>
        <a href="{{ route('user.profil.selayang') }}">Selayang Pandang</a>
        <a href="{{ route('user.profil.visi') }}">Visi & Misi</a>
        <a href="{{ route('user.profil.struktur') }}">Struktur Organisasi</a>
        <a href="{{ route('user.profil.peta') }}">Peta Kelurahan</a>
    </div>
</div>
    <a href="{{ route('user.data-warga') }}" onclick="closeNavMobile()">
      <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>Data Warga
    </a>
    <a href="{{ route('user.kegiatan') }}"   onclick="closeNavMobile()">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Kegiatan
    </a>
    <a href="{{ route('user.layanan') }}"      onclick="closeNavMobile()">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>Saran &amp; Aduan
    </a>
  </div>

  {{-- ===== KONTEN UTAMA ===== --}}
  @yield('content')

  
    {{-- ===== FOOTER ===== --}}
  <footer class="footer-simple">
    <div class="fs-bottom">
      <span>© {{ date('Y') }} Kelurahan Batu Besar · Pemerintah Kota Batam</span>
      <span>📍 Jalan Kelurahan Batu, Batu Besar, Kecamatan Nongsa, Kota Batam, Kepulauan Riau 29465</span>
    </div>
  </footer>

  {{-- ===== JS GLOBAL ===== --}}
  <script>
    // Jam digital
    function updateClock() {
      const now  = new Date();
      const pad  = n => String(n).padStart(2, '0');
      document.getElementById('clockTime').textContent =
        pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
      const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
      const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
      document.getElementById('clockDate').textContent =
        days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Navbar mobile
    function toggleNavMobile()  { document.getElementById('navMobile').classList.toggle('open'); }
    function closeNavMobile()   { document.getElementById('navMobile').classList.remove('open'); }

    // Scroll fade-in
    function observeFI() {
      const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (e.isIntersecting) { e.target.classList.add('vis'); obs.unobserve(e.target); }
        });
      }, { threshold: .08 });
      document.querySelectorAll('.fi').forEach(el => { if (!el.classList.contains('vis')) obs.observe(el); });
    }
    setTimeout(observeFI, 100);
  </script>

  {{-- JS tambahan per-halaman --}}
  @stack('scripts')

</body>
</html>