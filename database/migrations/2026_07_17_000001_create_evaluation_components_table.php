<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel ini menyimpan MASTER unsur penilaian.
     * Karena rubrik Dosen Pembimbing dan Dosen Penguji berbeda
     * (Pembimbing punya unsur "Pembimbingan/checklist berkas" & rentang nilai
     * yang berbeda pada beberapa unsur), setiap baris punya kolom `role`
     * untuk membedakan komponen tersebut dipakai pada rubrik yang mana.
     */
    public function up(): void
    {
        Schema::create('evaluation_components', function (Blueprint $table) {
            $table->id();

            // 'pembimbing' atau 'penguji'
            $table->enum('role', ['pembimbing', 'penguji']);

            // Nama unsur penilaian, contoh: "Abstrak Proposal"
            $table->string('name');

            // Rentang nilai unsur, contoh 0 - 20
            $table->decimal('min_score', 5, 2)->default(0);
            $table->decimal('max_score', 5, 2);

            // Urutan tampil di form/tabel
            $table->unsignedSmallInteger('order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_components');
    }
};