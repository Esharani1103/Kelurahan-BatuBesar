@extends('admin.layouts.app')
@section('title') Kelola Video Profil @endsection
@section('content')

<div class="container py-8">
    

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Video Profil</h1>
        <button onclick="openModal('tambah')"
                class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm font-semibold">
            + Upload Video
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <p class="text-sm text-gray-500 mb-4">
        ✅ Hanya satu video yang aktif di beranda. Klik <strong>Aktifkan</strong> untuk mengganti.
    </p>

    <div class="space-y-3">
        @forelse($videos as $v)
        <div class="flex items-center gap-4 border border-gray-200 rounded-lg p-4 {{ $v->aktif ? 'bg-green-50 border-green-300' : 'bg-white' }}">
            {{-- Thumbnail --}}
            <div class="w-36 h-20 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                @if($v->is_youtube && $v->embed_url)
                    <iframe src="{{ $v->embed_url }}?controls=0&modestbranding=1"
                            class="w-full h-full" frameborder="0"></iframe>
                @elseif($v->file_video)
                    <video src="{{ asset('storage/'.$v->file_video) }}" class="w-full h-full object-cover" muted></video>
                @else
                    <div class="w-full h-full flex items-center justify-center text-3xl">🎬</div>
                @endif
            </div>
            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-800 truncate">{{ $v->judul }}</p>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $v->is_youtube ? '🎬 YouTube' : '📁 File lokal' }} ·
                    {{ $v->created_at->format('d M Y') }}
                </p>
                @if($v->aktif)
                    <span class="inline-block mt-1 text-xs font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                        ✅ Aktif di beranda
                    </span>
                @endif
            </div>
            {{-- Aksi --}}
            <div class="flex flex-col gap-2 shrink-0">
                @unless($v->aktif)
                    <button onclick="aktifkanVideo({{ $v->id }}, this)"
                            class="bg-green-700 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-green-800">
                        Aktifkan
                    </button>
                @endunless
                <button onclick='konfirmasiHapus({{ $v->id }}, @json($v->judul))'
                        class="bg-red-500 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-red-600">
                    Hapus
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400 border border-dashed border-gray-300 rounded-lg">
            Belum ada video. Klik "+ Upload Video" untuk menambahkan.
        </div>
        @endforelse
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Upload Video Baru</h2>
            <button onclick="closeModal('tambah')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.video.store') }}" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Judul Video *</label>
                <input type="text" name="judul" required placeholder="Video Profil Kelurahan Batu Besar"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            {{-- Tab pilihan --}}
            <div class="flex border-b border-gray-200">
                <button type="button" id="tabYtBtn"
                        onclick="switchTab('youtube')"
                        class="px-4 py-2 text-sm font-bold text-green-700 border-b-2 border-green-700">
                    🎬 URL YouTube
                </button>
                <button type="button" id="tabFileBtn"
                        onclick="switchTab('file')"
                        class="px-4 py-2 text-sm font-semibold text-gray-400">
                    📁 Upload File
                </button>
            </div>
            <div id="tabYoutube">
                <label class="block text-sm font-semibold text-gray-600 mb-1">URL YouTube</label>
                <input type="url" name="url_youtube" id="urlYoutube"
                       placeholder="https://www.youtube.com/watch?v=..."
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                <p class="text-xs text-gray-400 mt-1">Mendukung youtube.com/watch?v=... atau youtu.be/...</p>
            </div>
            <div id="tabFile" class="hidden">
                <label class="block text-sm font-semibold text-gray-600 mb-1">File Video</label>
                <input type="file" name="file_video" id="fileVideo" accept="video/mp4,video/webm,video/ogg"
                       class="w-full text-sm text-gray-500">
                <p class="text-xs text-gray-400 mt-1">Format MP4/WebM/OGG, maks 100MB.</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="aktifVideo" checked class="w-4 h-4 accent-green-700">
                <label for="aktifVideo" class="text-sm font-semibold text-gray-600">Jadikan video aktif di beranda</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">
                Upload
            </button>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-sm shadow-2xl p-6 text-center">
        <div class="text-5xl mb-3">🗑️</div>
        <h2 class="text-lg font-bold mb-2">Hapus Video?</h2>
        <p class="text-gray-500 text-sm mb-5">
            Anda akan menghapus <strong id="hapusNama"></strong>.<br>Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex gap-3">
            <button onclick="closeModal('hapus')"
                    class="flex-1 border border-gray-300 py-2 rounded font-semibold text-sm hover:bg-gray-50">
                Batal
            </button>
            <form id="hapusForm" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-500 text-white py-2 rounded font-bold text-sm hover:bg-red-600">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function openModal(type) {
    document.getElementById('modal'+type.charAt(0).toUpperCase()+type.slice(1)).classList.replace('hidden','flex');
}
function closeModal(type) {
    document.getElementById('modal'+type.charAt(0).toUpperCase()+type.slice(1)).classList.replace('flex','hidden');
}
['Tambah','Hapus'].forEach(t => {
    document.getElementById('modal'+t).addEventListener('click', function(e) {
        if (e.target === this) closeModal(t.toLowerCase());
    });
});

function switchTab(tab) {
    const isYt = tab === 'youtube';
    document.getElementById('tabYoutube').classList.toggle('hidden', !isYt);
    document.getElementById('tabFile').classList.toggle('hidden', isYt);
    document.getElementById('tabYtBtn').className   = 'px-4 py-2 text-sm font-bold ' + (isYt ? 'text-green-700 border-b-2 border-green-700' : 'text-gray-400');
    document.getElementById('tabFileBtn').className = 'px-4 py-2 text-sm font-bold ' + (!isYt ? 'text-green-700 border-b-2 border-green-700' : 'text-gray-400');
    if (isYt) document.getElementById('fileVideo').value = '';
    else      document.getElementById('urlYoutube').value = '';
}


function konfirmasiHapus(id, nama) {
    console.log('Klik hapus', id, nama);

    document.getElementById('hapusNama').textContent = nama;
    document.getElementById('hapusForm').action = `/admin/video/${id}`;

    openModal('hapus');
}

async function aktifkanVideo(id, btn) {
    btn.disabled = true; btn.textContent = '...';
    const res  = await fetch(`/admin/video/${id}/aktifkan`, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();
    if (data.success) location.reload();
}
</script>
@endsection