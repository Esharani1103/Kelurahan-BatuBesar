<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet">

</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="bg-white shadow-md border-b-4 border-blue-500 py-3 px-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/bg-logopemko.png') }}" class="h-10">
            <h1 class="text-xl tracking-wide text-blue-700 uppercase" style="font-family: 'Lemon', sans-serif;">
    Kelurahan Batu Besar
            </h1>
        </div>

        <!-- LOGOUT BUTTON -->
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="hover:text-red-600 flex items-center gap-1 font-semibold text-gray-600">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </header>

    <!-- MAIN -->
    <main class="flex-grow">
        <div class="px-6 py-6">
            <h2 class="text-2xl font-bold mb-6">DASHBOARD ADMIN</h2>

            <div class="bg-white shadow-lg rounded-lg p-24">
                <div class="flex flex-wrap gap-6">

                    <!-- Card Data Warga -->
                    <a href="{{ route('warga.index') }}"
                       class="bg-orange-500 text-white rounded-md shadow-md p-6 w-60 hover:bg-orange-600 transition block">
                        <div class="text-lg font-bold">Kelola Data Warga</div>
                        <div class="mt-2 text-sm font-medium">Lihat Detail</div>
                    </a>

                    <!-- Card Kegiatan -->
                    <a href="#"
                       class="bg-purple-600 text-white rounded-md shadow-md p-6 w-60 hover:bg-purple-700 transition block">
                        <div class="text-lg font-bold">Kelola Kegiatan</div>
                        <div class="mt-2 text-sm font-medium">Lihat Detail</div>
                    </a>

                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-1 text-center text-sm">
        <p class="font-semibold">KELURAHAN BATU BESAR</p>
        <p>Jalan Kelurahan Batu Besar, Kecamatan Nongsa, Kota Batam<br>
        Kepulauan Riau 29465 | 
        <a href="mailto:Batubesar@gmail.com"
   class="underline text-blue-300 hover:text-blue-500">
   Batubesar@gmail.com
</a>
        </p>
        <p class="mt-2">2026 Kelurahan Batu Besar.</p>
    </footer>

</body>
</html>
