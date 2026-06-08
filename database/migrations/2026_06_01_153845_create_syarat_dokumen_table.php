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
        Schema::create('syarat_dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 100);
            $table->string('ikon', 10)->default('📄');
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('syarat_dokumen_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syarat_dokumen_id')
                ->constrained('syarat_dokumen')
                ->cascadeOnDelete();
            $table->string('teks', 200);
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_dokumen');
    }
};
