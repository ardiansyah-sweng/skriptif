<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            // Menambahkan kolom role dan weight setelah lecturer_id
            $table->enum('role', ['pembimbing', 'penguji'])->after('lecturer_id');
            $table->decimal('weight', 5, 2)->default(50.00)->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn(['role', 'weight']);
        });
    }
};