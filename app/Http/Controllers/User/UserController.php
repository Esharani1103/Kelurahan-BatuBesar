<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aparatur;
use App\Models\VideoProfil;
use App\Models\PengumumanTicker;
use App\Models\Statistik;
use App\Models\SyaratDokumen;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function sharedData(): array
    {
        return [
            'ticker'   => PengumumanTicker::aktif()->get(),
            'aparatur' => Aparatur::aktif()->get(),
        ];
    }

    public function beranda()
    {
        return view('user.beranda', array_merge($this->sharedData(), [
            'video'         => VideoProfil::aktif()->first(),
            'statistik'     => Statistik::semuaSebagaiMap(),
            'infoKelurahan' => Statistik::infoKelurahan(),
            'kodepos'       => Statistik::kodeposList(),
            'syarat'        => SyaratDokumen::with('items')->aktif()->get(),

            'kegiatan' => Kegiatan::terbaru()->take(6)->get(),
        ]));
    }

    public function profil()
    {
        return view('user.profil', $this->sharedData());
    }

    public function selayangPandang()
    {
        return view('user.selayang', $this->sharedData());
    }

    public function visiMisi()
    {
        return view('user.visi', $this->sharedData());
    }

    public function strukturOrganisasi()
    {
        return view('user.struktur', $this->sharedData());
    }

    public function petaKelurahan()
    {
        return view('user.peta', array_merge($this->sharedData(), [
            'kodepos'       => Statistik::kodeposList(),
            'infoKelurahan' => Statistik::infoKelurahan(),
        ]));
    }

    public function dataWarga()
    {
        return view('user.data-warga', array_merge($this->sharedData(), [
            'statistik' => Statistik::semuaSebagaiMap(),
        ]));
    }

    public function kegiatan()
    {
        // TODO: 'kegiatan' => Kegiatan::published()->latest()->paginate(12),
         return view('user.kegiatan', array_merge($this->sharedData(), [
            'kegiatanList' => Kegiatan::terbaru()->paginate(9),
        ]));
    }

    public function laporanRt()
    {
        return view('user.laporan-rt', $this->sharedData());
    }

    // layanan = Saran & Aduan di frontend — nama kode tetap 'layanan'
    public function layanan()
    {
        return view('user.layanan', array_merge($this->sharedData(), [
            'syarat' => SyaratDokumen::with('items')->aktif()->get(),
        ]));
    }
}
