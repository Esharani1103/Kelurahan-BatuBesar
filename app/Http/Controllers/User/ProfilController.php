<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function profil()
    {
    return view('user.profil');
    }
     public function selayang()
    {
        return view('user.profil.selayang');
    }

    public function visi()
    {
        return view('user.profil.visi');
    }

    public function struktur()
    {
        return view('user.profil.struktur');
    }

    public function peta()
    {
        return view('user.profil.peta');
    }
}
