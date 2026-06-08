<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistik;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $statistik = Statistik::all()->keyBy('key');
        return view('admin.statistik.index', compact('statistik'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'data'=>'required|array','data.*.key'=>'required|string|max:50',
            'data.*.label'=>'required|string|max:100','data.*.nilai'=>'required|string|max:50',
        ]);
        foreach ($request->data as $item) {
            Statistik::updateOrCreate(
                ['key'=>$item['key']],
                ['label'=>$item['label'],'nilai'=>$item['nilai'],'ikon'=>$item['ikon']??null]
            );
        }
        return redirect()->route('admin.statistik.index')->with('success', 'Statistik berhasil disimpan.');
    }

    public function updateSatu(Request $request, string $key)
    {
        $request->validate(['nilai' => 'required|string|max:50']);
        $stat = Statistik::where('key', $key)->firstOrFail();
        $stat->update(['nilai' => $request->nilai]);
        return response()->json(['success'=>true,'nilai'=>$stat->nilai]);
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'info'=>'required|array','info.*.key'=>'required|string|max:50',
            'info.*.label'=>'required|string|max:100','info.*.nilai'=>'required|string|max:100',
        ]);
        foreach ($request->info as $item) {
            Statistik::updateOrCreate(
                ['key'=>$item['key']],
                ['label'=>$item['label'],'nilai'=>$item['nilai'],'ikon'=>null]
            );
        }
        return redirect()->route('admin.statistik.index', ['tab'=>'info'])
                         ->with('success', 'Info kelurahan berhasil disimpan.');
    }

    public function updateKodepos(Request $request)
    {
        $request->validate([
            'kodepos'=>'required|array|min:1',
            'kodepos.*.wilayah'=>'required|string|max:100',
            'kodepos.*.kode'=>'required|string|max:10',
        ]);
        $kodepos = collect($request->kodepos)
            ->filter(fn($i) => !empty(trim($i['wilayah'])) && !empty(trim($i['kode'])))
            ->values()->toArray();

        Statistik::updateOrCreate(
            ['key'   => Statistik::KEY_KODEPOS_LIST],
            ['label' => 'Daftar Kode Pos Wilayah',
             'nilai' => json_encode($kodepos, JSON_UNESCAPED_UNICODE), 'ikon'=>'📮']
        );
        return redirect()->route('admin.statistik.index', ['tab'=>'kodepos'])
                         ->with('success', 'Kode pos berhasil disimpan.');
    }
}