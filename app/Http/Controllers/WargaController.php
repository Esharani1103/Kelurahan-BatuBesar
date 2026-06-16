<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Keluarga;
use App\Models\Rt;
use App\Models\Rw;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Border;

class WargaController extends Controller
{
   public function index(Request $request)
{
    $query = Warga::with('keluarga.rt.rw')
                ->orderBy('keluarga_id')
                ->orderByRaw("
                   CASE 
                WHEN status_hubungan = 'Kepala Keluarga' THEN 0
                ELSE 1
                END
                ");

    // SEARCH
    if ($request->search) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('nik', 'like', "%$search%")
              ->orWhere('nama_lengkap', 'like', "%$search%")
              ->orWhere('tempat_lahir', 'like', "%$search%")
              ->orWhere('agama', 'like', "%$search%")
              ->orWhere('kewarganegaraan', 'like', "%$search%")
              ->orWhereHas('keluarga', function ($q2) use ($search) {
                  $q2->where('no_kk', 'like', "%$search%")
                     ->orWhere('alamat', 'like', "%$search%");
              });
        });
    }

    // PAGINATION
    $warga = $query->paginate(100)->withQueryString();

    $keluargas = Keluarga::all();

    return view('admin.warga.index', compact('warga','keluargas'));
}

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required',
            'nama_kepala_keluarga' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'nik' => 'required|unique:wargas,nik',
            'nama_lengkap' => 'required'
        ]);
         
     $rw = Rw::where('nomor_rw', $request->rw)->first();

     if (!$rw) {
        return back()->withErrors('RW tidak ditemukan');
    }
    $rt = Rt::where('nomor_rt', $request->rt)
            ->where('id_rw', $rw->id_rw)
            ->first();

    if (!$rt) {
        return back()->withErrors('RT tidak ditemukan di RW tersebut');
    }
    if ($request->jenis_pekerjaan == 'LAINNYA') {

    $pekerjaan = strtoupper(
        $request->pekerjaan_lain
    );

    } else {

    $pekerjaan = $request->jenis_pekerjaan;
    }
    
    $keluarga = Keluarga::updateOrCreate(
        ['no_kk' => $request->no_kk],
        [
            'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
            'alamat' => $request->alamat_lengkap,
            'id_rt' => $rt->id_rt
        ]
    );


        Warga::create([
            'keluarga_id' => $keluarga->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'jenis_pekerjaan' => $pekerjaan,
            'status_perkawinan' => $request->status_perkawinan,
            'status_hubungan' => $request->status_hubungan,
            'kewarganegaraan' => $request->kewarganegaraan,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Data warga berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
    $warga = Warga::findOrFail($id);

    $request->validate([
    'nik' => 'required|unique:wargas,nik,' . $id,
    'nama_lengkap' => 'required',
    ]);

    $rw = Rw::where('nomor_rw', $request->rw)->first();

    if (!$rw) {
    return back()->withErrors('RW tidak ditemukan');
    }

    $rt = Rt::where('nomor_rt', $request->rt)
        ->where('id_rw', $rw->id_rw)
        ->first();

    if (!$rt) {
    return back()->withErrors('RT tidak ditemukan di RW tersebut');
    }

    if ($request->jenis_pekerjaan == 'LAINNYA') {

    $pekerjaan = strtoupper(
        $request->pekerjaan_lain
    );

    } else {

    $pekerjaan = $request->jenis_pekerjaan;
    }

    $warga->update([
    'nik' => $request->nik,
    'nama_lengkap' => $request->nama_lengkap,
    'jenis_kelamin' => $request->jenis_kelamin,
    'tempat_lahir' => $request->tempat_lahir,
    'tanggal_lahir' => $request->tanggal_lahir,
    'agama' => $request->agama,
    'status_perkawinan' => $request->status_perkawinan,
    'pendidikan' => $request->pendidikan,
    'jenis_pekerjaan' => $pekerjaan,
    'status_hubungan' => $request->status_hubungan,
    'kewarganegaraan' => $request->kewarganegaraan,
    'keterangan' => $request->keterangan,
    ]);

   if ($request->no_kk) {
    $warga->keluarga->update([
        'id_rt' => $rt->id_rt,
        'no_kk' => $request->no_kk,
        'alamat' => $request->alamat_lengkap,
        'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
        
    ]);
    }

    return back()->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id)
{
    $warga = Warga::findOrFail($id);
    $keluarga = $warga->keluarga;

    $warga->delete();

    if ($keluarga && $keluarga->wargas()->count() == 0) {
        $keluarga->delete();
    }

    return back()->with('success', 'Data berhasil dihapus');
}

    public function export()
{
    $wargas = Warga::with('keluarga.rt.rw')->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'NO KK');
    $sheet->setCellValue('B1', 'NIK');
    $sheet->setCellValue('C1', 'NAMA LENGKAP');
    $sheet->setCellValue('D1', 'JENIS KELAMIN');
    $sheet->setCellValue('E1', 'TEMPAT LAHIR');
    $sheet->setCellValue('F1', 'TANGGAL LAHIR');
    $sheet->setCellValue('G1', 'AGAMA');
    $sheet->setCellValue('H1', 'PENDIDIKAN');
    $sheet->setCellValue('I1', 'PEKERJAAN');
    $sheet->setCellValue('J1', 'STATUS PERKAWINAN');
    $sheet->setCellValue('K1', 'STATUS HUBUNGAN');
    $sheet->setCellValue('L1', 'RT');
    $sheet->setCellValue('M1', 'RW');
    $sheet->setCellValue('N1', 'ALAMAT');
    $sheet->setCellValue('O1', 'KETERANGAN');

    $row = 2;

    foreach ($wargas as $warga) {

        $sheet->setCellValueExplicit(
        'A'.$row,
        (string) ($warga->keluarga->no_kk ?? ''),
        \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
        'B'.$row,
        (string) $warga->nik,
        \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
        );
        $sheet->setCellValue('C'.$row, $warga->nama_lengkap);
        $sheet->setCellValue('D'.$row, $warga->jenis_kelamin);
        $sheet->setCellValue('E'.$row, $warga->tempat_lahir);
        $sheet->setCellValue('F'.$row, $warga->tanggal_lahir);
        $sheet->setCellValue('G'.$row, $warga->agama);
        $sheet->setCellValue('H'.$row, $warga->pendidikan);
        $sheet->setCellValue('I'.$row, $warga->jenis_pekerjaan);
        $sheet->setCellValue('J'.$row, $warga->status_perkawinan);
        $sheet->setCellValue('K'.$row, $warga->status_hubungan);
        $sheet->setCellValue('L'.$row, $warga->keluarga->rt->nomor_rt ?? '');
        $sheet->setCellValue('M'.$row, $warga->keluarga->rt->rw->nomor_rw ?? '');
        $sheet->setCellValue('N'.$row, $warga->keluarga->alamat ?? '');
        $sheet->setCellValue('O'.$row, $warga->keterangan);

        $row++;
    }

    
        // ====================
        // STYLE TABEL
        // ====================

        $lastRow = $row - 1;

        $sheet->getStyle('A1:O1')
            ->getFont()
            ->setBold(true);

        $sheet->getStyle("A1:O{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            );

        // Auto width
        foreach (range('A', 'O') as $column) {
            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }

        $filename = 'Data_Warga_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
}
}