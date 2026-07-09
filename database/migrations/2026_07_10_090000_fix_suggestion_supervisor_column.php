<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skripsi', function (Blueprint $table) {
            // Kolom lama ini didefinisikan sebagai foreign key ke lecturers,
            // padahal secara fungsi cuma saran nama dosen (teks bebas).
            $table->dropForeign(['suggestion_supervisor']);
            $table->dropColumn('suggestion_supervisor');
        });

        Schema::table('skripsi', function (Blueprint $table) {
            $table->string('suggestion_supervisor')->nullable()->after('supervisor_id');
        });
    }

    public function down(): void
    {
        Schema::table('skripsi', function (Blueprint $table) {
            $table->dropColumn('suggestion_supervisor');
        });

        Schema::table('skripsi', function (Blueprint $table) {
            $table->foreignId('suggestion_supervisor')->nullable()->constrained('lecturers')->nullOnDelete();
        });
    }
};