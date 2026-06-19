@extends('admin.layouts.app')
@section('title') Kelola Teks Berjalan @endsection
@section('content')

<div class="container py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Pengumuman Kelurahan</h1>
        <button onclick="openModal('tambah')"
        class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm font-semibold">
        + Tambah Pengumuman
</button>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ 
   session('success')  }}</div>
   @endif

   <p class="text-sm text-gray-500 mb-3">💡 Seret baris untuk mengubah urutan tampil di topbar.</p>

    <table class="w-full border border-gray-300 text-sm">
        <thead class="bg-gray-100 text-center">
            <tr>
                <th class="border px-3 py-3 w-8">☰</th>
                <th class="border px-3 py-3 w-12">Ikon</th>
                <th class="border px-3 py-3 text-left">Teks Pengumuman</th>
                <th class="border px-3 py-3 w-24">Status</th>
                <th class="border px-3 py-3 w-28">Aksi</th>
            </tr>
        </thead>
        <tbody id="tickerBody">
            @forelse($tickers as $t)
            <tr data-id="{{ $t->id }}" class="{{ $t->aktif ? '' : 'opacity-40' }}">
                <td class="border px-3 py-3 text-center cursor-grab text-gray-400 drag-handle select-none">⠿</td>
                <td class="border px-3 py-3 text-center text-xl">{{ $t->ikon }}</td>
                <td class="border px-3 py-3 cursor-pointer hover:text-green-700"
                    onclick='openEdit(@json($t))'>
                    {{ $t->teks }}
                    <span class="text-xs text-gray-400 ml-1">(klik untuk edit)</span>
                </td>
                <td class="border px-3 py-3 text-center">
                    <button onclick="toggleTicker({{ $t->id }}, this)"
                            class="px-3 py-1 rounded text-xs font-bold {{ $t->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                        {{ $t->aktif ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </td>
                <td class="border px-3 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick='openEdit(@json($t))'
                                class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded text-xs font-bold hover:bg-yellow-500">
                            Edit
                        </button>
                        <button onclick='konfirmasiHapus({{ $t->id }})'
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border px-4 py-6 text-center text-gray-400">Belum ada pengumuman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Tambah Pengumuman</h2>
            <button onclick="closeModal('tambah')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.ticker.store') }}" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Ikon (emoji)</label>
                <input type="text" name="ikon" value="📢" maxlength="10"
                       class="w-20 border border-gray-300 rounded px-3 py-2 text-xl text-center focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Teks Pengumuman *</label>
                <textarea name="teks" required rows="3" placeholder="Contoh: Pelayanan KTP setiap Senin–Jumat 07.30–16.00"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500 resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="aktifTicker" checked class="w-4 h-4 accent-green-700">
                <label for="aktifTicker" class="text-sm font-semibold text-gray-600">Aktif</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">Simpan</button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Edit Pengumuman</h2>
            <button onclick="closeModal('edit')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form id="editForm" method="POST" class="p-5 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Ikon (emoji)</label>
                <input type="text" name="ikon" id="editIkon" maxlength="10"
                       class="w-20 border border-gray-300 rounded px-3 py-2 text-xl text-center focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Teks Pengumuman *</label>
                <textarea name="teks" id="editTeks" required rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500 resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="editAktif" class="w-4 h-4 accent-green-700">
                <label for="editAktif" class="text-sm font-semibold text-gray-600">Aktif</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">Simpan Perubahan</button>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-sm shadow-2xl p-6 text-center">
        <div class="text-5xl mb-3">🗑️</div>
        <h2 class="text-lg font-bold mb-2">Hapus Pengumuman?</h2>
        <p class="text-gray-500 text-sm mb-5">Tindakan ini tidak dapat dibatalkan.</p>
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
    document.getElementById('editForm').action  = `/admin/ticker/${data.id}`;
    document.getElementById('editIkon').value   = data.ikon;
    document.getElementById('editTeks').value   = data.teks;
    document.getElementById('editAktif').checked = !!data.aktif;
    openModal('edit');
}
function konfirmasiHapus(id) {
    document.getElementById('hapusForm').action = `/admin/ticker/${id}`;
    openModal('hapus');
}
async function toggleTicker(id, btn) {
    const res = await fetch(`/admin/ticker/${id}/toggle`, {
        method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();
    if (data.success) {
        btn.textContent = data.aktif ? 'Aktif' : 'Nonaktif';
        btn.className   = 'px-3 py-1 rounded text-xs font-bold ' + (data.aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400');
        btn.closest('tr').className = data.aktif ? '' : 'opacity-40';
    }
}

const s = document.createElement('script');
s.src   = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
s.onload = () => {
    Sortable.create(document.getElementById('tickerBody'), {
        handle: '.drag-handle', animation: 150,
        onEnd: async () => {
            const ids = [...document.querySelectorAll('#tickerBody tr')].map(tr => tr.dataset.id);
            await fetch('/admin/ticker/urutan', {
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