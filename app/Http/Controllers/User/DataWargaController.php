<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataWargaController extends Controller
{
    public function dataWarga()
    {
        return view('user.data-warga');
    }

    public function jumlah()
    {
        $total = Warga::count();
        $laki = Warga::where('jenis_kelamin','Laki-laki')->count();
        $perempuan = Warga::where('jenis_kelamin','Perempuan')->count();

    return view('user.data-warga.jumlah', compact('total','laki','perempuan'));
    }

    public function umur()
    {
        return view('user.data-warga.umur');
    }

    public function agama()
    {
        return view('user.data-warga.agama');
    }

    public function pendidikan()
    {
        return view('user.data-warga.pendidikan');
    }

    public function pekerjaan()
    {
        return view('user.data-warga.pekerjaan');
    }
}
