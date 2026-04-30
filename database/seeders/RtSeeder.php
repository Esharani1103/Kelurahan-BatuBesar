<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rws = DB::table('rws')->get();

        foreach ($rws as $rw) {

            for ($rt = 1; $rt <= 10; $rt++) { // contoh 10 RT per RW

                DB::table('rts')->insert([
                    'id_rw' => $rw->id_rw,
                    'nomor_rt' => $rt,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            }
        }
    }
}
