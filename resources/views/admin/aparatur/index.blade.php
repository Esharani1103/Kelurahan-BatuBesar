@extends('admin.layouts.app')
@section('title') Kelola Aparatur @endsection
@section('content')
<div class="container py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Data Aparatur</h1>
        <button onclick="openModal('tambah')"
                class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 text-sm font-semibold">
            + Tambah Aparatur
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <p class="text-sm text-gray-500 mb-3">💡 Seret baris untuk mengubah urutan tampil di carousel beranda.</p>

    <table class="w-full border border-gray-300 text-center text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-3 w-8">☰</th>
                <th class="border px-3 py-3">Foto</th>
                <th class="border px-3 py-3 text-left">Nama</th>
                <th class="border px-3 py-3 text-left">Jabatan</th>
                <th class="border px-3 py-3">NIP</th>
                <th class="border px-3 py-3">Status</th>
                <th class="border px-3 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortableBody">
            @forelse($aparatur as $ap)
            <tr data-id="{{ $ap->id }}">
                <td class="border px-3 py-3 cursor-grab text-gray-400 drag-handle select-none">⠿</td>
                <td class="border px-3 py-3">
                    @if($ap->foto)
                        <img src="{{ asset('storage/'.$ap->foto) }}" class="w-11 h-11 rounded-full object-cover mx-auto">
                    @else
                        <div class="w-11 h-11 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-green-900 mx-auto text-sm">
                            {{ $ap->inisial }}
                        </div>
                    @endif
                </td>
                <td class="border px-3 py-3 font-semibold text-left">{{ $ap->nama }}</td>
                <td class="border px-3 py-3 text-left">{{ $ap->jabatan }}</td>
                <td class="border px-3 py-3 text-gray-500">{{ $ap->nip ?? '-' }}</td>
                <td class="border px-3 py-3">
                    <button onclick="toggleAparatur({{ $ap->id }}, this)"
                            class="px-3 py-1 rounded text-xs font-bold {{ $ap->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                        {{ $ap->aktif ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </td>
                <td class="border px-3 py-3">
                    <div class="flex justify-center gap-2">
                        <button
    data-ap='@json($ap)'
    onclick="openEdit(JSON.parse(this.dataset.ap))"
    class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded text-xs font-bold hover:bg-yellow-500">
    Edit
</button>
                        <button onclick='konfirmasiHapus({{ $ap->id }}, @json($ap->nama))'
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="border px-4 py-6 text-gray-400">Belum ada data aparatur.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Tambah Aparatur</h2>
            <button onclick="closeModal('tambah')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        @if ($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-700 px-3 py-2 rounded text-sm mb-3">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form method="POST" action="{{ route('admin.aparatur.store') }}" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap *</label>
                <input type="text" name="nama" required placeholder="Contoh: AGUS, S.AP"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                       @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Jabatan *</label>
                <input type="text" name="jabatan" required placeholder="Contoh: Lurah"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                       @error('jabatan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">NIP</label>
                <input type="text" name="nip" placeholder="NIP 197805 200501 1 008"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                       @error('nip')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Urutan</label>
                <input type="number" name="urutan" min="1" placeholder="1, 2, 3 ..."
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                <p class="text-xs text-gray-400 mt-1">Angka kecil tampil lebih dulu di carousel.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Foto</label>
                <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png,image/webp"
                       class="w-full text-sm text-gray-500">
                <p class="text-xs text-gray-400 mt-1">Format JPG/PNG/WEBP, maks 2MB.</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="aktifTambah" checked class="w-4 h-4 accent-green-700">
                <label for="aktifTambah" class="text-sm font-semibold text-gray-600">Aktif (tampil di beranda)</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">
                Simpan
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex items-center justify-between p-5 border-b">
            <h2 class="text-lg font-bold">Edit Aparatur</h2>
            <button onclick="closeModal('edit')" class="text-gray-400 hover:text-gray-700 text-xl font-bold">✕</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap *</label>
                <input type="text" name="nama" id="editNama" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Jabatan *</label>
                <input type="text" name="jabatan" id="editJabatan" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">NIP</label>
                <input type="text" name="nip" id="editNip"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Urutan</label>
                <input type="number" name="urutan" id="editUrutan" min="1"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Foto Baru (opsional)</label>
                <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png,image/webp"
                       class="w-full text-sm text-gray-500">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" id="editAktif" class="w-4 h-4 accent-green-700">
                <label for="editAktif" class="text-sm font-semibold text-gray-600">Aktif (tampil di beranda)</label>
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-sm shadow-2xl p-6 text-center">
        <div class="text-5xl mb-3">🗑️</div>
        <h2 class="text-lg font-bold mb-2">Hapus Aparatur?</h2>
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
    const id = 'modal' + type.charAt(0).toUpperCase() + type.slice(1);
    document.getElementById(id).classList.replace('hidden','flex');
}
function closeModal(type) {
    const id = 'modal' + type.charAt(0).toUpperCase() + type.slice(1);
    document.getElementById(id).classList.replace('flex','hidden');
}
['Tambah','Edit','Hapus'].forEach(t => {
    document.getElementById('modal'+t).addEventListener('click', function(e) {
        if (e.target === this) closeModal(t.toLowerCase());
    });
});

function openEdit(data) {
    document.getElementById('editForm').action = `/admin/aparatur/${data.id}`;
    document.getElementById('editNama').value    = data.nama;
    document.getElementById('editJabatan').value = data.jabatan;
    document.getElementById('editNip').value     = data.nip ?? '';
    document.getElementById('editUrutan').value  = data.urutan;
    document.getElementById('editAktif').checked = !!data.aktif;
    openModal('edit');
}

function konfirmasiHapus(id, nama) {
    document.getElementById('hapusNama').textContent = nama;
    document.getElementById('hapusForm').action      = `/admin/aparatur/${id}`;
    openModal('hapus');
}

async function toggleAparatur(id, btn) {
    const res  = await fetch(`/admin/aparatur/${id}/toggle`, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();
    if (data.success) {
        btn.textContent = data.aktif ? 'Aktif' : 'Nonaktif';
        btn.className   = 'px-3 py-1 rounded text-xs font-bold ' +
            (data.aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400');
    }
}

const s = document.createElement('script');
s.src   = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
s.onload = () => {
    Sortable.create(document.getElementById('sortableBody'), {
        handle: '.drag-handle', animation: 150,
        onEnd: async () => {
            const ids = [...document.querySelectorAll('#sortableBody tr')].map(tr => tr.dataset.id);
            await fetch('/admin/aparatur/urutan', {
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