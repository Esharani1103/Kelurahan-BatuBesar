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
         Schema::create('layanans', function (Blueprint $table) {

            $table->id();

            $table->string('nama')->nullable();

            $table->boolean('anonim')
                  ->default(true);

            $table->enum('kategori', [
                'Saran',
                'Masukan',
                'Aduan'
            ]);

            $table->text('pesan');

            $table->string('foto')
                  ->nullable();

            $table->enum('status', [
                'Terkirim',
                'Diterima'
            ])->default('Terkirim');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
