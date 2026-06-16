<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilKelurahanController extends Controller
{
    public function index()
    {
        $profil = ProfilKelurahan::firstOrCreate([], [
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

        return view('admin.profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $profil = ProfilKelurahan::firstOrCreate([]);

        $data = $request->validate([
            'gambaran_judul' => ['nullable', 'string', 'max:255'],
            'gambaran_isi' => ['nullable', 'string'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'array'],
            'misi.*' => ['nullable', 'string'],
            'selayang_judul' => ['nullable', 'string', 'max:255'],
            'selayang_isi' => ['nullable', 'string'],
            'struktur_nama' => ['nullable', 'string', 'max:255'],
            'struktur_jabatan' => ['nullable', 'string', 'max:255'],
            'struktur_nip' => ['nullable', 'string', 'max:255'],
            'struktur_foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['misi'] = collect($request->input('misi', []))
            ->filter(fn ($item) => filled($item))
            ->values()
            ->all();

        if ($request->hasFile('struktur_foto')) {
            if ($profil->struktur_foto) {
                Storage::disk('public')->delete($profil->struktur_foto);
            }

            $data['struktur_foto'] = $request->file('struktur_foto')->store('profil', 'public');
        }

        $profil->update($data);

        return back()->with('success', 'Profil kelurahan berhasil disimpan.');
    }
}