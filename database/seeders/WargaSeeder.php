<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Warga;
use App\Models\Keluarga;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

{
    $keluarga = Keluarga::first();

    Warga::create([
        'keluarga_id' => $keluarga->id,
        'nik' => '2171041000000001',
        'nama_lengkap' => 'Rendy',
        'jenis_kelamin' => 'LAKI-LAKI',
        'tempat_lahir' => 'Kendari',
        'tanggal_lahir' => '1980-03-10',
        'agama' => 'ISLAM',
        'pendidikan' => 'SLTA/Sederajat',
        'jenis_pekerjaan' => 'Wiraswasta',
        'status_perkawinan' => 'KAWIN',
        'status_hubungan' => 'Kepala Keluarga',
        'kewarganegaraan' => 'WNI'
    ]);
    }
}
