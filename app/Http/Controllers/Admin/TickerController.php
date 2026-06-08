<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengumumanTicker;
use Illuminate\Http\Request;

class TickerController extends Controller
{
    public function index()
    {
        $tickers = PengumumanTicker::orderBy('urutan')->get();
        return view('admin.ticker.index', compact('tickers'));
    }

    public function store(Request $request)
    {
        $request->validate(['teks'=>'required|string|max:255','ikon'=>'nullable|string|max:10']);
        PengumumanTicker::create([
            'teks'   => $request->teks,
            'ikon'   => $request->input('ikon', '📢'),
            'urutan' => $request->input('urutan', PengumumanTicker::max('urutan') + 1),
            'aktif'  => $request->boolean('aktif', true),
        ]);
        return redirect()->route('admin.ticker.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, PengumumanTicker $ticker)
    {
        $request->validate(['teks'=>'required|string|max:255','ikon'=>'nullable|string|max:10']);
        $ticker->update([
            'teks'   => $request->teks,
            'ikon'   => $request->input('ikon', $ticker->ikon),
            'urutan' => $request->input('urutan', $ticker->urutan),
            'aktif'  => $request->boolean('aktif', $ticker->aktif),
        ]);
        return redirect()->route('admin.ticker.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(PengumumanTicker $ticker)
    {
        $ticker->delete();
        return redirect()->route('admin.ticker.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function toggle(PengumumanTicker $ticker)
    {
        $ticker->update(['aktif' => !$ticker->aktif]);
        return response()->json(['success'=>true,'aktif'=>$ticker->aktif]);
    }

    public function urutan(Request $request)
    {
        $request->validate(['urutan' => 'required|array']);
        foreach ($request->urutan as $index => $id) {
            PengumumanTicker::where('id', $id)->update(['urutan' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
}