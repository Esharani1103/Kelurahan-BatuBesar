<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfilKonten;
 
class ProfilKontenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'slug'   => ProfilKonten::SELAYANG,
                'judul'  => 'Selayang Pandang',
                'konten' => 'Kelurahan Batu Besar merupakan salah satu Kampung Tua yang menyimpan kekayaan sejarah dan budaya Melayu di pesisir utara Pulau Batam, Kecamatan Nongsa, Kota Batam, Kepulauan Riau. Kampung ini pertama kali ditemukan oleh masyarakat Suku Melayu yang menjadikannya tempat persinggahan para nelayan dan pedagang yang melintas di perairan Nongsa.',
            ],
            [
                'slug'   => ProfilKonten::GAMBARAN,
                'judul'  => 'Gambaran Umum',
                'konten' => 'Kelurahan Batu Besar terletak di salah satu dari 4 kelurahan yang ada di Kecamatan Nongsa, Kota Batam. Kelurahan ini berbatasan langsung dengan perairan Selat Malaka di sebelah utara. Dengan luas wilayah sekitar 12 km², kelurahan ini terdiri dari 6 RW dan 24 RT yang tersebar di beberapa kampung bersejarah.',
            ],
            [
                'slug'   => ProfilKonten::VISI,
                'judul'  => 'Visi & Misi',
                'konten' => "<strong>Visi:</strong><br>Terwujudnya Kelurahan Batu Besar yang maju, mandiri, dan sejahtera berbasis nilai-nilai kearifan lokal.<br><br><strong>Misi:</strong><br>1. Meningkatkan pelayanan publik yang prima.<br>2. Mendorong pemberdayaan ekonomi masyarakat.<br>3. Melestarikan budaya dan kearifan lokal.",
            ],
            [
                'slug'   => ProfilKonten::STRUKTUR,
                'judul'  => 'Struktur Organisasi',
                'konten' => 'Struktur organisasi Kelurahan Batu Besar disusun sesuai dengan Peraturan Daerah Kota Batam, terdiri dari Lurah, Sekretaris Lurah, dan beberapa Kepala Seksi yang membidangi pemerintahan, pelayanan, dan pemberdayaan masyarakat.',
            ],
        ];
 
        foreach ($data as $item) {
            ProfilKonten::updateOrCreate(['slug' => $item['slug']], $item);
        }
 
        $this->command->info('✅ ProfilKontenSeeder selesai.');
    }
}