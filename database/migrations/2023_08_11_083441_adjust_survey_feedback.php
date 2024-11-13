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
        Schema::table('survey_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('survey_report_id')->nullable()->after('user_id');
            $table->foreign('survey_report_id')->references('id')->on('survey_reports');
            
            $table->dropForeign(['survey_id']);
            $table->dropColumn('survey_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('survey_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('outlet_id')->nullable()->after('survey_id');
            $table->foreign('outlet_id')->references('id')->on('outlets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('survey_id')->nullable()->after('user_id');
            $table->foreign('survey_id')->references('id')->on('surveys');
            
            $table->dropForeign(['survey_report_id']);
            $table->dropColumn('survey_report_id');
        });

        Schema::table('survey_reports', function (Blueprint $table) {
            $table->dropForeign(['outlet_id']);
            $table->dropColumn('outlet_id');
        });
    }
};
