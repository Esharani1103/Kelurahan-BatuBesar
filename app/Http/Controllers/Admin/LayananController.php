<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::latest()->paginate(10);

        return view(
            'admin.layanan.index',
            compact('layanan')
        );
    }

    public function diterima($id)
    {
        $data = Layanan::findOrFail($id);

        $data->status = 'Diterima';

        $data->save();

        return back()->with(
            'success',
            'Status berhasil diperbarui'
        );
    }
}