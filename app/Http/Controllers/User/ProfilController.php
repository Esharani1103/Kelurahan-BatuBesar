<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProfilKelurahan;

class ProfilController extends Controller
{
    private function profilData()
    {
        return ProfilKelurahan::firstOrCreate([], [
            'gambaran_judul' => 'Mengenal Kelurahan Batu Besar',
            'gambaran_isi' => '',
            'visi' => '',
            'misi' => [],
            'selayang_judul' => 'Selayang Pandang',
            'selayang_isi' => '',
            'struktur_nama' => '',
            'struktur_jabatan' => '',
            'struktur_nip' => '',
            'struktur_foto' => null,
        ]);
    }

    public function profil()
    {
        return view('user.profil', [
            'profil' => $this->profilData(),
        ]);
    }

    public function selayang()
    {
        return view('user.profil.selayang', [
            'profil' => $this->profilData(),
        ]);
    }

    public function visi()
    {
        return view('user.profil.visi', [
            'profil' => $this->profilData(),
        ]);
    }

    public function struktur()
    {
        return view('user.profil.struktur', [
            'profil' => $this->profilData(),
        ]);
    }

    public function peta()
    {
        return view('user.profil.peta');
    }
    }