<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Keluarga;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);

        foreach ($spreadsheet->getActiveSheet()->toArray() as $i => $row) {

            if ($i < 4) continue;

            $nik = $row[3] ?? null;
            if (!$nik) continue;

            // SIMPAN KELUARGA
            $keluarga = Keluarga::updateOrCreate(
                ['no_kk' => $row[2]],
                [
                    'nama_kepala_keluarga' => $row[17],
                    'alamat_lengkap' => $row[12],
                    'rt' => $row[13],
                    'rw' => $row[14],
                ]
            );

            // SIMPAN WARGA
            Warga::updateOrCreate(
                ['nik' => $nik],
                [
                    'keluarga_id' => $keluarga->id,
                    'nama_lengkap' => $row[4],
                    'jenis_kelamin' => $row[5],
                    'agama' => $row[9],
                    'pendidikan' => $row[10],
                    'jenis_pekerjaan' => $row[11],
                    'status_perkawinan' => $row[15],
                    'status_hubungan' => $row[16],
                    'kewarganegaraan' => $row[18] ?? 'WNI',
                ]
            );
        }

        return back()->with('success', 'Import berhasil');
    }
}
