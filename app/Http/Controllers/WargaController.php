<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Keluarga;
use App\Models\Rt;
use App\Models\Rw;

class WargaController extends Controller
{
    public function index()
    {
        $warga = Warga::with('keluarga.rt.rw')
            ->orderBy('id','asc')
            ->paginate(50);

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
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
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

    $warga->update([
    'nik' => $request->nik,
    'nama_lengkap' => $request->nama_lengkap,
    'jenis_kelamin' => $request->jenis_kelamin,
    'tempat_lahir' => $request->tempat_lahir,
    'tanggal_lahir' => $request->tanggal_lahir,
    'agama' => $request->agama,
    'status_perkawinan' => $request->status_perkawinan,
    'pendidikan' => $request->pendidikan,
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
}