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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();

            // Skripsi yang dievaluasi
            $table->foreignId('skripsi_id')->constrained('skripsi')->cascadeOnDelete();

            // Dosen penguji yang memberi evaluasi
            $table->foreignId('lecturer_id')->constrained('lecturers')->cascadeOnDelete();

            // Nilai angka 0-100
            $table->decimal('score', 5, 2);

            // Huruf hasil konversi otomatis dari score (A/B/C/D/E), diisi lewat model event
            $table->string('grade', 2)->nullable();

            // Catatan/feedback dari dosen penguji
            $table->text('notes')->nullable();

            // Tanggal evaluasi dilakukan (misal tanggal sidang)
            $table->date('evaluation_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};