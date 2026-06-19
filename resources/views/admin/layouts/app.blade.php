<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>


<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
.table-container { max-height:600px; overflow:auto; }
thead th { position:sticky; top:0; z-index:10; background:#f3f4f6; }

.input-box{
width:100%;
border:2px solid #e5e7eb;
border-radius:0.5rem;
padding:0.5rem;
font-size:0.875rem;
}

.pagination-container nav{
display:flex;
justify-content:center;
gap:5px;
padding:15px;
}

.sidebar-admin{
    background:#1F4E79;
}

.sidebar-link:hover{
    background:#2A6496;
}

.sidebar-active{
    background:#3A7BC8;
}

.logout-btn{
    background:#415A77;
    transition:.2s;
}

.logout-btn:hover{
    background:#56708F;
}

.modal-overlay{
    display:none;
}

.modal-overlay.show{
    display:flex;
}
</style>

</head>


<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="sidebar-admin text-white flex flex-col shrink-0 w-72 min-h-screen sticky top-0">

        <div class="p-5 border-b border-slate-600">
            <h2 class="font-bold text-lg">
                Kelurahan Batu Besar
            </h2>
            <p class="text-slate-300">
                Panel Admin
            </p>
        </div>

        <nav class="flex-1 p-4 space-y-1">

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link block px-4 py-3 rounded
                {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-house mr-2"></i>
                Dashboard
            </a>

            <div class="pt-4 pb-2 text-xs uppercase font-semibold text-slate-300">
                Data & Layanan
            </div>

            <a href="{{ route('warga.index') }}"
               class="sidebar-link block px-4 py-3 rounded 
                {{ request()->routeIs('warga.index') ? 'sidebar-active' : '' }}">
                Data Warga
            </a>

             <a href="{{ route('admin.profil.index') }}"
               class="sidebar-link block px-4 py-3 rounded">
                Profil
            </a>

            <a href="{{ route('admin.kegiatan.index') }}"
               class="sidebar-link block px-4 py-3 rounded">
                Kegiatan
            </a>

            <a href="{{ route('admin.layanan') }}"
               class="sidebar-link block px-4 py-3 rounded
                {{ request()->routeIs('admin.layanan') ? 'sidebar-active' : '' }}">
                Saran & Masukan
            </a>

            <div class="pt-4 pb-2 text-xs uppercase text-slate-300 font-bold">
            Konten Beranda
            </div>

            <a href="{{ route('admin.aparatur.index') }}"
               class="sidebar-link block px-4 py-3 rounded
                {{ request()->routeIs('admin.aparatur.index') ? 'sidebar-active' : '' }}">
                Aparatur
            </a>

            <a href="{{ route('admin.video.index') }}"
               class="sidebar-link block px-4 py-3 rounded
                {{ request()->routeIs('admin.video.index') ? 'sidebar-active' : '' }}">
                Video Profil
            </a>

            <a href="{{ route('admin.ticker.index') }}"
               class="sidebar-link block px-4 py-3 rounded
                {{ request()->routeIs('admin.ticker.index') ? 'sidebar-active' : '' }}">
                Pengumuman Kelurahan
            </a>

            <a href="{{ route('admin.syarat.index') }}"
               class="sidebar-link block px-4 py-3 rounded
                {{ request()->routeIs('admin.syarat.index') ? 'sidebar-active' : '' }}">
                Persyaratan Administrasi
            </a>

            <a href="{{ route('admin.statistik.index') }}"
               class="sidebar-link block px-4 py-3 rounded
                {{ request()->routeIs('admin.statistik.index') ? 'sidebar-active' : '' }}">
                Informasi Umum
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="mt-auto p-4 border-t border-slate-600">

            <form id="logoutForm"
            action="{{ route('admin.logout') }}"
            method="POST">
            @csrf

            <button
            type="button"
            onclick="openLogoutModal()"
            class="w-full logout-btn text-white py-2 rounded-lg font-semibold">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>
            Logout
            </button>   
            </form>
            

        </div>
        

    </aside>

    {{-- KONTEN --}}
    <main class="flex-1 p-4 md:p-8">
        @yield('content')
    </main>

</div>

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
                Apakah Anda yakin ingin keluar dari panel admin?
            </p>

        </div>

        <div class="flex gap-3 mt-6">

            <button
                onclick="closeLogoutModal()"
                class="flex-1 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                Batal
            </button>

            <button
                onclick="submitLogout()"
                class="flex-1 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Logout
            </button>

        </div>

    </div>

</div>
<script>
    function openLogoutModal(){
    document.getElementById('logoutModal')
        .classList.add('show');
}

function closeLogoutModal(){
    document.getElementById('logoutModal')
        .classList.remove('show');
}
function submitLogout(){
    document.getElementById('logoutForm').submit();
}
</script>

</body>
</html>