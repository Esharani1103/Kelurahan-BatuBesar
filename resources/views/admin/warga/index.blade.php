<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Warga - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-container { max-height: 600px; overflow: auto; }
        thead th { position: sticky; top: 0; z-index: 10; background-color: #f3f4f6; }
        .input-box {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-box:focus { border-color: #f97316; }
        /* Style untuk tombol pagination agar cantik */
        .pagination-container nav { display: flex; justify-content: center; gap: 5px; padding: 15px; }
        .pagination-container span, .pagination-container a { padding: 8px 15px; border-radius: 8px; border: 1px solid #e5e7eb; font-size: 12px; }
        .pagination-container .active { background-color: #f97316; color: white; border-color: #f97316; }
    </style>
</head>

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
                            <td class="p-3 border-r font-mono">{{ $w->no_kk }}</td>
                            <td class="p-3 border-r font-mono font-bold text-gray-800">{{ $w->nik }}</td>
                            <td class="p-3 border-r uppercase font-semibold text-blue-900">{{ $w->nama_lengkap }}</td>
                            <td class="p-3 border-r text-center">{{ $w->jenis_kelamin }}</td>
                            <td class="p-3 border-r">{{ $w->tempat_lahir }}</td>
                            <td class="p-3 border-r">{{ $w->tanggal_lahir }}</td>
                            <td class="p-3 border-r text-center font-bold text-orange-600">{{ $w->umur }} Thn</td>
                            <td class="p-3 border-r">{{ $w->agama }}</td>
                            <td class="p-3 border-r">{{ $w->pendidikan }}</td>
                            <td class="p-3 border-r">{{ $w->jenis_pekerjaan }}</td>
                            <td class="p-3 border-r italic">{{ $w->alamat_lengkap }}</td>
                            <td class="p-3 border-r text-center font-bold">{{ $w->rt }}/{{ $w->rw }}</td>
                            <td class="p-3 border-r text-center">{{ $w->status_perkawinan }}</td>
                            <td class="p-3 border-r text-center">{{ $w->status_hubungan }}</td>
                            <td class="p-3 border-r text-blue-700 font-medium">{{ $w->nama_kepala_keluarga }}</td>
                            <td class="p-3 border-r text-orange-600 font-medium italic bg-yellow-50/30">{{ $w->keterangan ?? '-' }}</td>
                            <td class="p-3 text-center sticky right-0 bg-white shadow-l">
                                <div class="flex justify-center gap-1">
                                    <form action="{{ route('warga.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="18" class="p-10 text-center text-gray-400 italic">Data kosong. Silakan Import Excel.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white border-t pagination-container">
                {{ $warga->links() }}
            </div>
        </div>
    </div>

    <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center bg-gray-50 rounded-t-xl">
                <h3 class="text-xl font-bold text-gray-800"><i class="fas fa-user-plus mr-2 text-orange-500"></i>Isi Data Warga Manual</h3>
                <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            
            <form action="{{ route('warga.store') }}" method="POST" class="p-8" autocomplete="off">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">1. Data Kartu Keluarga</h4>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="no_kk" required class="input-box" placeholder="16 digit No KK">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Kepala Keluarga</label>
                            <input type="text" name="nama_kepala_keluarga" class="input-box">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Status Hubungan</label>
                            <input type="text" name="status_hubungan" class="input-box">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">2. Identitas Pribadi</h4>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">NIK</label>
                            <input type="text" name="nik" required class="input-box">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required class="input-box">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="input-box bg-white">
                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Agama</label>
                                <input type="text" name="agama" class="input-box" value="ISLAM">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 border-2 border-orange-100 p-2 rounded-lg">
                            <div>
                                <label class="text-[10px] font-bold text-orange-500 uppercase">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tgl_lahir" onchange="hitungUmur()" required class="input-box border-orange-300">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-orange-500 uppercase">Umur Otomatis</label>
                                <input type="text" name="umur" id="hasil_umur" readonly class="input-box bg-orange-50 font-bold text-orange-700" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-600 border-b-2 border-blue-100 pb-1 text-xs uppercase tracking-wider">3. Detail & Keterangan</h4>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Status Perkawinan</label>
                            <select name="status_perkawinan" class="input-box bg-white">
                                <option value="BELUM KAWIN">BELUM KAWIN</option>
                                <option value="KAWIN">KAWIN</option>
                                <option value="CERAI HIDUP">CERAI HIDUP</option>
                                <option value="CERAI MATI">CERAI MATI</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">RT</label>
                                <input type="text" name="rt" value="004" class="input-box">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">RW</label>
                                <input type="text" name="rw" value="010" class="input-box">
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-orange-600 uppercase">Keterangan Tambahan</label>
                            <input type="text" name="keterangan" class="input-box border-orange-200" placeholder="Catatan admin">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Pekerjaan</label>
                            <input type="text" name="jenis_pekerjaan" class="input-box">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 border-t pt-5">
                    <button type="button" onclick="toggleModal()" class="px-8 py-3 bg-gray-200 rounded-lg font-bold text-gray-600 hover:bg-gray-300 transition">BATAL</button>
                    <button type="submit" class="px-8 py-3 bg-orange-500 text-white rounded-lg font-bold hover:bg-orange-600 shadow-lg transition uppercase">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modalTambah');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function hitungUmur() {
            const tglLahir = document.getElementById('tgl_lahir').value;
            if (tglLahir) {
                const lahir = new Date(tglLahir);
                const hariIni = new Date();
                let umur = hariIni.getFullYear() - lahir.getFullYear();
                const m = hariIni.getMonth() - lahir.getMonth();
                if (m < 0 || (m === 0 && hariIni.getDate() < lahir.getDate())) {
                    umur--;
                }
                document.getElementById('hasil_umur').value = umur;
            }
        }
    </script>
</body>
</html>