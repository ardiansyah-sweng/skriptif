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
        // Sengaja dikosongkan agar tidak menabrak foreign key
        // Tabel skripsi yang sebenarnya dibuat di migrasi tanggal 2026_06_23
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Sengaja dikosongkan
    }
};
