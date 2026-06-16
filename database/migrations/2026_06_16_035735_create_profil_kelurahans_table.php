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
    Schema::create('profil_kelurahans', function (Blueprint $table) {
        $table->id();

        $table->string('gambaran_judul')->nullable();
        $table->longText('gambaran_isi')->nullable();

        $table->longText('visi')->nullable();
        $table->json('misi')->nullable();

        $table->string('selayang_judul')->nullable();
        $table->longText('selayang_isi')->nullable();

        $table->string('struktur_nama')->nullable();
        $table->string('struktur_jabatan')->nullable();
        $table->string('struktur_nip')->nullable();
        $table->string('struktur_foto')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_kelurahans');
    }
};
