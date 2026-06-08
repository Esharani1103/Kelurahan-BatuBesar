<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Keluarga;
use App\Models\Rt;
use App\Models\Rw;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls|max:2048'
    ]);

    $file = $request->file('file');
    $spreadsheet = IOFactory::load($file);

    // COUNTER
    $berhasil = 0;
    $update = 0;
    $gagal = 0;

     // ========================
    // SIMPAN KEPALA KELUARGA
    // ========================
    $kepalaKeluarga = [];
    $rtPerKK = [];
    $lastNoKK = null;

    foreach ($spreadsheet->getActiveSheet()->toArray() as $i => $row) {
        
    

    if ($i < 4) continue; // skip header
    

    // ========================
    // AMBIL DATA DASAR
    // ========================
    $no_kk = preg_replace('/[^0-9]/', '', (string) $row[2]);
    $nik   = preg_replace('/[^0-9]/', '', (string) $row[3]);

    // kalau KK kosong, pakai KK sebelumnya
    if (!$no_kk) {
       $no_kk = $lastNoKK;
    } else {
       $lastNoKK = $no_kk;
    }
    // kalau tetap kosong maka gagal

    if (!$nik && !$no_kk) {
        continue;
    }
    // ========================
    // AMBIL RT & RW
    // ========================
    $nomorRw = trim($row[14] ?? '');
    $nomorRt = trim($row[13] ?? '');

    // kalau RT/RW ada di excel
    if ($nomorRt && $nomorRw) {

    $rw = Rw::where('nomor_rw', $nomorRw)->first();

    if (!$rw) {
        $gagal++;
        continue;
    }
    $rt = Rt::where('nomor_rt', $nomorRt)
            ->where('id_rw', $rw->id_rw)
            ->first();

    if (!$rt) {
        $gagal++;
        continue;
    }
    // simpan RT terakhir per KK
    $rtPerKK[$no_kk] = $rt->id_rt;
  }

   // kalau kosong, pakai RT sebelumnya
   $idRt = $rtPerKK[$no_kk] ?? null;

   if (!$idRt) continue;

    $statusHubungan = strtolower(trim($row[16] ?? ''));

    if ($statusHubungan == 'kepala keluarga') {
    $kepalaKeluarga[$no_kk] = $row[4];
    }

    // ========================
    // KELUARGA
    // ========================
    $keluarga = Keluarga::updateOrCreate(
        ['no_kk' => $no_kk],
        [
            'nama_kepala_keluarga' => $kepalaKeluarga[$no_kk] ?? $row[4],
            'alamat' => $row[12] ?? null,
            'id_rt' => $idRt,
        ]
    );

    // ========================
    // FORMAT TANGGAL
    // ========================
    $tanggal = null;
    if (!empty($row[7])) {
        try {
            $tanggal = \Carbon\Carbon::parse($row[7])->format('Y-m-d');
        } catch (\Exception $e) {
            $tanggal = null;
        }
    }

    // ========================
    // JENIS KELAMIN
    // ========================
    $jk = strtoupper(trim($row[5] ?? ''));

    if ($jk == 'L') $jk = 'LAKI-LAKI';
    elseif ($jk == 'P') $jk = 'PEREMPUAN';

    // ========================
    // WARGA
    // ========================
    $existing = Warga::where('nik', $nik)->first();
    if ($existing) {
        $update++;
    } else { 
        $berhasil++;
    }   
    Warga::updateOrCreate(
        ['nik' => $nik],
        [
            'keluarga_id' => $keluarga->id,
            'nama_lengkap' => $row[4] ?? null,
            'jenis_kelamin' => $jk,
            'tempat_lahir' => $row[6] ?? null,
            'tanggal_lahir' => $tanggal,
            'agama' => $row[9] ?? null,
            'pendidikan' => $row[10] ?? null,
            'jenis_pekerjaan' => $row[11] ?? null,
            'status_perkawinan' => $row[15] ?? null,
            'status_hubungan' => $row[16] ?? null,
            'kewarganegaraan' => $row[18] ?? 'WNI',
            'keterangan' => $row[19] ?? null,
        ]
    );
}

    return back()->with(
        'success',
        "Import selesai: $berhasil data baru, $update data diperbarui, $gagal data gagal."
    );
}
}

