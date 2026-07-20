<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });

        Schema::table('lecturers', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });

        // Backfill: tautkan data lama berdasarkan kecocokan email yang sudah ada,
        // supaya akun yang emailnya sudah cocok langsung tersambung tanpa perlu diedit manual.
        DB::table('students')->whereNull('user_id')->orderBy('id')->chunkById(100, function ($students) {
            foreach ($students as $student) {
                $userId = DB::table('users')->where('email', $student->email)->value('id');
                if ($userId) {
                    DB::table('students')->where('id', $student->id)->update(['user_id' => $userId]);
                }
            }
        });

        DB::table('lecturers')->whereNull('user_id')->orderBy('id')->chunkById(100, function ($lecturers) {
            foreach ($lecturers as $lecturer) {
                $userId = DB::table('users')->where('email', $lecturer->email)->value('id');
                if ($userId) {
                    DB::table('lecturers')->where('id', $lecturer->id)->update(['user_id' => $userId]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
