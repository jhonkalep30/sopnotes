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
        Schema::table('survey_report_details', function (Blueprint $table) {
            $table->text('origin_answer')->nullable()->after('question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_report_details', function (Blueprint $table) {
            $table->dropColumn('origin_answer');
        });
    }
};
