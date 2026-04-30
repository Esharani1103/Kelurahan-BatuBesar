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
        Schema::create('wargas_old', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_penduduk')->nullable();
            $table->integer('jumlah_kk')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('status_hubungan')->nullable();
            $table->string('nama_kepala_keluarga')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas_old');
    }
};
