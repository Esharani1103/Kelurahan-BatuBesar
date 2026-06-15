<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::orderBy('urutan')->orderByDesc('tanggal')->get();
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal'   => 'required|date',
            'urutan'    => 'nullable|integer|min:0',
            'aktif'     => 'nullable|boolean',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        $validated['aktif']  = $request->boolean('aktif', true);
        $validated['urutan'] = $request->input('urutan', Kegiatan::max('urutan') + 1);

        Kegiatan::create($validated);

        return redirect()->route('admin.kegiatan.index')
                         ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal'   => 'required|date',
            'urutan'    => 'nullable|integer|min:0',
            'aktif'     => 'nullable|boolean',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($kegiatan->gambar) {
                Storage::disk('public')->delete($kegiatan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        $validated['aktif'] = $request->boolean('aktif', true);

        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')
                         ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->gambar) {
            Storage::disk('public')->delete($kegiatan->gambar);
        }
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
                         ->with('success', 'Kegiatan berhasil dihapus.');
    }

    // PATCH /admin/kegiatan/{id}/toggle
    public function toggle(Kegiatan $kegiatan)
    {
        $kegiatan->update(['aktif' => !$kegiatan->aktif]);

        return response()->json([
            'success' => true,
            'aktif'   => $kegiatan->aktif,
        ]);
    }

    // POST /admin/kegiatan/urutan — simpan urutan drag-and-drop
    public function urutan(Request $request)
    {
        $request->validate(['urutan' => 'required|array']);

        foreach ($request->urutan as $index => $id) {
            Kegiatan::where('id', $id)->update(['urutan' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}