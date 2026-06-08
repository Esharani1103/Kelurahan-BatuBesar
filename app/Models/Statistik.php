<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statistik extends Model
{
    use HasFactory;

    protected $table    = 'statistik';
    protected $fillable = ['key','label','nilai','ikon'];

    // ── Konstanta key ──────────────────────────────────────────────
    // Statistik beranda
    const KEY_PENDUDUK       = 'penduduk';
    const KEY_KK             = 'kk';
    const KEY_RW             = 'rw';
    const KEY_RT             = 'rt';
    const KEY_LUAS           = 'luas_wilayah';
    const KEY_SURAT          = 'surat_bulan_ini';

    // Info kelurahan (sidebar)
    const KEY_KECAMATAN      = 'kecamatan';
    const KEY_KOTA           = 'kota';
    const KEY_PROVINSI       = 'provinsi';
    const KEY_KODE_POS       = 'kode_pos';
    const KEY_LUAS_SIDEBAR   = 'luas_sidebar';
    const KEY_JML_RT         = 'jml_rt';
    const KEY_JML_RW         = 'jml_rw';

    // Kode pos wilayah (JSON)
    const KEY_KODEPOS_LIST   = 'kodepos_list';

    // ── Helpers ────────────────────────────────────────────────────
    public static function semuaSebagaiMap()
    {
        return static::all()->keyBy('key');
    }

    public static function getValue(string $key, $default = '-'): string
    {
        $row = static::where('key', $key)->first();
        return $row ? $row->nilai : $default;
    }

    public static function infoKelurahan(): array
    {
        $map = static::whereIn('key', [
            self::KEY_KECAMATAN, self::KEY_KOTA, self::KEY_PROVINSI,
            self::KEY_KODE_POS, self::KEY_LUAS_SIDEBAR,
            self::KEY_JML_RT, self::KEY_JML_RW,
        ])->get()->keyBy('key');

        return [
            'Kecamatan'    => $map[self::KEY_KECAMATAN]->nilai    ?? 'Nongsa',
            'Kota'         => $map[self::KEY_KOTA]->nilai         ?? 'Batam',
            'Provinsi'     => $map[self::KEY_PROVINSI]->nilai     ?? 'Kepri',
            'Kode Pos'     => $map[self::KEY_KODE_POS]->nilai     ?? '29465',
            'Luas Wilayah' => $map[self::KEY_LUAS_SIDEBAR]->nilai ?? '~12 km²',
            'Jumlah RT'    => $map[self::KEY_JML_RT]->nilai       ?? '24 RT',
            'Jumlah RW'    => $map[self::KEY_JML_RW]->nilai       ?? '6 RW',
        ];
    }

    public static function kodeposList(): array
    {
        $row = static::where('key', self::KEY_KODEPOS_LIST)->first();

        if ($row && !empty($row->nilai)) {
            $decoded = json_decode($row->nilai, true);
            if (is_array($decoded)) return $decoded;
        }

        // Fallback jika belum ada di DB
        return [
            ['wilayah' => 'Batu Besar', 'kode' => '29465'],
            ['wilayah' => 'Nongsa',     'kode' => '29466'],
            ['wilayah' => 'Sambau',     'kode' => '29467'],
            ['wilayah' => 'Batu Ampar', 'kode' => '29452'],
            ['wilayah' => 'Sei Ladi',   'kode' => '29468'],
            ['wilayah' => 'Kabil',      'kode' => '29469'],
        ];
    }
}
