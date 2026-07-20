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
        Schema::create('elective_course_skripsi', function (Blueprint $table) {

            $table->id();

            $table->foreignId('skripsi_id')
                ->constrained('skripsi')
                ->cascadeOnDelete();

            $table->foreignId('elective_course_id')
                ->constrained('elective_courses')
                ->cascadeOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elective_course_skripsi');
    }
};
