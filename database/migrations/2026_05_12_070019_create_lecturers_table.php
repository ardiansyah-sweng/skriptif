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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('lecturer_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('expertise')->nullable();
            $table->unsignedInteger('max_supervisors')->default(12);
            $table->enum('status', ['aktif', 'cuti', 'pensiun'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
