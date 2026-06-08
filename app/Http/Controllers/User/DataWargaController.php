<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Keluarga;
use App\Models\Rt;
use App\Models\Rw;

class DataWargaController extends Controller
{
    public function dataWarga()
    {
        return view('user.data-warga');
    }

    public function jumlah()
    {
        $warga = Warga::with('keluarga.rt.rw')->get();

        //Total
        $total = $warga->count();

        $laki = $warga
                ->where('jenis_kelamin', 'LAKI-LAKI')
                ->count();

        $perempuan = $warga
                     ->where('jenis_kelamin', "PEREMPUAN")
                     ->count();

        // per rw & rt
        $perRw = [];
        foreach ($warga as $w)

            $rw = $w->keluarga->rt->rw->nomor_rw ?? '00';
            $rt = $w->keluarga->rt->nomor_rt ?? '00';

            if (!isset($perRw[$rw][$rw])) {
                $perRw[$rw][$rt] = [
                    'laki' => 0,
                    'perempuan' => 0,
                    'total' => 0,
                ];
            }

            if ($w->jenis_kelamin == "LAKI-LAKI") {
                $perRw[$rw][$rt]['laki']++;
            }
            if ($w->jenis_kelamin == "PEREMPUAN") {
                $perRw[$rw][$rt]['perempuan']++;
            }

    return view('user.data-warga.jumlah', compact('total','laki','perempuan', 'perRw'));
    }

    public function umur()
    {
        $warga = Warga::with('keluarga.rt.rw')->get();
        $kelompokUmur = [
            '0-5' => 0,
            '6-12' => 0,
            '13-17' => 0,
            '18-30' => 0,
            '31-50' => 0,
            '>50' => 0,
        ];

        $perRw = [];

        foreach ($warga as $w) {
            if (!$w->tanggal_lahir) continue;

            $umur = \Carbon\Carbon::parse($w->tanggal_lahir)->age;

            // menentukan kelompok umur
            if ($umur <=5) {
                $kategori = '0-5';
            } elseif ($umur <= 12) {
                $kategori = '6-12';
            } elseif ($umur <= 17) {
                $kategori = '13-17';
            } elseif ($umur <= 30) {
                $kategori = '18-30';
            } elseif ($umur <= 50) {
                $kategori = '31-50';
            } else {
                $kategori = '>50';
            }

            // Ambil RW & RT
            $rw = $w->keluarga->rt->rw->nomor_rw ?? 'Tidak Ada';
            $rt = $w->keluarga->rt->nomor_rt ?? 'Tidak Ada';

            // Total semua
            $kelompokUmur[$kategori]++;
            // RW

            if (!isset($perRw[$rw][$rt])) {
                $perRw[$rw][$rt] = [
                    '0-5' => 0,
                    '6-12' => 0,
                    '13-17' => 0,
                    '18-30' => 0,
                    '31-50' => 0,
                    '>50' => 0,
                ];
            }

            $perRw[$rw][$rt][$kategori]++;
        }

        return view('user.data-warga.umur', compact('kelompokUmur', 'perRw'));
    }
 
    //agama
   public function agama()
{
    $warga = Warga::with('keluarga.rt.rw')->get();

    // ======================
    // AGAMA RESMI
    // ======================

    $listAgama = [
        'Islam',
        'Kristen',
        'Katolik',
        'Hindu',
        'Buddha',
        'Konghucu',
    ];

    // ======================
    // INISIALISASI TOTAL
    // ======================

    $agama = [];

    foreach ($listAgama as $a) {
        $agama[$a] = 0;
    }

    $perRw = [];

    foreach ($warga as $w) {

        $namaAgama = trim($w->agama ?? '');

        // normalisasi
        $namaAgama = ucfirst(strtolower($namaAgama));

        // skip kalau tidak valid
        if (!in_array($namaAgama, $listAgama)) {
            continue;
        }

        $rw = $w->keluarga->rt->rw->nomor_rw ?? '00';
        $rt = $w->keluarga->rt->nomor_rt ?? '00';

        // ======================
        // TOTAL KESELURUHAN
        // ======================

        $agama[$namaAgama]++;

        // ======================
        // PER RW & RT
        // ======================

        if (!isset($perRw[$rw][$rt])) {

            foreach ($listAgama as $a) {
                $perRw[$rw][$rt][$a] = 0;
            }
        }

        $perRw[$rw][$rt][$namaAgama]++;
    }

    return view(
        'user.data-warga.agama',
        compact('agama', 'perRw', 'listAgama')
    );
}

    // pendidikan

    public function pendidikan()
{
    $warga = Warga::with('keluarga.rt.rw')->get();

    // ======================
    // Pendidikan
    // ======================

    $listPendidikan = [
        'TIDAK SEKOLAH',
        'TK',
        'SD',
        'SMP',
        'SMA',
        'D1',
        'D2',
        'D3',
        'S1',
        'S2',
        'S3',
    ];

    // ======================
    // INISIALISASI TOTAL
    // ======================

    $pendidikan = [];

    foreach ($listPendidikan as $a) {
        $pendidikan[$a] = 0;
    }

    $perRw = [];

    foreach ($warga as $w) {

        $namaPendidikan = trim($w->pendidikan ?? '');

        // normalisasi
        $raw = strtoupper(trim($w->pendidikan ?? ''));

if (str_contains($raw, 'SD')) {
    $namaPendidikan = 'SD';
}
elseif (str_contains($raw, 'SLTP') || str_contains($raw, 'SMP')) {
    $namaPendidikan = 'SMP';
}
elseif (str_contains($raw, 'SLTA') || str_contains($raw, 'SMA')) {
    $namaPendidikan = 'SMA';
}
elseif (str_contains($raw, 'D1')) {
    $namaPendidikan = 'D1';
}
elseif (str_contains($raw, 'D2')) {
    $namaPendidikan = 'D2';
}
elseif (str_contains($raw, 'D3')) {
    $namaPendidikan = 'D3';
}
elseif (str_contains($raw, 'STRATA I') || str_contains($raw, 'S1')) {
    $namaPendidikan = 'S1';
}
elseif (str_contains($raw, 'STRATA II') || str_contains($raw, 'S2')) {
    $namaPendidikan = 'S2';
}
elseif (str_contains($raw, 'STRATA III') || str_contains($raw, 'S3')) {
    $namaPendidikan = 'S3';
}
else {
    $namaPendidikan = 'TIDAK SEKOLAH';
}

        $rw = $w->keluarga->rt->rw->nomor_rw ?? '00';
        $rt = $w->keluarga->rt->nomor_rt ?? '00';

        // ======================
        // TOTAL KESELURUHAN
        // ======================

        $pendidikan[$namaPendidikan]++;

        // ======================
        // PER RW & RT
        // ======================

        if (!isset($perRw[$rw][$rt])) {

            foreach ($listPendidikan as $a) {
                $perRw[$rw][$rt][$a] = 0;
            }
        }

        $perRw[$rw][$rt][$namaPendidikan]++;
    }

    return view(
        'user.data-warga.pendidikan',
        compact('pendidikan', 'perRw', 'listPendidikan')
    );
}

// Pekerjaan

   public function pekerjaan()
{
    $warga = Warga::with('keluarga.rt.rw')->get();

    $listPekerjaan = [
        'Belum/Tidak Bekerja',
        'Pelajar/Mahasiswa',
        'Mengurus Rumah Tangga',
        'Wiraswasta',
        'Karyawan Swasta',
        'PNS',
        'TNI',
        'POLRI',
        'Guru',
        'Petani',
        'Nelayan',
        'Buruh',
        'Pensiunan',
        'Lainnya',
    ];

    // ======================
    // INISIALISASI TOTAL
    // ======================

    $pekerjaan = [];

    foreach ($listPekerjaan as $a) {
        $pekerjaan[$a] = 0;
    }

    $perRw = [];

    foreach ($warga as $w) {

        $raw = strtoupper(trim($w->jenis_pekerjaan ?? ''));

    if (str_contains($raw, 'BELUM')) {
    $namaPekerjaan = 'Belum/Tidak Bekerja';
    }
    elseif (str_contains($raw, 'PELAJAR') || str_contains($raw, 'MAHASISWA')) {
    $namaPekerjaan = 'Pelajar/Mahasiswa';
    }
    elseif (
    str_contains($raw, 'RUMAH TANGGA') ||
    str_contains($raw, 'IRT')
    ) {
    $namaPekerjaan = 'Mengurus Rumah Tangga';
    }
    elseif (str_contains($raw, 'WIRASWASTA')) {
    $namaPekerjaan = 'Wiraswasta';
    }
    elseif (
    str_contains($raw, 'KARYAWAN') ||
    str_contains($raw, 'SWASTA')
    ) {
    $namaPekerjaan = 'Karyawan Swasta';
    }
    elseif (
    str_contains($raw, 'PNS') ||
    str_contains($raw, 'PEGAWAI NEGERI')
    ) {
    $namaPekerjaan = 'PNS';
    }
    elseif (str_contains($raw, 'TNI')) {
    $namaPekerjaan = 'TNI';
    }
    elseif (str_contains($raw, 'POLRI')) {
    $namaPekerjaan = 'POLRI';
    }
    elseif (str_contains($raw, 'GURU')) {
    $namaPekerjaan = 'Guru';
    }
    elseif (str_contains($raw, 'PETANI')) {
    $namaPekerjaan = 'Petani';
    }
    elseif (str_contains($raw, 'NELAYAN')) {
    $namaPekerjaan = 'Nelayan';
    }
    elseif (str_contains($raw, 'BURUH')) {
    $namaPekerjaan = 'Buruh';
}
elseif (str_contains($raw, 'PENSIUN')) {
    $namaPekerjaan = 'Pensiunan';
}
else {
    $namaPekerjaan = 'Lainnya';
}

        $rw = $w->keluarga->rt->rw->nomor_rw ?? '00';
        $rt = $w->keluarga->rt->nomor_rt ?? '00';

        // ======================
        // TOTAL KESELURUHAN
        // ======================

        $pekerjaan[$namaPekerjaan]++;

        // ======================
        // PER RW & RT
        // ======================

        if (!isset($perRw[$rw][$rt])) {

            foreach ($listPekerjaan as $a) {
                $perRw[$rw][$rt][$a] = 0;
            }
        }

        $perRw[$rw][$rt][$namaPekerjaan]++;
    }

    return view(
        'user.data-warga.pekerjaan',
        compact('pekerjaan', 'perRw', 'listPekerjaan')
    );
}
}
