<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_konten', function (Blueprint $table) {
             $table->id();
            // slug unik: 'selayang', 'gambaran', 'visi', 'struktur'
            $table->string('slug', 30)->unique();
            $table->string('judul', 150);
            // Konten HTML/teks panjang yang diketik di admin
            $table->longText('konten')->nullable();
            // File lampiran opsional (PDF atau gambar)
            $table->string('file')->nullable();
            $table->string('file_nama_asli', 255)->nullable(); // nama file untuk download
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_konten');
    }
};
