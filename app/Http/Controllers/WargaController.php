<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class WargaController extends Controller
{
    public function index() 
    {
    // Kita bagi per 50 orang per halaman biar loading secepat kilat!
    $warga = Warga::orderBy('id', 'asc')->paginate(50); 
    return view('admin.warga.index', compact('warga'));
    }

    // FUNGSI IMPORT EXCEL
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xls,xlsx']);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $totalProcessed = 0;

            foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                $rows = $worksheet->toArray();

                foreach ($rows as $index => $row) {
                    // Data dimulai dari Baris 5 (Index 4)
                    if ($index < 4) continue; 

                    // NIK di Kolom D (Index 3)
                    $nik = isset($row[3]) ? trim($row[3]) : null;

                    // Validasi agar baris kosong tidak masuk
                    if (empty($nik) || !is_numeric($nik)) continue;

                    // Bersihkan tulisan " TAHUN" di kolom Umur (Kolom I / Index 8)
                    $umurRaw = $row[8] ?? null; 
                    $umurClean = $umurRaw ? (int) filter_var($umurRaw, FILTER_SANITIZE_NUMBER_INT) : null;

                    // Logika: Update jika NIK sudah ada, Create jika NIK baru
                    Warga::updateOrCreate(
                        ['nik' => $nik], 
                        [
                            'no_kk'                => $row[2] ?? null,  // Kolom C
                            'nama_lengkap'         => $row[4] ?? null,  // Kolom E
                            'jenis_kelamin'        => $row[5] ?? null,  // Kolom F
                            'tempat_lahir'         => $row[6] ?? null,  // Kolom G
                            'tanggal_lahir'        => $this->transformDate($row[7] ?? null), // Kolom H
                            'umur'                 => $umurClean,       // Kolom I
                            'agama'                => $row[9] ?? null,  // Kolom J
                            'pendidikan'           => $row[10] ?? null, // Kolom K
                            'jenis_pekerjaan'      => $row[11] ?? null, // Kolom L
                            'alamat_lengkap'       => $row[12] ?? null, // Kolom M
                            'rt'                   => $row[13] ?? null, // Kolom N
                            'rw'                   => $row[14] ?? null, // Kolom O
                            'status_perkawinan'    => $row[15] ?? null, // Kolom P
                            'status_hubungan'      => $row[16] ?? null, // Kolom Q
                            'nama_kepala_keluarga' => $row[17] ?? null, // Kolom R
                            'kewarganegaraan'      => $row[18] ?? 'WNI', // Kolom S
                            'keterangan'           => $row[19] ?? 'Import dari Excel', // Kolom Baru: Keterangan
                        ]
                    );
                    $totalProcessed++;
                }
            }

            return back()->with('success', "Sinkronisasi Berhasil! Total $totalProcessed data berhasil diproses.");
        } catch (\Exception $e) {
            return back()->with('error', 'Ada masalah: ' . $e->getMessage());
        }
    }

    // FUNGSI TAMBAH MANUAL (Dengan Keterangan)
    public function store(Request $request)
    {
        // Validasi input manual
        $request->validate([
            'nik' => 'required|unique:wargas,nik',
            'no_kk' => 'required',
            'nama_lengkap' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ]);

        try {
            // Mengambil semua data dari form termasuk 'keterangan'
            Warga::create($request->all()); 
            return back()->with('success', 'Warga baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data: ' . $e->getMessage());
        }
    }

    // FUNGSI EDIT DATA
    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);
        try {
            $warga->update($request->all());
            return back()->with('success', 'Data warga berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    // FUNGSI HAPUS DATA
    public function destroy($id)
    {
        Warga::findOrFail($id)->delete();
        return back()->with('success', 'Data warga berhasil dihapus!');
    }

    // Helper untuk mengubah format tanggal Excel
    private function transformDate($value) {
        if (empty($value)) return null;
        try {
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            }
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}