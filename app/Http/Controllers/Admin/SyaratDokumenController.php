<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SyaratDokumen;
use App\Models\SyaratDokumenItem;
use Illuminate\Http\Request;

class SyaratDokumenController extends Controller
{
    public function index()
    {
        $syarat = SyaratDokumen::with('items')->orderBy('urutan')->get();
        return view('admin.syarat.index', compact('syarat'));
    }

    public function create()
    {
        return view('admin.syarat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'=>'required|string|max:100','ikon'=>'nullable|string|max:10',
            'aktif'=>'nullable|boolean','items'=>'required|array|min:1',
            'items.*'=>'required|string|max:200',
        ]);
        $syarat = SyaratDokumen::create([
            'judul'=>$request->judul,'ikon'=>$request->input('ikon','📄'),
            'urutan'=>$request->input('urutan', SyaratDokumen::max('urutan') + 1),
            'aktif'=>$request->boolean('aktif', true),
        ]);
        $this->simpanItems($syarat, $request->items);
        return redirect()->route('admin.syarat.index')
                         ->with('success', "Persyaratan \"{$syarat->judul}\" berhasil ditambahkan.");
    }

    public function edit(SyaratDokumen $syarat)
    {
        $syarat->load('items');
        return view('admin.syarat.edit', compact('syarat'));
    }

    public function update(Request $request, SyaratDokumen $syarat)
    {
        $request->validate([
            'judul'=>'required|string|max:100','ikon'=>'nullable|string|max:10',
            'aktif'=>'nullable|boolean','items'=>'required|array|min:1',
            'items.*'=>'required|string|max:200',
        ]);
        $syarat->update([
            'judul'=>$request->judul,'ikon'=>$request->input('ikon',$syarat->ikon),
            'urutan'=>$request->input('urutan',$syarat->urutan),
            'aktif'=>$request->boolean('aktif',$syarat->aktif),
        ]);
        $syarat->items()->delete();
        $this->simpanItems($syarat, $request->items);
        return redirect()->route('admin.syarat.index')
                         ->with('success', "Persyaratan \"{$syarat->judul}\" berhasil diperbarui.");
    }

    public function destroy(SyaratDokumen $syarat)
    {
        $judul = $syarat->judul;
        $syarat->delete();
        return redirect()->route('admin.syarat.index')
                         ->with('success', "Persyaratan \"{$judul}\" berhasil dihapus.");
    }

    public function toggle(SyaratDokumen $syarat)
    {
        $syarat->update(['aktif' => !$syarat->aktif]);
        return response()->json(['success'=>true,'aktif'=>$syarat->aktif]);
    }

    public function urutan(Request $request)
    {
        $request->validate(['urutan' => 'required|array']);
        foreach ($request->urutan as $index => $id) {
            SyaratDokumen::where('id', $id)->update(['urutan' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    private function simpanItems(SyaratDokumen $syarat, array $items): void
    {
        $data = [];
        foreach ($items as $index => $teks) {
            $teks = trim($teks);
            if ($teks === '') continue;
            $data[] = [
                'syarat_dokumen_id' => $syarat->id,
                'teks'   => $teks,
                'urutan' => $index + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if (!empty($data)) SyaratDokumenItem::insert($data);
    }
}
