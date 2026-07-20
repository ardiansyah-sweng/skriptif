<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Detail nilai per unsur penilaian untuk setiap evaluasi.
     * Total dari nilai-nilai ini yang dijumlahkan menjadi `evaluations.score`.
     */
    public function up(): void
    {
        Schema::create('evaluation_component_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evaluation_id')->constrained('evaluations')->cascadeOnDelete();
            $table->foreignId('evaluation_component_id')->constrained('evaluation_components')->cascadeOnDelete();

            $table->decimal('score', 5, 2);

            $table->timestamps();

            // Satu unsur hanya boleh dinilai sekali per evaluasi
            $table->unique(['evaluation_id', 'evaluation_component_id'], 'eval_component_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_component_scores');
    }
};