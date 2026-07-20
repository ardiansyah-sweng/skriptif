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
        Schema::create('seminar_proposal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skripsi_id')->unique()->constrained('skripsi')->cascadeOnDelete();
            $table->string('bukti_turnitin')->nullable();
            $table->string('bukti_literasi')->nullable();
            $table->string('bukti_transkrip')->nullable();
            $table->string('bukti_toefl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_proposal_documents');
    }
};
