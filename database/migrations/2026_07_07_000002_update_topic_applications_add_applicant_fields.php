<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE topic_applications MODIFY student_id BIGINT UNSIGNED NULL');

        Schema::table('topic_applications', function (Blueprint $table) {
            $table->string('applicant_name')->nullable()->after('student_id');
            $table->string('applicant_nim')->nullable()->after('applicant_name');
            $table->string('document_path')->nullable()->after('applicant_nim');
        });
    }

    public function down(): void
    {
        Schema::table('topic_applications', function (Blueprint $table) {
            $table->dropColumn(['applicant_name', 'applicant_nim', 'document_path']);
        });

        DB::statement('ALTER TABLE topic_applications MODIFY student_id BIGINT UNSIGNED NOT NULL');
    }
};
