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

    // foreach ($spreadsheet->getActiveSheet()->toArray() as $i => $row)
        $rows = $spreadsheet->getActiveSheet()->toArray();

    $header = $this->cariHeader($rows); 

    if (!$header) {
    return back()->with(
        'error',
        'Format Excel tidak dikenali.'
    );
}

    $startRow = $header['header_row'] + 1;

    $get = function($row, $header, $field, $default = null) {
    return isset($header[$field])
        ? ($row[$header[$field]] ?? $default)
        : $default;
    };

    foreach ($rows as $i => $row)
    {
    if ($i < $startRow) {
        continue;
    }
    if (empty(array_filter($row))) {
        continue;
    }
     $nama = trim(
        $get($row, $header, 'nama', '')
    );

    $nomorRt = trim(
        $get($row, $header, 'rt', '')
    );

    $nomorRw = trim(
        $get($row, $header, 'rw', '')
    );

    $statusHubungan = strtolower(
        trim(
            $get($row, $header, 'status_hubungan', '')
        )
    );
    // ========================
    // AMBIL DATA DASAR
    // ========================
    $no_kk = preg_replace(
    '/[^0-9]/',
    '',
    (string) $get($row, $header, 'no_kk', '')
    );

    $nik = preg_replace(
    '/[^0-9]/',
    '',
    (string) $get($row, $header, 'nik', '')
    );

    // kalau KK kosong, pakai KK sebelumnya
    if (!$no_kk) {
       $no_kk = $lastNoKK;
    } else {
       $lastNoKK = $no_kk;
    }
    // kalau tetap kosong maka gagal

    if (!$nik || !$nama) {
    continue;
}
    // ========================
    // AMBIL RT & RW
    // ========================
    $nomorRt = trim(
    $row[$header['rt'] ?? -1] ?? ''
    );

    $nomorRw = trim(
    $row[$header['rw'] ?? -1] ?? ''
    );

    $rt=null;
    
    // kalau RT/RW ada di excel
    if ($nomorRt && $nomorRw) {

    $rw = Rw::where('nomor_rw', $nomorRw)->first();
    
    if (!$rw) {
    ([
        'baris' => $i,
        'pesan' => 'RW tidak ditemukan',
        'rw_excel' => $nomorRw,
        'nik' => $nik,
        'nama' => $nama,
    ]);
    }
    if ($rw) {

    $rt = Rt::where('nomor_rt', $nomorRt)
            ->where('id_rw', $rw->id_rw)
            ->first();

    if ($rt) {
        $rtPerKK[$no_kk] = $rt->id_rt;
    }
    }

    if (!$rt) {
    $gagal++;
    continue;
    }
    // simpan RT terakhir per KK
    $rtPerKK[$no_kk] = $rt->id_rt;
  }

   // kalau kosong, pakai RT sebelumnya
   $idRt = $rtPerKK[$no_kk] ?? null;
   
    $statusHubungan = strtolower(
    trim(
        $row[$header['status_hubungan'] ?? -1] ?? ''
    )
);

    if ($statusHubungan == 'kepala keluarga') {
    $kepalaKeluarga[$no_kk] = $nama;
    }

    // ========================
    // KELUARGA
    // ========================
    $keluarga = Keluarga::updateOrCreate(
        ['no_kk' => $no_kk],
        [
            'nama_kepala_keluarga' => $kepalaKeluarga[$no_kk] ?? $nama,
            'alamat' => $row[$header['alamat'] ?? -1] ?? null,
            'id_rt' => $idRt,
        ]
    );

    // ========================
    // FORMAT TANGGAL
    // ========================
    $tanggal = null;
    if (
    isset($header['tanggal_lahir']) &&
    !empty($row[$header['tanggal_lahir']])
    ) {
        try {
           $tanggal = Carbon::parse(
            $row[$header['tanggal_lahir']]
            )->format('Y-m-d');
        } catch (\Exception $e) {
            $tanggal = null;
        }
    }

    // ========================
    // JENIS KELAMIN
    // ========================
    $jk = strtoupper(
    trim($row[$header['jk'] ?? -1] ?? '')
    );

    if ($jk == 'L') $jk = 'LAKI-LAKI';
    elseif ($jk == 'P') $jk = 'PEREMPUAN';

    // ========================
    // WARGA
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

            'nama_lengkap' =>
            $row[$header['nama']] ?? null,

            'jenis_kelamin' => $jk,

            'tempat_lahir' =>
            $get($row, $header, 'tempat_lahir'),

            'tanggal_lahir' => $tanggal,

            'agama' =>
            $get($row, $header, 'agama'),

            'pendidikan' =>
            $get($row, $header, 'pendidikan'),

            'jenis_pekerjaan' =>
            $get($row, $header, 'pekerjaan'),

            'status_perkawinan' => trim(
            $get($row, $header, 'status_perkawinan')
            ),

            'status_hubungan' => trim(
            $get($row, $header, 'status_hubungan')
            ),

            'kewarganegaraan' =>
            $get($row, $header, 'kewarganegaraan', 'WNI'),

            'keterangan' =>
            $get($row, $header, 'keterangan'),
            ]
            );
    }
    

    return back()->with(
        'success',
        "Import selesai: $berhasil data baru, $update data diperbarui, $gagal data gagal."
    );
}

     private function cariHeader(array $rows)
{
    $headerMap = [];

    foreach ($rows as $rowIndex => $row) {

        foreach ($row as $colIndex => $cell) {

            $value = strtoupper(trim((string) $cell));

                $map = [

                        'NO KK' => 'no_kk',
                        'NIK' => 'nik',

                        'NAMA LENGKAP' => 'nama',
                        'NAMA' => 'nama',

                        'JENIS KELAMIN' => 'jk',

                        'TEMPAT LAHIR' => 'tempat_lahir',

                        'TANGGAL LAHIR' => 'tanggal_lahir',
                        'TANGGAL LAHIR(BULAN, TANGGAL, TAHUN)' => 'tanggal_lahir',

                        'AGAMA' => 'agama',

                        'PENDIDIKAN' => 'pendidikan',
                        'Pendidikan' => 'pendidikan',

                        'PEKERJAAN' => 'pekerjaan',
                        'JENIS PEKERJAAN' => 'pekerjaan',

                        'STATUS PERKAWINAN' => 'status_perkawinan',
                        'Status Kawin' => 'status_perkawinan',
                        'STATUS KAWIN' => 'status_perkawinan',

                        'STATUS HUBUNGAN' => 'status_hubungan',
                        'STATUS HUBUNGAN DALAM KELUARGA' => 'status_hubungan',
                        'Status Hubungan' => 'status_hubungan',
                        'SHDK' => 'status_hubungan',
                        'STATUS HUB. KELUARGA' => 'status_hubungan',

                        'ALAMAT' => 'alamat',
                        'ALAMAT LENGKAP' => 'alamat',

                        'RT' => 'rt',
                        'RW' => 'rw',

                        'KEWARGANEGARAAN' => 'kewarganegaraan',

                        'KETERANGAN' => 'keterangan',
                    ];

            if (isset($map[$value])) {
                $headerMap[$map[$value]] = $colIndex;
                $headerMap['header_row'] = $rowIndex;
            }
        }

        if (
            isset($headerMap['no_kk']) &&
            isset($headerMap['nik']) &&
            isset($headerMap['nama'])
        ) {
            return $headerMap;
        }
    }

    return null;
}   
}

