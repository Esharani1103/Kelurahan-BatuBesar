@extends('admin.layouts.app')
@section('title') Kelola Statistik @endsection
@section('content')
<div class="container py-8">

    <h1 class="text-3xl font-bold mb-2">Statistik & Info Kelurahan</h1>
    <p class="text-sm text-gray-500 mb-6">Kelola data yang ditampilkan di beranda.</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    {{-- TAB NAVIGATION --}}
    @php $tab = request('tab', 'statistik'); @endphp
    <div class="flex border-b border-gray-300 mb-6">
       <!-- <a href="{{ route('admin.statistik.index', ['tab'=>'statistik']) }}"
           class="px-5 py-3 text-sm font-bold {{ $tab==='statistik' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-400 hover:text-gray-600' }}">
            📊 Statistik Beranda
        </a>-->
        <a href="{{ route('admin.statistik.index', ['tab'=>'info']) }}"
           class="px-5 py-3 text-sm font-bold {{ $tab==='info' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-400 hover:text-gray-600' }}">
            🏛️ Info Kelurahan
        </a>
        <a href="{{ route('admin.statistik.index', ['tab'=>'kodepos']) }}"
           class="px-5 py-3 text-sm font-bold {{ $tab==='kodepos' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-400 hover:text-gray-600' }}">
            📮 Kode Pos Wilayah
        </a>
    </div>

    {{-- ══════════════════════════════════════
         TAB 1: STATISTIK BERANDA
         ══════════════════════════════════════ --}}
    <!--@if($tab === 'statistik')
    <div class="bg-white rounded-lg shadow border border-gray-200 max-w-2xl">
        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold text-lg">Statistik Beranda</h2>
            <p class="text-xs text-gray-400 mt-1">Ditampilkan di section animasi counter pada beranda.</p>
        </div>
        <form method="POST" action="{{ route('admin.statistik.update') }}" class="p-5">
            @csrf
            @php
            $fields = [
                ['key'=>'penduduk',       'label'=>'Total Penduduk',   'ikon'=>'👥', 'ph'=>'4820'],
                ['key'=>'kk',             'label'=>'Kepala Keluarga',  'ikon'=>'🏠', 'ph'=>'1246'],
                ['key'=>'rw',             'label'=>'Rukun Warga',      'ikon'=>'🗺️', 'ph'=>'6'],
                ['key'=>'rt',             'label'=>'Rukun Tetangga',   'ikon'=>'🏘️', 'ph'=>'24'],
                ['key'=>'luas_wilayah',   'label'=>'Luas Wilayah',     'ikon'=>'🏙️', 'ph'=>'~12 km²'],
                ['key'=>'surat_bulan_ini','label'=>'Surat Bulan Ini',  'ikon'=>'📋', 'ph'=>'128'],
            ];
            @endphp

            @foreach($fields as $i => $f)
                @php $row = $statistik[$f['key']] ?? null; @endphp
                <input type="hidden" name="data[{{ $i }}][key]"   value="{{ $f['key'] }}">
                <input type="hidden" name="data[{{ $i }}][label]" value="{{ $f['label'] }}">
                <input type="hidden" name="data[{{ $i }}][ikon]"  value="{{ $f['ikon'] }}">
                <div class="flex items-center gap-3 py-3 border-b border-gray-100 last:border-0">
                    <span class="text-2xl w-9 text-center">{{ $f['ikon'] }}</span>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 mb-1">{{ $f['label'] }}</label>
                        <input type="text" name="data[{{ $i }}][nilai]"
                               value="{{ old('data.'.$i.'.nilai', $row->nilai ?? '') }}"
                               placeholder="{{ $f['ph'] }}" required
                               class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-green-500">
                    </div>
                    <button type="button" onclick="simpanSatu('{{ $f['key'] }}', this)"
                            class="bg-green-100 text-green-700 px-3 py-1.5 rounded text-xs font-bold hover:bg-green-200 shrink-0">
                        Simpan
                    </button>
                </div>
            @endforeach

            <button type="submit"
                    class="mt-4 w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">
                💾 Simpan Semua
            </button>
        </form>
    </div>
-->
    {{-- ══════════════════════════════════════
         TAB 2: INFO KELURAHAN
         ══════════════════════════════════════ --}}
    @elseif($tab === 'info')
    <div class="bg-white rounded-lg shadow border border-gray-200 max-w-2xl">
        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold text-lg">Info Kelurahan</h2>
            <p class="text-xs text-gray-400 mt-1">Ditampilkan di sidebar kiri beranda (kartu Info Kelurahan).</p>
        </div>
        <form method="POST" action="{{ route('admin.statistik.update-info') }}" class="p-5">
            @csrf
            @php
            $infoFields = [
                ['key'=>'kecamatan',    'label'=>'Kecamatan',   'ph'=>'Nongsa'],
                ['key'=>'kota',         'label'=>'Kota',         'ph'=>'Batam'],
                ['key'=>'provinsi',     'label'=>'Provinsi',     'ph'=>'Kepri'],
                ['key'=>'kode_pos',     'label'=>'Kode Pos',     'ph'=>'29465'],
                ['key'=>'luas_sidebar', 'label'=>'Luas Wilayah', 'ph'=>'~12 km²'],
                ['key'=>'jml_rt',       'label'=>'Jumlah RT',    'ph'=>'24 RT'],
                ['key'=>'jml_rw',       'label'=>'Jumlah RW',    'ph'=>'6 RW'],
            ];
            @endphp

            @foreach($infoFields as $i => $f)
                @php $row = $statistik[$f['key']] ?? null; @endphp
                <input type="hidden" name="info[{{ $i }}][key]"   value="{{ $f['key'] }}">
                <input type="hidden" name="info[{{ $i }}][label]" value="{{ $f['label'] }}">
                <div class="flex items-center gap-3 py-3 border-b border-gray-100 last:border-0">
                    <span class="text-sm font-bold text-gray-400 w-28 shrink-0">{{ $f['label'] }}</span>
                    <div class="flex-1">
                        <input type="text" name="info[{{ $i }}][nilai]"
                               value="{{ old('info.'.$i.'.nilai', $row->nilai ?? '') }}"
                               placeholder="{{ $f['ph'] }}" required
                               class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-green-500">
                    </div>
                    <button type="button" onclick="simpanSatu('{{ $f['key'] }}', this)"
                            class="bg-green-100 text-green-700 px-3 py-1.5 rounded text-xs font-bold hover:bg-green-200 shrink-0">
                        Simpan
                    </button>
                </div>
            @endforeach

            <button type="submit"
                    class="mt-4 w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">
                💾 Simpan Semua Info
            </button>
        </form>
    </div>

    {{-- ══════════════════════════════════════
         TAB 3: KODE POS
         ══════════════════════════════════════ --}}
    @elseif($tab === 'kodepos')
    <div class="bg-white rounded-lg shadow border border-gray-200 max-w-xl">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-lg">Kode Pos Wilayah</h2>
                <p class="text-xs text-gray-400 mt-1">Ditampilkan di sidebar kiri beranda. Bisa ditambah bebas.</p>
            </div>
            <button type="button" onclick="tambahKodepos()"
                    class="bg-green-700 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-green-800">
                + Tambah
            </button>
        </div>
        <form method="POST" action="{{ route('admin.statistik.update-kodepos') }}" class="p-5">
            @csrf
            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded mb-4 text-sm">
                    @foreach($errors->all() as $e) <p>{{ $e }}</p> @endforeach
                </div>
            @endif

            <div id="kodeposList" class="space-y-2 mb-4">
                @php $existingKodepos = old('kodepos', \App\Models\Statistik::kodeposList()); @endphp
                @foreach($existingKodepos as $i => $kp)
                <div class="kodepos-row flex gap-2 items-center">
                    <input type="text" name="kodepos[{{ $i }}][wilayah]"
                           value="{{ $kp['wilayah'] }}" placeholder="Nama wilayah" required
                           class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                    <input type="text" name="kodepos[{{ $i }}][kode]"
                           value="{{ $kp['kode'] }}" placeholder="29465" required
                           class="w-24 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
                    <button type="button" onclick="hapusKodepos(this)"
                            class="text-red-400 hover:text-red-600 font-bold text-lg shrink-0">✕</button>
                </div>
                @endforeach
            </div>

            <button type="submit"
                    class="w-full bg-green-700 text-white py-2 rounded font-bold hover:bg-green-800">
                💾 Simpan Kode Pos
            </button>
        </form>
    </div>
    @endif

</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

async function simpanSatu(key, btn) {
    const row   = btn.closest('.flex');
    const input = row.querySelector('input[type="text"]');
    const nilai = input.value.trim();
    if (!nilai) { alert('Nilai tidak boleh kosong.'); return; }
    btn.disabled = true; btn.textContent = '...';
    try {
        const res  = await fetch(`/admin/statistik/${key}`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ nilai })
        });
        const data = await res.json();
        btn.textContent = data.success ? '✅' : '❌';
        setTimeout(() => { btn.textContent = 'Simpan'; btn.disabled = false; }, 1500);
    } catch { btn.textContent = '❌'; btn.disabled = false; }
}

function tambahKodepos() {
    const list  = document.getElementById('kodeposList');
    const count = list.querySelectorAll('.kodepos-row').length;
    const row   = document.createElement('div');
    row.className = 'kodepos-row flex gap-2 items-center';
    row.innerHTML = `
        <input type="text" name="kodepos[${count}][wilayah]" placeholder="Nama wilayah" required
               class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
        <input type="text" name="kodepos[${count}][kode]" placeholder="29465" required
               class="w-24 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-green-500">
        <button type="button" onclick="hapusKodepos(this)"
                class="text-red-400 hover:text-red-600 font-bold text-lg flex-shrink-0">✕</button>`;
    list.appendChild(row);
    row.querySelector('input').focus();
}

function hapusKodepos(btn) {
    const list = document.getElementById('kodeposList');
    if (list.querySelectorAll('.kodepos-row').length <= 1) {
        alert('Harus ada minimal 1 kode pos.'); return;
    }
    btn.closest('.kodepos-row').remove();
    // Re-index
    list.querySelectorAll('.kodepos-row').forEach((row, i) => {
        row.querySelectorAll('input').forEach(inp => {
            inp.name = inp.name.replace(/\[\d+\]/, `[${i}]`);
        });
    });
}
</script>
@endsection