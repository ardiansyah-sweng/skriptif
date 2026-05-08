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
    Schema::create('skripsi', function (Blueprint $table) {
        $table->id();

        $table->foreignId('student_id')
              ->constrained('students')
              ->onDelete('cascade');

        $table->foreignId('supervisor_id')
              ->nullable() // nullable jika pembimbing belum ditentukan saat pengajuan
              ->constrained('supervisors')
              ->onDelete('set null');

        $table->string('title');
        $table->text('description')->nullable();

        $table->foreignId('suggestion_supervisor')
              ->nullable()
              ->constrained('supervisors')
              ->onDelete('set null');

        $table->enum('status', ['pending', 'approved', 'rejected', 'in_progress', 'completed'])
              ->default('pending');

        $table->text('rejection_note')->nullable();
        $table->timestamp('submission_date')->useCurrent();
        $table->timestamp('approval_date')->nullable();

        // Kolom JSON untuk data mata kuliah pilihan dan nilainya
        // Contoh data: [["PKPL", "A"], ["P. Mobile", "B"]]
        $table->json('elective_courses')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skripsi');
    }
};
