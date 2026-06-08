<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\Aparatur;
use App\Models\PengumumanTicker;
use App\Models\Statistik;
use App\Models\SyaratDokumen;
use App\Models\SyaratDokumenItem;

class BerandaSeeder extends Seeder
{
    public function run(): void
    {
        // ── Aparatur ─────────────────────────────────────────
        Aparatur::truncate();
        $aparaturData = [
            ['nama'=>'FIKRI AUNILLAH, S.STP', 'jabatan'=>'LURAH',              'nip'=>'NIP 1994081120169091002','urutan'=>1],
            ['nama'=>'SUNARIYOTO, SE',   'jabatan'=>'SEKRETARIS KELURAHAN',   'nip'=>'NIP 197509092007011024','urutan'=>2],
            ['nama'=>'RIKA PURNAMA, A.Md.Keb',         'jabatan'=>'KASI PEM DAN PELAYANAN UMUM', 'nip'=>'NIP 197208081992012001','urutan'=>3],
            ['nama'=>'FEMMY HALID, STP',  'jabatan'=>'KASI PPM DAN KESRA',    'nip'=>'NIP 197512092005012012','urutan'=>4],
            ['nama'=>'ABU BAKAR, SH',        'jabatan'=>'KASI TRANTIB', 'nip'=>'NIP 198300292010011009','urutan'=>5],
            ['nama'=>'YUSMIDAR, A.Md',        'jabatan'=>'STAF PEM DAN PELAYANAN UMUM','nip'=>'NIP 198002162002122010','urutan'=>6],
            ['nama'=>'NURDIN',        'jabatan'=>'STAF TRANTIB','nip'=>'NIP 197602022009011009','urutan'=>7],
            ['nama'=>'ASMARIYANTI',        'jabatan'=>'STAF PEM DAN PELAYANAN UMUM','nip'=>'NIP 198002162002122010','urutan'=>8],
            ['nama'=>'YUSMIDAR, A.Md',        'jabatan'=>'STAF PEM DAN PELAYANAN UMUM','nip'=>'NIP 198002162002122010','urutan'=>9],
        ];
        foreach ($aparaturData as $a) {
            Aparatur::create(array_merge($a, ['aktif' => true]));
        }

        // ── Ticker ───────────────────────────────────────────
        PengumumanTicker::truncate();
        $tickers = [
            ['teks'=>'Selamat datang di website resmi Kelurahan Batu Besar',                       'ikon'=>'📢','urutan'=>1],
            ['teks'=>'Pelayanan setiap hari Senin–Jumat pukul 08.00–16.00',            'ikon'=>'📋','urutan'=>2],
            ['teks'=>'Posyandu bulanan dilaksanakan setiap tanggal 15',                            'ikon'=>'🏥','urutan'=>3],
            ['teks'=>'Program gotong royong lingkungan dilaksanakan setiap Minggu pertama',        'ikon'=>'🌿','urutan'=>4],
        ];
        foreach ($tickers as $t) {
            PengumumanTicker::create(array_merge($t, ['aktif' => true]));
        }

        // ── Statistik + Info Kelurahan + Kode Pos ────────────
        $statistikData = [
            // Statistik beranda
            ['key'=>'penduduk',       'label'=>'Total Penduduk',          'nilai'=>'4820',    'ikon'=>'👥'],
            ['key'=>'kk',             'label'=>'Kepala Keluarga',         'nilai'=>'1246',    'ikon'=>'🏠'],
            ['key'=>'rw',             'label'=>'Rukun Warga',             'nilai'=>'6',       'ikon'=>'🗺️'],
            ['key'=>'rt',             'label'=>'Rukun Tetangga',          'nilai'=>'24',      'ikon'=>'🏘️'],
            ['key'=>'luas_wilayah',   'label'=>'Luas Wilayah',            'nilai'=>'~12 km²', 'ikon'=>'🏙️'],
            ['key'=>'surat_bulan_ini','label'=>'Surat Bulan Ini',         'nilai'=>'128',     'ikon'=>'📋'],
            // Info kelurahan
            ['key'=>'kecamatan',      'label'=>'Kecamatan',               'nilai'=>'Nongsa',  'ikon'=>null],
            ['key'=>'kota',           'label'=>'Kota',                    'nilai'=>'Batam',   'ikon'=>null],
            ['key'=>'provinsi',       'label'=>'Provinsi',                'nilai'=>'Kepri',   'ikon'=>null],
            ['key'=>'kode_pos',       'label'=>'Kode Pos',                'nilai'=>'29465',   'ikon'=>null],
            ['key'=>'luas_sidebar',   'label'=>'Luas Wilayah',            'nilai'=>'~12 km²', 'ikon'=>null],
            ['key'=>'jml_rt',         'label'=>'Jumlah RT',               'nilai'=>'24 RT',   'ikon'=>null],
            ['key'=>'jml_rw',         'label'=>'Jumlah RW',               'nilai'=>'6 RW',    'ikon'=>null],
            // Kode pos wilayah (JSON)
            ['key'=>'kodepos_list',   'label'=>'Daftar Kode Pos Wilayah', 'ikon'=>'📮',
             'nilai'=>json_encode([
                ['wilayah'=>'Batu Besar','kode'=>'29466'],
                ['wilayah'=>'Kabil',    'kode'=>'29467'],
                ['wilayah'=>'Ngenang','kode'=>'2968'],
                ['wilayah'=>'Sambau',  'kode'=>'29469'],
             ], JSON_UNESCAPED_UNICODE)
            ],
        ];
        foreach ($statistikData as $s) {
            Statistik::updateOrCreate(['key' => $s['key']], $s);
        }

        // ── Syarat Dokumen ───────────────────────────────────
        Schema::disableForeignKeyConstraints();

        SyaratDokumenItem::truncate();
        SyaratDokumen::truncate();
        
        Schema::enableForeignKeyConstraints();
        $syaratData = [
            ['ikon'=>'🪪','judul'=>'KTP & Kartu Keluarga','urutan'=>1,'items'=>[
                'Fotokopi KTP pemohon','Fotokopi Kartu Keluarga',
                'KTP asli untuk verifikasi','Pas foto 3×4 (2 lembar)',
            ]],
            ['ikon'=>'🏠','judul'=>'Surat Domisili','urutan'=>2,'items'=>[
                'KTP asli & fotokopi','Surat pengantar RT/RW',
                'Kartu Keluarga asli','Materai Rp 10.000',
            ]],
            ['ikon'=>'📋','judul'=>'Pengantar SKCK','urutan'=>3,'items'=>[
                'Fotokopi KTP','Pas foto 4×6 background merah',
                'Surat pengantar RT/RW','Fotokopi KK',
            ]],
            ['ikon'=>'📑','judul'=>'Legalisir Dokumen','urutan'=>4,'items'=>[
                'Dokumen asli yang dilegalisir','Fotokopi dokumen (3 lembar)',
                'KTP pemohon','Materai bila diperlukan',
            ]],
            ['ikon'=>'👶','judul'=>'Akta Kelahiran','urutan'=>5,'items'=>[
                'Surat keterangan lahir RS/bidan','KTP kedua orang tua',
                'Buku nikah orang tua','Kartu Keluarga asli',
            ]],
            ['ikon'=>'📬','judul'=>'Surat Keterangan','urutan'=>6,'items'=>[
                'KTP asli pemohon','Surat pengantar RT/RW',
                'Fotokopi KK','Jelaskan keperluan surat',
            ]],
        ];
        foreach ($syaratData as $s) {
            $syarat = SyaratDokumen::create([
                'judul'=>$s['judul'],'ikon'=>$s['ikon'],
                'urutan'=>$s['urutan'],'aktif'=>true,
            ]);
            foreach ($s['items'] as $urutan => $teks) {
                SyaratDokumenItem::create([
                    'syarat_dokumen_id'=>$syarat->id,
                    'teks'=>$teks,'urutan'=>$urutan + 1,
                ]);
            }
        }

        $this->command->info('BerandaSeeder selesai.');
    }
}
