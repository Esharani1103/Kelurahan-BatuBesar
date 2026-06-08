<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        return view('user.layanan');
    }

    public function store(Request $request)
    {
        $request->validate([

            'pesan' => 'required',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {

            $foto = $request->file('foto')
                            ->store('layanan', 'public');
        }

        Layanan::create([

            'nama' => $request->anonim
                        ? null
                        : $request->nama,

            'anonim' => $request->anonim ? true : false,

            'kategori' => $request->kategori,

            'pesan' => $request->pesan,

            'foto' => $foto,
        ]);

        return back()->with(
            'success',
            'Masukan berhasil dikirim'
        );
    }
}

