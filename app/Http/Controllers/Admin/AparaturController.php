<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aparatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AparaturController extends Controller
{
    public function index()
    {
        $aparatur = Aparatur::orderBy('urutan')->get();
        return view('admin.aparatur.index', compact('aparatur'));
    }

    public function create()
    {
        return view('admin.aparatur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'nip'     => 'nullable|string|max:50',
            'urutan'  => 'nullable|integer|min:0',
            'aktif'   => 'nullable|boolean',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('aparatur', 'public');
        }
        $validated['aktif']  = $request->boolean('aktif', true);
        $validated['urutan'] = $request->input('urutan', Aparatur::max('urutan') + 1);
        Aparatur::create($validated);

        return redirect()->route('admin.aparatur.index')
                         ->with('success', 'Aparatur berhasil ditambahkan.');
    }

    public function edit(Aparatur $aparatur)
    {
        return view('admin.aparatur.edit', compact('aparatur'));
    }

    public function update(Request $request, Aparatur $aparatur)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'nip'     => 'nullable|string|max:50',
            'urutan'  => 'nullable|integer|min:0',
            'aktif'   => 'nullable|boolean',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($aparatur->foto) Storage::disk('public')->delete($aparatur->foto);
            $validated['foto'] = $request->file('foto')->store('aparatur', 'public');
        }
        $validated['aktif'] = $request->boolean('aktif', true);
        $aparatur->update($validated);

        return redirect()->route('admin.aparatur.index')
                         ->with('success', 'Aparatur berhasil diperbarui.');
    }

    public function destroy(Aparatur $aparatur)
    {
        if ($aparatur->foto) Storage::disk('public')->delete($aparatur->foto);
        $aparatur->delete();
        return redirect()->route('admin.aparatur.index')
                         ->with('success', 'Aparatur berhasil dihapus.');
    }

    public function toggle(Aparatur $aparatur)
    {
        $aparatur->update(['aktif' => !$aparatur->aktif]);
        return response()->json(['success'=>true,'aktif'=>$aparatur->aktif]);
    }

    public function urutan(Request $request)
    {
        $request->validate(['urutan' => 'required|array']);
        foreach ($request->urutan as $index => $id) {
            Aparatur::where('id', $id)->update(['urutan' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
}
