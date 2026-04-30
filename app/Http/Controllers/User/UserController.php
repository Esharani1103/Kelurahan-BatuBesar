<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function beranda()
    {
        return view('user.beranda');
    }

    public function profil()
    {
        return view('user.profil');
    }

    public function selayangPandang()
    {
        return view('user.selayang');
    }

    public function visiMisi()
    {
        return view('user.visi');
    }

    public function strukturOrganisasi()
    {
        return view('user.struktur');
    }

    public function petaKelurahan()
    {
        return view('user.peta');
    }

    public function dataWarga()
    {
        return view('user.data-warga');
    }

    public function kegiatan()
    {
        return view('user.kegiatan');
    }

    public function laporanRt()
    {
        return view('user.laporan-rt');
    }

    public function layanan()
    {
        return view('user.layanan');
    }
}
