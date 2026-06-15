@extends('admin.layouts.app')
@section('title') Kelola Kegiatan @endsection
@section('content')
<div class="container py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Kegiatan</h1>
        <button onclick="openModal('tambah')"
                class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm font-semibold">
            + Tambah Kegiatan
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <p class="text-sm text-gray-500 mb-3">
        💡 Seret kartu untuk mengubah urutan tampil di carousel beranda. Hanya kegiatan <strong>Aktif</strong> yang muncul di carousel; semua kegiatan tetap tampil di halaman Dokumentasi Kegiatan.
    </p>

    <div id="kegiatanGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($kegiatan as $k)
        <div data-id="{{ $k->id }}"
             class="border rounded-lg overflow-hidden bg-white {{ $k->aktif ? 'border-gray-200' : 'border-gray-200 opacity-50' }}">
            {{-- Gambar --}}
            <div class="relative h-36 bg-gray-100">
                @if($k->gambar)
                    <img src="{{ asset('storage/'.$k->gambar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl">📅</div>
                @endif
                <span class="absolute top-2 right-2 cursor-grab text-white text-lg drag-handle select-none"
                      style="text-shadow:0 1px 4px rgba(0,0,0,.5)">⠿</span>
            </div>
            {{-- Body --}}
            <div class="p-3">
                <p class="text-xs text-gray-400 mb-1">📅 {{ $k->tanggal_indo }}</p>
                <p class="font-bold text-sm text-gray-800 mb-2 line-clamp-2">{{ $k->judul }}</p>
                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    <button onclick="toggleKegiatan({{ $k->id }}, this)"
                            class="text-xs font-bold px-3 py-1 rounded {{ $k->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                        {{ $k->aktif ? 'Aktif' : 'Nonaktif' }}
                    </button>
                    <div class="flex gap-2">
                        @php
$dataKegiatan = [
    'id' => $k->id,
    'judul' => $k->judul,
    'deskripsi' => $k->deskripsi,
    'tanggal' => optional($k->tanggal)->format('Y-m-d'),
    'urutan' => $k->urutan,
    'aktif' => $k->aktif,
    'gambar' => $k->gambar_url,
];
@endphp

<button
    onclick='openEdit(@json($dataKegiatan))'
    class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded text-xs font-bold hover:bg-yellow-500">
    Edit
</button>
                        <button onclick='konfirmasiHapus({{ $k->id }}, @json($k->judul))'
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-gray-400 border border-dashed rounded-lg">
            Belum ada kegiatan. Klik "+ Tambah Kegiatan" untuk menambahkan.
        </div>
        @endforelse
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Tambah Kegiatan</h2>
            <button onclick="closeModal('tambah')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.kegiatan.store') }}" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Judul Kegiatan *</label>
                <input type="text" name="judul" required placeholder="Contoh: Gotong Royong Lingkungan RW 03"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal *</label>
                <input type="date" name="tanggal" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Ceritakan singkat tentang kegiatan ini..."
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Gambar Kegiatan</label>
                <input type="file" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp"
                       class="w-full text-sm text-gray-500">
                <p class="text-xs text-gray-400 mt-1">Format JPG/PNG/WEBP, maks 2MB.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Urutan</label>
                <input type="number" name="urutan" min="1" placeholder="1, 2, 3 ..."
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                <p class="text-xs text-gray-400 mt-1">Angka kecil tampil lebih dulu di carousel.</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="aktifKegiatan" checked class="w-4 h-4 accent-green-700">
                <label for="aktifKegiatan" class="text-sm font-semibold text-gray-600">Aktif (tampil di carousel beranda)</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">Simpan</button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Edit Kegiatan</h2>
            <button onclick="closeModal('edit')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf @method('PUT')
            <div id="gambarPreviewWrap" class="hidden mb-2">
                <img id="gambarPreview" class="w-full h-32 object-cover rounded-lg border-2 border-green-400">
                <p class="text-xs text-gray-400 mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Judul Kegiatan *</label>
                <input type="text" name="judul" id="editJudul" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal *</label>
                <input type="date" name="tanggal" id="editTanggal" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="editDeskripsi" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Gambar Baru (opsional)</label>
                <input type="file" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp"
                       class="w-full text-sm text-gray-500">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Urutan</label>
                <input type="number" name="urutan" id="editUrutan" min="1"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="editAktif" class="w-4 h-4 accent-green-700">
                <label for="editAktif" class="text-sm font-semibold text-gray-600">Aktif (tampil di carousel beranda)</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">Simpan Perubahan</button>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-sm shadow-2xl p-6 text-center">
        <div class="text-5xl mb-3">🗑️</div>
        <h2 class="text-lg font-bold mb-2">Hapus Kegiatan?</h2>
        <p class="text-gray-500 text-sm mb-5">
            Anda akan menghapus <strong id="hapusNama"></strong>.<br>Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex gap-3">
            <button onclick="closeModal('hapus')" class="flex-1 border border-gray-300 py-2 rounded font-semibold text-sm hover:bg-gray-50">Batal</button>
            <form id="hapusForm" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-500 text-white py-2 rounded font-bold text-sm hover:bg-red-600">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function openModal(t) { document.getElementById('modal'+t[0].toUpperCase()+t.slice(1)).classList.replace('hidden','flex'); }
function closeModal(t) { document.getElementById('modal'+t[0].toUpperCase()+t.slice(1)).classList.replace('flex','hidden'); }
['Tambah','Edit','Hapus'].forEach(t => {
    document.getElementById('modal'+t).addEventListener('click', function(e) { if(e.target===this) closeModal(t.toLowerCase()); });
});

function openEdit(data) {
    document.getElementById('editForm').action      = `/admin/kegiatan/${data.id}`;
    document.getElementById('editJudul').value      = data.judul;
    document.getElementById('editDeskripsi').value  = data.deskripsi ?? '';
    document.getElementById('editTanggal').value    = data.tanggal;
    document.getElementById('editUrutan').value     = data.urutan;
    document.getElementById('editAktif').checked    = !!data.aktif;

    const previewWrap = document.getElementById('gambarPreviewWrap');
    if (data.gambar) {
        document.getElementById('gambarPreview').src = data.gambar;
        previewWrap.classList.remove('hidden');
    } else {
        previewWrap.classList.add('hidden');
    }
    openModal('edit');
}

function konfirmasiHapus(id, nama) {
    document.getElementById('hapusNama').textContent = nama;
    document.getElementById('hapusForm').action      = `/admin/kegiatan/${id}`;
    openModal('hapus');
}

async function toggleKegiatan(id, btn) {
    const res  = await fetch(`/admin/kegiatan/${id}/toggle`, {
        method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();
    if (data.success) {
        btn.textContent = data.aktif ? 'Aktif' : 'Nonaktif';
        btn.className   = 'text-xs font-bold px-3 py-1 rounded ' + (data.aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400');
        btn.closest('[data-id]').classList.toggle('opacity-50', !data.aktif);
    }
}

const s = document.createElement('script');
s.src   = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
s.onload = () => {
    Sortable.create(document.getElementById('kegiatanGrid'), {
        handle: '.drag-handle', animation: 150,
        onEnd: async () => {
            const ids = [...document.querySelectorAll('#kegiatanGrid [data-id]')].map(el => el.dataset.id);
            await fetch('/admin/kegiatan/urutan', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                body: JSON.stringify({ urutan: ids })
            });
        }
    });
};
document.head.appendChild(s);
</script>
@endsection