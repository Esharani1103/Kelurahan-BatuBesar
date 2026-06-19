@extends('admin.layouts.app')
@section('title') Kelola Konten Profil @endsection
@section('content')
<div class="container py-8">

    <h1 class="text-3xl font-bold mb-2">Konten Profil Kelurahan</h1>
    <p class="text-sm text-gray-500 mb-6">Kelola isi setiap halaman profil. Konten bisa diketik langsung atau dilengkapi file lampiran (PDF/gambar).</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded mb-4 text-sm">
            @foreach($errors->all() as $e) <p>{{ $e }}</p> @endforeach
        </div>
    @endif

    {{-- TAB NAVIGATION --}}
    @php
        $tab = request('tab', 'selayang');
        $tabs = [
            'selayang' => ['label' => '📜 Selayang Pandang', 'route_slug' => 'selayang'],
            'gambaran' => ['label' => '🗺️ Gambaran Umum',    'route_slug' => 'gambaran'],
            'visi'     => ['label' => '🎯 Visi & Misi',       'route_slug' => 'visi'],
            'struktur' => ['label' => '🏛️ Struktur Organisasi','route_slug' => 'struktur'],
        ];
    @endphp
    <div class="flex border-b border-gray-300 mb-6 overflow-x-auto">
        @foreach($tabs as $slug => $info)
        <a href="{{ route('admin.profil.index', ['tab' => $slug]) }}"
           class="px-5 py-3 text-sm font-bold whitespace-nowrap {{ $tab === $slug ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-400 hover:text-gray-600' }}">
            {{ $info['label'] }}
        </a>
        @endforeach
    </div>

    {{-- KONTEN TAB AKTIF --}}
    @php $item = $profil[$tab]; @endphp

    <div class="bg-white rounded-lg shadow border border-gray-200 max-w-3xl">
        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold text-lg">{{ $tabs[$tab]['label'] }}</h2>
            <p class="text-xs text-gray-400 mt-1">
                Halaman ini tampil di menu Profil &rarr; {{ $item->judul }} pada situs publik.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.profil.update', $tab) }}" enctype="multipart/form-data" class="p-5 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Judul Halaman *</label>
                <input type="text" name="judul" required value="{{ old('judul', $item->judul) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">
                    Konten (bisa diketik langsung)
                </label>
                <textarea name="konten" rows="10"
                          placeholder="Tulis isi konten di sini. Bisa pakai HTML sederhana seperti <strong>, <br>, <ul><li> untuk format teks."
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-mono focus:outline-none focus:border-green-500 resize-y">{{ old('konten', $item->konten) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">
                    Tag HTML dasar didukung: &lt;strong&gt;, &lt;br&gt;, &lt;ul&gt;&lt;li&gt;, &lt;p&gt;.
                </p>
            </div>

            {{-- File lampiran --}}
            <div class="border-t border-gray-100 pt-4">
                <label class="block text-sm font-semibold text-gray-600 mb-1">
                    File Lampiran (opsional)
                </label>
                <p class="text-xs text-gray-400 mb-3">
                    Bisa berupa dokumen PDF (contoh: SK struktur organisasi) atau gambar (contoh: bagan struktur, foto dokumentasi). Jika ada file, akan tampil di halaman publik selain konten teks.
                </p>

                @if($item->file)
                <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-lg p-3 mb-3">
                    @if($item->file_is_image)
                        <img src="{{ $item->file_url }}" class="w-16 h-16 object-cover rounded border">
                    @else
                        <div class="w-16 h-16 flex items-center justify-center bg-red-50 rounded border text-2xl">📄</div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-700 truncate">{{ $item->file_nama_asli ?? 'File terlampir' }}</p>
                        <a href="{{ $item->file_url }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat / Download</a>
                    </div>
                    <form method="POST" action="{{ route('admin.profil.hapus-file', $tab) }}"
                          onsubmit="return confirm('Hapus file ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-red-600">
                            Hapus File
                        </button>
                    </form>
                </div>
                @endif

                <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.webp"
                       class="w-full text-sm text-gray-500">
                <p class="text-xs text-gray-400 mt-1">Format PDF/JPG/PNG/WEBP, maks 5MB. Upload file baru akan mengganti file lama.</p>
            </div>

            <button type="submit" class="w-full bg-green-700 text-white py-2.5 rounded font-bold hover:bg-green-800">
                💾 Simpan {{ $tabs[$tab]['label'] }}
            </button>
        </form>
    </div>

</div>
@endsection