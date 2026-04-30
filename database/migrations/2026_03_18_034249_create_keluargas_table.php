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
        Schema::create('keluargas', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_rt');

    $table->string('no_kk')->unique();
    $table->string('nama_kepala_keluarga');
    $table->text('alamat')->nullable();
    $table->timestamps();

    $table->foreign('id_rt')->references('id_rt')->on('rts')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluargas');
    }
};
