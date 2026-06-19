<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilKonten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilKontenController extends Controller
{
    // Slug yang valid — dipakai untuk validasi parameter route
    private array $slugValid = ['selayang', 'gambaran', 'visi', 'struktur'];

    public function index()
    {
        $profil = ProfilKonten::semuaSebagaiMap();
        return view('admin.profil.index', compact('profil'));
    }

    // POST /admin/profil/{slug} — simpan satu tab (judul, konten, file)
    public function update(Request $request, string $slug)
    {
        if (!in_array($slug, $this->slugValid)) {
            abort(404);
        }

        $request->validate([
            'judul'   => 'required|string|max:150',
            'konten'  => 'nullable|string',
            'file'    => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120', // maks 5MB
        ], [
            'file.mimes' => 'File harus berupa PDF, JPG, PNG, atau WEBP.',
            'file.max'   => 'Ukuran file maksimal 5MB.',
        ]);

        $profilKonten = ProfilKonten::firstOrNew(['slug' => $slug]);

        $profilKonten->judul  = $request->judul;
        $profilKonten->konten = $request->konten;

        // Upload file baru jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($profilKonten->file) {
                Storage::disk('public')->delete($profilKonten->file);
            }
            $file = $request->file('file');
            $profilKonten->file           = $file->store('profil', 'public');
            $profilKonten->file_nama_asli = $file->getClientOriginalName();
        }

        $profilKonten->save();

        return redirect()->route('admin.profil.index', ['tab' => $slug])
                         ->with('success', "Konten \"{$profilKonten->judul}\" berhasil disimpan.");
    }

    // DELETE /admin/profil/{slug}/file — hapus file lampiran saja (konten teks tetap)
    public function hapusFile(string $slug)
    {
        if (!in_array($slug, $this->slugValid)) {
            abort(404);
        }

        $profilKonten = ProfilKonten::where('slug', $slug)->first();

        if ($profilKonten && $profilKonten->file) {
            Storage::disk('public')->delete($profilKonten->file);
            $profilKonten->file           = null;
            $profilKonten->file_nama_asli = null;
            $profilKonten->save();
        }

        return redirect()->route('admin.profil.index', ['tab' => $slug])
                         ->with('success', 'File berhasil dihapus.');
    }
}