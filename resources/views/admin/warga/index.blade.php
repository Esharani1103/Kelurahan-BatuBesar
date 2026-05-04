@extends('admin.layouts.app')

@section('title')
Kelola Data Warga
@endsection

@section('content')

<body class="bg-gray-100 p-4 md:p-8">

    <div class="max-w-full mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Data Warga Kelurahan Batu Besar (Admin)</h2>

        @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>❌ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
            ✅ {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-sm font-bold mb-3 text-gray-600 uppercase italic">Langkah 1: Import File Excel</h3>
                <form action="{{ route('warga.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-2">
                    @csrf
                    <input type="file" name="file" required class="text-xs border rounded p-2 flex-1 bg-gray-50">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-xs font-bold transition">
                        <i class="fas fa-sync mr-1"></i> UPDATE DATA DARI EXCEL
                    </button>
                </form>
            </div>

            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-bold text-gray-600 uppercase italic">Langkah 2: Tambah Manual</h3>
                    <p class="text-[10px] text-gray-400">Gunakan ini jika ingin menambah 1 orang saja</p>
                </div>
                <button onclick="toggleModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-bold shadow-md transition transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i> TAMBAH WARGA
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                <span class="text-sm font-bold text-gray-700 italic">Data Warga (Halaman: {{ $warga->currentPage() }})</span>
                <span class="text-xs bg-orange-100 px-2 py-1 rounded text-orange-700 font-bold">Total: {{ $warga->total() }} Orang</span>
            </div>
             <!-- SEARCH -->
             <form method="GET" action="{{ route('warga.index') }}" class="p-4 flex justify-end">
    <div class="relative w-1/3">
        
        <input type="text"
            name="search"
            id="searchInput"
            value="{{ request('search') }}"
            placeholder="Cari NIK, Nama, KK..."
            class="w-full pl-10 pr-10 py-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">

        <!-- ICON KIRI -->
        <span class="absolute left-3 top-2.5 text-gray-400">
            <i class="fas fa-search"></i>
        </span>

        <!-- BUTTON ENTER -->
        <button type="submit"
            class="absolute right-2 top-1.5 bg-orange-500 text-white px-3 py-1 rounded text-xs hover:bg-orange-600">
            Cari
        </button>

    </div>
</form>

            @php
            function highlight($text, $search) {
            if (!$search) return $text;
            return preg_replace(
            "/(" . preg_quote($search, '/') . ")/i",
            '<span class="bg-yellow-200 font-bold">$1</span>',
            $text
            );
            }
            @endphp
            <div class="table-container">
                <table class="w-full text-[11px] text-left border-collapse">
                    <thead>
                        <tr class="text-gray-700 border-b">
                            <th class="p-3 border-r">No</th>
                            <th class="p-3 border-r min-w-[120px]">No KK</th>
                            <th class="p-3 border-r min-w-[120px]">NIK</th>
                            <th class="p-3 border-r min-w-[180px]">Nama Lengkap</th>
                            <th class="p-3 border-r">L/P</th>
                            <th class="p-3 border-r min-w-[100px]">Tempat Lahir</th>
                            <th class="p-3 border-r min-w-[90px]">Tgl Lahir</th>
                            <th class="p-3 border-r text-center">Umur</th>
                            <th class="p-3 border-r">Agama</th>
                            <th class="p-3 border-r">Warga</th>
                            <th class="p-3 border-r min-w-[120px]">Pendidikan</th>
                            <th class="p-3 border-r min-w-[120px]">Pekerjaan</th>
                            <th class="p-3 border-r min-w-[200px]">Alamat Lengkap</th>
                            <th class="p-3 border-r">RT/RW</th>
                            <th class="p-3 border-r min-w-[100px]">Status Kawin</th>
                            <th class="p-3 border-r min-w-[120px]">Status Hubungan</th>
                            <th class="p-3 border-r min-w-[180px]">Kepala Keluarga</th>
                            <th class="p-3 border-r min-w-[150px] bg-yellow-50 text-orange-700">Keterangan</th>
                            <th class="p-3 text-center sticky right-0 bg-gray-100 shadow-l">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($warga as $index => $w)
                        <tr class="hover:bg-orange-50 transition">
                            <td class="p-3 border-r text-center text-gray-400 font-bold">{{ ($warga->currentPage() - 1) * $warga->perPage() + $index + 1 }}</td>
                            <td class="p-3 border-r font-mono">{!! highlight($w->keluarga->no_kk ?? '-', request('search')) !!}</td>
                            <td class="p-3 border-r font-mono font-bold text-gray-800">{!! highlight ($w->nik, request('search')) !!}</td>
                            <td class="p-3 border-r uppercase font-semibold text-blue-900">{!! highlight  ($w->nama_lengkap, request('search')) !!}</td>
                            <td class="p-3 border-r text-center">{{ strtoupper($w->jenis_kelamin) == 'LAKI-LAKI' ? 'L' : 'P' }}</td>
                            <td class="p-3 border-r">{!! highlight ($w->tempat_lahir, request('search')) !!}</td>
                            <td class="p-3 border-r"> {{ $w->tanggal_lahir ? \Carbon\Carbon::parse($w->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                            <td class="p-3 border-r text-center font-bold text-orange-600">{{ $w->tanggal_lahir ? \Carbon\Carbon::parse($w->tanggal_lahir)->age . ' Thn' : '-' }}</td>
                            <td class="p-3 border-r">{!! highlight ($w->agama, request('search')) !!}</td>
                            <td class="p-3 border-r">{!! highlight ($w->kewarganegaraan, request('search')) !!}</td>
                            <td class="p-3 border-r">{!! highlight ($w->pendidikan, request('search')) !!}</td>
                            <td class="p-3 border-r">{!! highlight ($w->jenis_pekerjaan, request('search'))  !!}</td>
                            <td class="p-3 border-r italic">{!! highlight ($w->keluarga->alamat ?? '-', request('search')) !!}</td>
                            <td class="p-3 border-r text-center font-bold">{{ $w->keluarga->rt->nomor_rt ?? '-' }}/{{ $w->keluarga->rt->rw->nomor_rw ?? '-' }}</td>
                            <td class="p-3 border-r text-center">{!! highlight ($w->status_perkawinan, request('search')) !!}</td>
                            <td class="p-3 border-r text-center">{!! highlight($w->status_hubungan, request('search')) !!}</td>
                            <td class="p-3 border-r text-blue-700 font-medium">{!! highlight ($w->keluarga->nama_kepala_keluarga ?? '-', request('search')) !!}</td>
                            <td class="p-3 border-r text-orange-600 font-medium italic bg-yellow-50/30">{!! highlight ($w->keterangan ?? '-', request('search')) !!}</td>
                            <td class="p-3 text-center sticky right-0 bg-white shadow-l">
                                <div class="flex justify-center gap-2">
                                    <!-- EDIT -->
                                    <button
                                    class="btn-edit"
                                    data-id="{{ $w->id }}"
                                    data-warga='@json($w, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                    data-keluarga='@json($w->keluarga, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'
                                    >
                                     <i class="fas fa-edit"></i>
                                    </button>
                                
                                    <!--Delete-->
                                    <button type="button"
                                    class="btn-delete text-red-500 hover:text-red-700 p-1"
                                    data-id="{{ $w->id }}"
                                    data-nama="{{ $w->nama_lengkap }}"
                                    data-jumlah="{{ $w->keluarga->wargas->count() }}"
                                    >
                                    <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="19" class="p-10 text-center text-gray-400 italic">Data kosong. Silakan Import Excel.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </table>
</div>

<!--  MODAL EDIT (1 saja) -->
<div id="modalEdit" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
         <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Header-->
            <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                <h3 class="text-xl font-bold"></i>Edit Data Warga</h3>
            </div>

             <!-- form -->
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <!-- BODY (SCROLL DI SINI) -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- kolom 1-->
                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">1. Data Kartu Keluarga</h4>
                        <div>
                        <label for="edit_no_kk" class="text-[10px] font-bold text-gray-400 uppercase">
                        Nomor Kartu Keluarga (KK)
                        </label>
                        <input type="text" name="no_kk" id="edit_no_kk" required class="input-box" placeholder="Masukkan Nomor KK">
                        </div>
                        <div>
                        <label for="edit_rt" class="text-[10px] font-bold text-gray-400 uppercase">
                        RT
                        </label>
                        <input type="number" name="rt" id="edit_rt" class="input-box" required>
                        </div>

                        <div>
                        <label for="edit_rw" class="text-[10px] font-bold text-gray-400 uppercase">
                        RW
                        </label>
                        <input type="number" name="rw" id="edit_rw" class="input-box" required>
                        </div>
                        <div>
                            <label for="edit_status_hubungan" class="text-[10px] font-bold text-gray-400 uppercase">Status Hubungan</label>
                            <input type="text" name="status_hubungan" id="edit_status_hubungan" class="input-box">
                        </div>
                    </div>
                    <!-- kolom 2-->
                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">2. Identitas Pribadi</h4>
                        <div>
                            <label for="edit_nik" class="text-[10px] font-bold text-gray-400 uppercase">NIK</label>
                            <input type="text" name="nik" id="edit_nik" required class="input-box">
                        </div>
                        <div>
                            <label for="edit_nama_lengkap" class="text-[10px] font-bold text-gray-400 uppercase">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required class="input-box">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="edit_jenis_kelamin" class="text-[10px] font-bold text-gray-400 uppercase">Jenis Kelamin</label>
                                <select name="jenis_kelamin"  id="edit_jenis_kelamin" class="input-box bg-white">
                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                            </div>
                            <div>
                                <label for="edit_agama" class="text-[10px] font-bold text-gray-400 uppercase">Agama</label>
                                <input type="text" name="agama" id="edit_agama" class="input-box" value="ISLAM">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 border-2 border-orange-100 p-2 rounded-lg">
                            <div>
                                <label for="edit_tanggal_lahir" class="text-[10px] font-bold text-orange-500 uppercase">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" onchange="hitungUmur(this)" required class="input-box border-orange-300">
                            </div>
                            <div>
                                <label for="hasil_umur" class="text-[10px] font-bold text-orange-500 uppercase">Umur Otomatis</label>
                                <input type="text" name="umur" id="hasil_umur_edit" readonly class="input-box bg-orange-50 font-bold text-orange-700" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">3. Detail & Keterangan</h4>
                        <div>
                            <label for="edit_status_perkawinan" class="text-[10px] font-bold text-gray-400 uppercase">Status Perkawinan</label>
                            <select name="status_perkawinan" id="edit_status_perkawinan" class="input-box bg-white">
                                <option value="BELUM KAWIN">BELUM KAWIN</option>
                                <option value="KAWIN">KAWIN</option>
                                <option value="CERAI HIDUP">CERAI HIDUP</option>
                                <option value="CERAI MATI">CERAI MATI</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                            <label for="edit_nama_kepala_keluarga" class="text-[10px] font-bold text-gray-400 uppercase">
                            Nama Kepala Keluarga
                            </label>
                            <input type="text" name="nama_kepala_keluarga" id="edit_nama_kepala_keluarga" class="input-box">
                            </div>
                        </div>
                        <div>
                        <label for="edit_alamat_lengkap" class="text-[10px] font-bold text-gray-400 uppercase">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" id="edit_alamat_lengkap" class="input-box"></textarea>
                        </div>
                        <div>
                            <label for="edit_keterangan" class="text-[10px] font-bold text-orange-600 uppercase">Keterangan Tambahan</label>
                            <input type="text" name="keterangan" id="edit_keterangan" class="input-box border-orange-200" placeholder="Catatan admin">
                        </div>
                        <div>
                            <label for="edit_jenis_pekerjaan" class="text-[10px] font-bold text-gray-400 uppercase">Pekerjaan</label>
                            <input type="text" name="jenis_pekerjaan" id="edit_jenis_pekerjaan" class="input-box">
                        </div>
                        <div>
                        <label for="edit_pendidikan" class="text-[10px] font-bold text-gray-400 uppercase">Pendidikan</label>
                        <input type="text" name="pendidikan" id="edit_pendidikan" class="input-box">
                        </div>

                        <div>
                        <label for="edit_tempat_lahir" class="text-[10px] font-bold text-gray-400 uppercase">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="edit_tempat_lahir"class="input-box">
                        </div>

                        <div>
                        <label for="edit_kewarganegaraan" class="text-[10px] font-bold text-gray-400 uppercase">Kewarganegaraan</label>
                        <select name="kewarganegaraan" id="edit_kewarganegaraan" class="input-box">
                        <option value="WNI">WNI</option>
                        <option value="WNA">WNA</option>
                        </select>
                        </div>
                </div>
                        <!-- FOOTER (TOMBOL FIX EDIT) -->
                 <div class="border-t p-4 flex justify-end gap-3 bg-white">
                <button type="button" onclick="closeEditModal()"
                    class="px-6 py-2 bg-gray-200 rounded-lg font-bold">
                    BATAL
                </button>

                <button type="submit"
                    class="px-6 py-2 bg-orange-500 text-white rounded-lg font-bold">
                    SIMPAN
                </button>
            </div>
</div>
</div>
        </form>
    </div>
</div>

<!-- MODAL DELETE -->
 <div id="modalDelete"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl shadow-lg w-80">
        <h2 class="text-lg font-bold mb-2">Hapus Data</h2>

        <p class="text-sm text-gray-600 mb-2">
            Yakin hapus <span id="namaWarga" class="font-bold"></span>?
        </p>

        <p id="warningText" class="text-xs text-red-500 mb-4 hidden">
            ⚠ Ini adalah anggota terakhir dalam KK. Data keluarga juga akan terhapus!
        </p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-3">
                <button type="button"
                    class= "btn-close-delete px-4 py-2 bg-gray-300 rounded">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>


<!--Modal tambah -->
    <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Header-->
            <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                <h3 class="text-xl font-bold"></i>Isi Data Warga Manual</h3>
                <button onclick="toggleModal()" >✕</button>
            </div>
             <!-- form -->
            
            <form action="{{ route('warga.store') }}" method="POST" class="p-8" autocomplete="off">
                @csrf
                <!-- BODY (SCROLL DI SINI) -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!--kolom 1-->
                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">1. Data Kartu Keluarga</h4>
                        <div>
                            <label for="no_kk" class="text-[10px] font-bold text-gray-400 uppercase">
                            Nomor Kartu Keluarga (KK)
                            </label>
                            <input type="text" name="no_kk" id="no_kk" required class="input-box" placeholder="Masukkan Nomor KK">
                        </div>
                        <div>
                            <label for="rt" class="text-[10px] font-bold text-gray-400 uppercase">
                            RT
                            </label>
                            <input type="number" name="rt" id="rt" class="input-box" required>
                       </div>
                        <div>
                            <label for="rw" class="text-[10px] font-bold text-gray-400 uppercase">
                            RW
                            </label>
                            <input type="number" name="rw" id="rw" class="input-box" required>
                        </div>
                        <div>
                            <label for="status_hubungan" class="text-[10px] font-bold text-gray-400 uppercase">Status Hubungan</label>
                            <input type="text" name="status_hubungan" id="status_hubungan" class="input-box">
                        </div>
                    </div>
                    <!-- kolom 2 -->
                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">2. Identitas Pribadi</h4>
                            <div>
                                <label for="nik" class="text-[10px] font-bold text-gray-400 uppercase">NIK</label>
                                <input type="text" name="nik" id="nik" required class="input-box">
                            </div>
                            <div>
                                <label for="nama_lengkap" class="text-[10px] font-bold text-gray-400 uppercase">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" required class="input-box">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="jenis_kelamin" class="text-[10px] font-bold text-gray-400 uppercase">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="input-box bg-white">
                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                            </div>
                            <div>
                                <label  for="agama" class="text-[10px] font-bold text-gray-400 uppercase">Agama</label>
                                <input type="text" name="agama" id="agama" class="input-box" value="ISLAM">
                            </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 border-2 border-orange-100 p-2 rounded-lg">
                            <div>
                                <label for="tanggal_lahir" class="text-[10px] font-bold text-orange-500 uppercase">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" onchange="hitungUmur(this)" required class="input-box border-orange-300">
                            </div>
                            <div>
                                <label for="hasil_umur" class="text-[10px] font-bold text-orange-500 uppercase">Umur Otomatis</label>
                                <input type="text"  name="umur" id="hasil_umur" readonly class="input-box bg-orange-50 font-bold text-orange-700" placeholder="0">
                            </div>
                    </div>
                    </div>
                    </div>

                    <!--kolom 3-->
                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">3. Detail & Keterangan</h4>
                        <div>
                            <label for="status_perkawinan" class="text-[10px] font-bold text-gray-400 uppercase">Status Perkawinan</label>
                            <select id="status_perkawinan" name="status_perkawinan" class="input-box bg-white">>
                                <option value="BELUM KAWIN">BELUM KAWIN</option>
                                <option value="KAWIN">KAWIN</option>
                                <option value="CERAI HIDUP">CERAI HIDUP</option>
                                <option value="CERAI MATI">CERAI MATI</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                            <label for="nama_kepala_keluarga" class="text-[10px] font-bold text-gray-400 uppercase">
                            Nama Kepala Keluarga
                            </label>
                            <input type="text" name="nama_kepala_keluarga" id="nama_kepala_keluarga" class="input-box">
                            </div>
                        </div>
                        <div>
                        <label for="alamat_lengkap" class="text-[10px] font-bold text-gray-400 uppercase">Alamat Lengkap</label>
                        <textarea id="alamat_lengkap" name="alamat_lengkap" class="input-box"></textarea>
                        </div>
                        <div>
                            <label for="keterangan" class="text-[10px] font-bold text-orange-600 uppercase">Keterangan Tambahan</label>
                            <input name="keterangan" type="text" id="keterangan" class="input-box border-orange-200" placeholder="Catatan admin">
                        </div>
                        <div>
                            <label for="jenis_pekerjaan" class="text-[10px] font-bold text-gray-400 uppercase">Pekerjaan</label>
                            <input name="jenis_pekerjaan" type="text" id="jenis_pekerjaan" class="input-box">
                        </div>
                        <div>
                        <label for="pendidikan" class="text-[10px] font-bold text-gray-400 uppercase">Pendidikan</label>
                        <input name="pendidikan" type="text" id="pendidikan" class="input-box">
                        </div>

                        <div>
                        <label for="tempat_lahir" class="text-[10px] font-bold text-gray-400 uppercase">Tempat Lahir</label>
                        <input name="tempat_lahir" type="text" id="tempat_lahir" class="input-box">
                        </div>

                        <div>
                        <label for="kewarganegaraan" class="text-[10px] font-bold text-gray-400 uppercase">Kewarganegaraan</label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="input-box">
                        <option value="WNI">WNI</option>
                        <option value="WNA">WNA</option>
                        </select>
                        </div>
                    </div>
             

                        <!-- FOOTER (TOMBOL FIX) -->
                <div class="border-t p-4 flex justify-end gap-3 bg-white">
                <button type="button" onclick="toggleModal()"
                    class="px-6 py-2 bg-gray-200 rounded-lg font-bold">
                    BATAL
                </button>

                <button type="submit"
                    class="px-6 py-2 bg-orange-500 text-white rounded-lg font-bold">
                    SIMPAN
                </button>
                </div>
            </div>
        </div>
        </form>
</div>
    </div>
</div>
</div>
</div>
    <script>
function toggleModal() {
    const modal = document.getElementById('modalTambah');
    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
}

let timeout = null;

document.getElementById('searchInput').addEventListener('keyup', function () {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        this.form.submit();
    }, 1500); // tunggu 0.5 detik setelah user berhenti ngetik
});

function hitungUmur(el) {
    const tglLahir = el.value;

    if (tglLahir) {
        const lahir = new Date(tglLahir);
        const hariIni = new Date();

        let umur = hariIni.getFullYear() - lahir.getFullYear();
        const m = hariIni.getMonth() - lahir.getMonth();

        if (m < 0 || (m === 0 && hariIni.getDate() < lahir.getDate())) {
            umur--;
        }

        // cari input umur di sebelahnya
        const parent = el.closest('.grid');
        const output = el.parentElement.nextElementSibling.querySelector('input');

        if (output) {
            output.value = umur;
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {

    // DELETE
    document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {

        const id = this.dataset.id;
        const nama = this.dataset.nama;
        const jumlah = parseInt(this.dataset.jumlah);

        const modal = document.getElementById('modalDelete');
        const form = document.getElementById('deleteForm');
        const warning = document.getElementById('warningText');

        form.action = `/admin/warga/${id}`;
        document.getElementById('namaWarga').innerText = nama;

        // 🔥 LOGIKA WARNING
        if (jumlah === 1) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
    });

    window.closeDeleteModal = function() {
    const modal = document.getElementById('modalDelete');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
};

document.querySelectorAll('.btn-close-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        closeDeleteModal(); // sekarang aman
    });
});

    // EDIT
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {

            const warga = JSON.parse(this.dataset.warga);
            const keluarga = JSON.parse(this.dataset.keluarga);

            const modal = document.getElementById('modalEdit');
            const form = document.getElementById('editForm');

            form.action = `/admin/warga/${this.dataset.id}`;

            // WARGA
            document.getElementById('edit_nik').value = warga.nik ?? '';
            document.getElementById('edit_nama_lengkap').value = warga.nama_lengkap ?? '';
            document.getElementById('edit_jenis_kelamin').value = warga.jenis_kelamin ?? '';
            document.getElementById('edit_tempat_lahir').value = warga.tempat_lahir ?? '';
            document.getElementById('edit_tanggal_lahir').value = warga.tanggal_lahir ?? '';
            document.getElementById('edit_agama').value = warga.agama ?? '';
            document.getElementById('edit_status_perkawinan').value = warga.status_perkawinan ?? '';
            document.getElementById('edit_status_hubungan').value = warga.status_hubungan ?? '';
            document.getElementById('edit_kewarganegaraan').value = warga.kewarganegaraan ?? '';
            document.getElementById('edit_keterangan').value = warga.keterangan ?? '';
            document.getElementById('edit_pendidikan').value = warga.pendidikan ?? '';
            document.getElementById('edit_jenis_pekerjaan').value = warga.jenis_pekerjaan ?? '';

            // KELUARGA
            document.getElementById('edit_no_kk').value = keluarga?.no_kk ?? '';
            document.getElementById('edit_rt').value = keluarga?.rt?.nomor_rt ?? '';
            document.getElementById('edit_rw').value = keluarga?.rt?.rw?.nomor_rw ?? '';
            document.getElementById('edit_alamat_lengkap').value = keluarga?.alamat ?? '';
            document.getElementById('edit_nama_kepala_keluarga').value = keluarga?.nama_kepala_keluarga ?? '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    window.closeEditModal = function() {
        const modal = document.getElementById('modalEdit');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // CLICK OUTSIDE
    window.addEventListener('click', function(e) {
        const modalEdit = document.getElementById('modalEdit');
        const modalDelete = document.getElementById('modalDelete');

        if (e.target === modalEdit) closeEditModal();
        if (e.target === modalDelete) closeDeleteModal();
    });

});
</script>
</body>
@endsection