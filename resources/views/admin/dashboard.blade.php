<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet">
</head>
<style>
    /* LOGOUT MODAL */
.modal-overlay{
    display:none;
}

.modal-overlay.show{
    display:flex;
}

    </style>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="bg-white shadow-md border-b-4 border-blue-500 py-3 px-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/bg-logopemko.png') }}" class="h-10">
            <h1 class="text-xl tracking-wide text-blue-700 uppercase" style="font-family: 'Lemon', sans-serif;">
                Kelurahan Batu Besar
            </h1>
        </div>
        <div class="flex items-center gap-4">
            <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST">
            @csrf

            <button
            type="button"
            onclick="openLogoutModal()"
            class="hover:text-red-600 flex items-center gap-1 font-semibold text-gray-600">
            <i class="fa-solid fa-right-from-bracket text-lg"></i>
            <span class="hidden sm:inline">Logout</span>
        </button>
        </form>
        </div>
    </header>

    <!-- MAIN -->
    <main class="grow">
        <div class="px-6 py-6">
            <h2 class="text-2xl font-bold mb-6">DASHBOARD ADMIN</h2>

            <div class="bg-white shadow-lg rounded-lg p-10">

                {{-- ── DATA WARGA & LAYANAN ── --}}
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                    Data & Layanan
                </p>
                <div class="flex flex-wrap gap-5 mb-8">

                    <a href="{{ route('warga.index') }}"
                       class="bg-orange-500 text-white rounded-md shadow-md p-6 w-56 hover:bg-orange-600 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Kelola Data Warga</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Lihat Detail →</div>
                    </a>

                    <a href="{{ route('admin.kegiatan.index') }}"
                       class="bg-purple-600 text-white rounded-md shadow-md p-6 w-56 hover:bg-purple-700 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-calendar-days text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Kelola Kegiatan</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Lihat Detail →</div>
                    </a>

                    

                    <a href="{{ route('admin.layanan') }}"
                       class="bg-blue-500 text-white rounded-md shadow-md p-6 w-56 hover:bg-blue-600 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-comment-dots text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Saran &amp; Aduan</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Lihat Detail →</div>
                    </a>

                </div>

                {{-- ── KONTEN BERANDA ── --}}
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                    Konten Beranda
                </p>
                <div class="flex flex-wrap gap-5">

                    <a href="{{ route('admin.aparatur.index') }}"
                       class="bg-green-700 text-white rounded-md shadow-md p-6 w-56 hover:bg-green-800 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-person-shelter text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Aparatur</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Kelola Carousel →</div>
                    </a>

                    <a href="{{ route('admin.video.index') }}"
                       class="bg-red-600 text-white rounded-md shadow-md p-6 w-56 hover:bg-red-700 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-video text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Video Profil</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Kelola Video →</div>
                    </a>

                    <a href="{{ route('admin.ticker.index') }}"
                       class="bg-yellow-500 text-white rounded-md shadow-md p-6 w-56 hover:bg-yellow-600 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-bullhorn text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Teks Berjalan</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Kelola Ticker →</div>
                    </a>

                    <a href="{{ route('admin.syarat.index') }}"
                       class="bg-teal-600 text-white rounded-md shadow-md p-6 w-56 hover:bg-teal-700 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-file-lines text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Syarat Dokumen</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Kelola Persyaratan →</div>
                    </a>

                    <a href="{{ route('admin.statistik.index') }}"
                       class="bg-indigo-600 text-white rounded-md shadow-md p-6 w-56 hover:bg-indigo-700 transition block">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-chart-bar text-2xl"></i>
                        </div>
                        <div class="text-lg font-bold">Statistik</div>
                        <div class="mt-1 text-sm font-medium opacity-80">Kelola Data →</div>
                    </a>

                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-3 text-center text-sm">
        <p class="font-semibold">KELURAHAN BATU BESAR</p>
        <p>Jalan Kelurahan Batu Besar, Kecamatan Nongsa, Kota Batam<br>
            Kepulauan Riau 29465 |
            <a href="mailto:Batubesar@gmail.com" class="underline text-blue-300 hover:text-blue-500">
                Batubesar@gmail.com
            </a>
        </p>
        <p class="mt-1">2026 Kelurahan Batu Besar.</p>
    </footer>

<!--modal logout-->
   <div id="logoutModal"
     class="modal-overlay fixed inset-0 bg-black/50 z-50 items-center justify-center">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">

        <div class="text-center">

            <div class="text-5xl text-amber-500 mb-3">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>

            <h2 class="text-xl font-bold text-gray-800">
                Konfirmasi Logout
            </h2>

            <p class="text-gray-500 mt-2">
                Apakah Anda yakin ingin keluar dari dashboard admin?
            </p>

        </div>

        <div class="flex gap-3 mt-6">

            <button
                type="button"
                onclick="closeLogoutModal()"
                class="flex-1 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                Batal
            </button>

            <button
                type="button"
                onclick="submitLogout()"
                class="flex-1 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Logout
            </button>

        </div>

    </div>

</div>

</body>
<script>
function openLogoutModal() {
    document.getElementById('logoutModal')
        .classList.add('show');
}

function closeLogoutModal() {
    document.getElementById('logoutModal')
        .classList.remove('show');
}

function submitLogout() {
    document.getElementById('logoutForm').submit();
}
</script>

</html>
