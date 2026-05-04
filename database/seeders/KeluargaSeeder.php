<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keluarga;
use App\Models\Rt;
use App\Models\Rw;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $rw = Rw::first();
    $rt = Rt::first();

    Keluarga::create([
        'no_kk' => '2171041512140002',
        'nama_kepala_keluarga' => 'Rendy',
        'alamat' => 'Kampung Tengah',
        'id_rt' => $rt->id_rt
    ]);
    }
}
