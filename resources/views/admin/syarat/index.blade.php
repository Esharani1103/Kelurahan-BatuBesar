@extends('admin.layouts.app')
@section('title') Kelola Syarat Dokumen @endsection
@section('content')
<div class="container py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Persyaratan Dokumen</h1>
        <button onclick="openModal('tambah')"
                class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm font-semibold">
            + Tambah Persyaratan
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <p class="text-sm text-gray-500 mb-3">💡 Seret kartu untuk mengubah urutan tampil di beranda.</p>

    {{-- Grid kartu syarat --}}
    <div id="syaratGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($syarat as $s)
        <div data-id="{{ $s->id }}"
             class="border rounded-lg p-4 bg-white {{ $s->aktif ? 'border-gray-200' : 'border-gray-200 opacity-50' }}">
            {{-- Header kartu --}}
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">{{ $s->ikon }}</span>
                    <span class="font-bold text-sm text-gray-800">{{ $s->judul }}</span>
                </div>
                <span class="cursor-grab text-gray-300 text-lg drag-handle select-none">⠿</span>
            </div>
            {{-- Daftar item --}}
            <ul class="space-y-1 mb-4">
                @foreach($s->items as $item)
                    <li class="text-xs text-gray-600 flex gap-2">
                        <span class="text-green-600 font-bold shrink-0">✓</span>
                        {{ $item->teks }}
                    </li>
                @endforeach
            </ul>
            {{-- Footer kartu --}}
            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <button onclick="toggleSyarat({{ $s->id }}, this)"
                        class="text-xs font-bold px-3 py-1 rounded {{ $s->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                    {{ $s->aktif ? 'Aktif' : 'Nonaktif' }}
                </button>
                <div class="flex gap-2">
                    <button onclick='openEdit(@json($s))'
                            class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded text-xs font-bold hover:bg-yellow-500">
                        Edit
                    </button>
                    <button onclick='konfirmasiHapus({{ $s->id }}, @json($s->judul))'
                            class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-gray-400 border border-dashed rounded-lg">
            Belum ada persyaratan. Klik "+ Tambah Persyaratan" untuk menambahkan.
        </div>
        @endforelse
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Tambah Persyaratan</h2>
            <button onclick="closeModal('tambah')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.syarat.store') }}" class="p-5 space-y-4">
            @csrf
            <div class="flex gap-3">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Ikon</label>
                    <input type="text" name="ikon" value="📄" maxlength="10"
                           class="w-16 border border-gray-300 rounded px-2 py-2 text-xl text-center focus:outline-none focus:border-green-500">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Judul Persyaratan *</label>
                    <input type="text" name="judul" required placeholder="Contoh: KTP & Kartu Keluarga"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-semibold text-gray-600">Item Persyaratan *</label>
                    <button type="button" onclick="tambahItem('tambahItems')"
                            class="text-xs font-bold text-green-700 hover:underline">+ Tambah Item</button>
                </div>
                <div id="tambahItems" class="space-y-2">
                    <div class="flex gap-2 item-row">
                        <input type="text" name="items[]" required placeholder="Contoh: Fotokopi KTP pemohon"
                               class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                        <button type="button" onclick="hapusItem(this)" class="text-red-400 hover:text-red-600 font-bold text-lg">✕</button>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="aktifSyarat" checked class="w-4 h-4 accent-green-700">
                <label for="aktifSyarat" class="text-sm font-semibold text-gray-600">Aktif (tampil di beranda)</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">Simpan</button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Edit Persyaratan</h2>
            <button onclick="closeModal('edit')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form id="editForm" method="POST" class="p-5 space-y-4">
            @csrf @method('PUT')
            <div class="flex gap-3">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Ikon</label>
                    <input type="text" name="ikon" id="editIkon" maxlength="10"
                           class="w-16 border border-gray-300 rounded px-2 py-2 text-xl text-center focus:outline-none focus:border-green-500">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Judul *</label>
                    <input type="text" name="judul" id="editJudul" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-semibold text-gray-600">Item Persyaratan *</label>
                    <button type="button" onclick="tambahItem('editItems')"
                            class="text-xs font-bold text-green-700 hover:underline">+ Tambah Item</button>
                </div>
                <div id="editItems" class="space-y-2"></div>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="editAktif" class="w-4 h-4 accent-green-700">
                <label for="editAktif" class="text-sm font-semibold text-gray-600">Aktif (tampil di beranda)</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">Simpan Perubahan</button>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-sm shadow-2xl p-6 text-center">
        <div class="text-5xl mb-3">🗑️</div>
        <h2 class="text-lg font-bold mb-2">Hapus Persyaratan?</h2>
        <p class="text-gray-500 text-sm mb-5">
            Anda akan menghapus <strong id="hapusNama"></strong> beserta semua itemnya.
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

function tambahItem(containerId) {
    const container = document.getElementById(containerId);
    const row = document.createElement('div');
    row.className = 'flex gap-2 item-row';
    row.innerHTML = `
        <input type="text" name="items[]" required placeholder="Contoh: Fotokopi KTP pemohon"
               class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
        <button type="button" onclick="hapusItem(this)" class="text-red-400 hover:text-red-600 font-bold text-lg">✕</button>`;
    container.appendChild(row);
    row.querySelector('input').focus();
}

function hapusItem(btn) {
    const container = btn.closest('[id$="Items"]');
    if (container.querySelectorAll('.item-row').length <= 1) {
        alert('Minimal harus ada 1 item.'); return;
    }
    btn.closest('.item-row').remove();
}

function openEdit(data) {
    document.getElementById('editForm').action  = `/admin/syarat/${data.id}`;
    document.getElementById('editIkon').value   = data.ikon;
    document.getElementById('editJudul').value  = data.judul;
    document.getElementById('editAktif').checked = !!data.aktif;
    // Isi ulang items
    const container = document.getElementById('editItems');
    container.innerHTML = '';
    (data.items || []).forEach(teks => {
        const row = document.createElement('div');
        row.className = 'flex gap-2 item-row';
        row.innerHTML = `
            <input type="text" name="items[]" value="${teks}" required
                   class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            <button type="button" onclick="hapusItem(this)" class="text-red-400 hover:text-red-600 font-bold text-lg">✕</button>`;
        container.appendChild(row);
    });
    if (!data.items || data.items.length === 0) tambahItem('editItems');
    openModal('edit');
}

function konfirmasiHapus(id, nama) {
    document.getElementById('hapusNama').textContent = nama;
    document.getElementById('hapusForm').action      = `/admin/syarat/${id}`;
    openModal('hapus');
}

async function toggleSyarat(id, btn) {
    const res  = await fetch(`/admin/syarat/${id}/toggle`, {
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
    Sortable.create(document.getElementById('syaratGrid'), {
        handle: '.drag-handle', animation: 150,
        onEnd: async () => {
            const ids = [...document.querySelectorAll('#syaratGrid [data-id]')].map(el => el.dataset.id);
            await fetch('/admin/syarat/urutan', {
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