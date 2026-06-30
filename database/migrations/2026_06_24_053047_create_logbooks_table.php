<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skripsi_id')->constrained('skripsi')->cascadeOnDelete();
            $table->foreignId('evaluator_id')->constrained('lecturers')->cascadeOnDelete();
            $table->string('logbook_type');
            $table->integer('overall_score');
            $table->string('grade_letter', 2)->nullable();
            $table->text('revision_notes')->nullable();
            $table->enum('status', ['passed', 'needs_revision', 'failed'])->default('needs_revision');
            $table->date('logbook_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};