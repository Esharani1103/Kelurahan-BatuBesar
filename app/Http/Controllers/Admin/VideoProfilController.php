<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoProfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoProfilController extends Controller
{
    public function index()
    {
        $videos = VideoProfil::latest()->get();
        return view('admin.video.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:150',
            'url_youtube' => 'nullable|url|max:255',
            'file_video'  => 'nullable|file|mimes:mp4,webm,ogg|max:102400',
            'aktif'       => 'nullable|boolean',
        ]);

        if ($request->filled('url_youtube') && $request->hasFile('file_video')) {
            return back()->withErrors(['url_youtube' => 'Pilih salah satu: URL YouTube atau file video.'])
                         ->withInput();
        }

        $data = ['judul'=>$request->judul, 'aktif'=>$request->boolean('aktif', true)];

        if ($request->filled('url_youtube'))     $data['url_youtube'] = $request->url_youtube;
        if ($request->hasFile('file_video'))     $data['file_video']  = $request->file('file_video')->store('video','public');

        if ($data['aktif']) VideoProfil::where('aktif', true)->update(['aktif' => false]);
        VideoProfil::create($data);

        return redirect()->route('admin.video.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function destroy(VideoProfil $video)
    {
        if ($video->file_video) Storage::disk('public')->delete($video->file_video);
        $video->delete();
        return redirect()->route('admin.video.index')->with('success', 'Video berhasil dihapus.');
    }

    public function aktifkan(VideoProfil $video)
    {
        VideoProfil::where('aktif', true)->update(['aktif' => false]);
        $video->update(['aktif' => true]);
        return response()->json(['success'=>true,'message'=>"Video \"{$video->judul}\" sekarang aktif."]);
    }
}
