<@extends('admin.layouts.app')

@section('title') Kelola Profil @endsection

@section('content')
<div class="container py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">Kelola Profil</h1>
                <p class="text-gray-500">Atur profil kelurahan yang tampil di halaman user.</p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="bg-white border px-4 py-2 rounded-md shadow-sm hover:bg-gray-50">
                Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data"
              class="max-w-5xl">
            @csrf

            <section class="bg-white rounded-lg shadow p-6">
                <label class="block font-bold mb-2">Pilih Bagian Profil</label>
                <select id="profilSection" class="w-full border rounded-md px-3 py-3 mb-6">
                    <option value="gambaran">Gambaran Umum</option>
                    <option value="visi">Visi & Misi</option>
                    <option value="selayang">Selayang Pandang</option>
                    <option value="struktur">Struktur Organisasi</option>
                </select>

                <div class="profil-panel" data-panel="gambaran">
                    <label class="block font-bold mb-2">Judul Gambaran Umum</label>
                    <input name="gambaran_judul" value="{{ old('gambaran_judul', $profil->gambaran_judul) }}"
                           class="w-full border rounded-md px-3 py-3 mb-4">

                    <label class="block font-bold mb-2">Isi Gambaran Umum</label>
                    <textarea name="gambaran_isi" rows="10"
                              class="w-full border rounded-md px-3 py-3">{{ old('gambaran_isi', $profil->gambaran_isi) }}</textarea>
                </div>

                <div class="profil-panel hidden" data-panel="visi">
                    <label class="block font-bold mb-2">Visi</label>
                    <textarea name="visi" rows="5"
                              class="w-full border rounded-md px-3 py-3 mb-4">{{ old('visi', $profil->visi) }}</textarea>

                    <div class="flex items-center justify-between mb-2">
                        <label class="font-bold">Misi</label>
                        <button type="button" id="addMisi"
                                class="bg-green-100 text-green-700 px-3 py-2 rounded-md font-bold">
                            + Tambah Misi
                        </button>
                    </div>

                    <div id="misiList" class="space-y-3">
                        @foreach (($profil->misi ?: ['']) as $misi)
                            <div class="misi-row flex gap-2">
                                <span class="misi-number bg-green-50 text-green-700 font-bold rounded-md w-10 h-10 grid place-items-center"></span>
                                <textarea name="misi[]" rows="2" class="grow border rounded-md px-3 py-2">{{ $misi }}</textarea>
                                <button type="button" class="remove-misi bg-red-100 text-red-700 rounded-md w-10 h-10 font-bold">×</button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="profil-panel hidden" data-panel="selayang">
                    <label class="block font-bold mb-2">Judul Selayang Pandang</label>
                    <input name="selayang_judul" value="{{ old('selayang_judul', $profil->selayang_judul) }}"
                           class="w-full border rounded-md px-3 py-3 mb-4">

                    <label class="block font-bold mb-2">Isi Selayang Pandang</label>
                    <textarea name="selayang_isi" rows="10"
                              class="w-full border rounded-md px-3 py-3">{{ old('selayang_isi', $profil->selayang_isi) }}</textarea>
                </div>

                <div class="mb-3">
    <label class="form-label">Struktur Organisasi</label>

    @if($profil->struktur_gambar)
        <div class="mb-2">
            <img src="{{ Storage::url($profil->struktur_gambar) }}"
                 style="max-width:300px; border-radius:10px;">
        </div>
    @endif

    <input type="file"
           name="struktur_gambar"
           class="form-control"
           accept="image/*">

    <small class="text-muted">
        Upload gambar struktur organisasi (JPG/PNG).
    </small>
</div>

                <button class="mt-6 bg-green-600 text-white px-5 py-3 rounded-md font-bold hover:bg-green-700">
                    Simpan Perubahan
                </button>
            </section>
        </form>
    </main>

    <script>
        const select = document.getElementById('profilSection');
        const panels = document.querySelectorAll('.profil-panel');
        const misiList = document.getElementById('misiList');
        const addMisi = document.getElementById('addMisi');

        function showPanel() {
            panels.forEach(panel => {
                panel.classList.toggle('hidden', panel.dataset.panel !== select.value);
            });
        }

        function refreshMisiNumbers() {
            document.querySelectorAll('.misi-row').forEach((row, index) => {
                row.querySelector('.misi-number').textContent = index + 1;
            });
        }

        addMisi.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'misi-row flex gap-2';
            row.innerHTML = `
                <span class="misi-number bg-green-50 text-green-700 font-bold rounded-md w-10 h-10 grid place-items-center"></span>
                <textarea name="misi[]" rows="2" class="grow border rounded-md px-3 py-2"></textarea>
                <button type="button" class="remove-misi bg-red-100 text-red-700 rounded-md w-10 h-10 font-bold">×</button>
            `;
            misiList.appendChild(row);
            refreshMisiNumbers();
            row.querySelector('textarea').focus();
        });

        misiList.addEventListener('click', (event) => {
            if (!event.target.classList.contains('remove-misi')) return;
            event.target.closest('.misi-row').remove();

            if (!misiList.querySelector('.misi-row')) {
                addMisi.click();
            }

            refreshMisiNumbers();
        });

        select.addEventListener('change', showPanel);
        showPanel();
        refreshMisiNumbers();
       </script>
</div>
@endsection