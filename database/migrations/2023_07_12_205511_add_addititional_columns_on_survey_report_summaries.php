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
        Schema::table('survey_report_summaries', function (Blueprint $table) {
            $table->integer('feedback')->default(0)->after('completed');
            $table->bigInteger('duration')->default(0)->after('feedback')->comment('In Seconds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_report_summaries', function (Blueprint $table) {
            //
        });
    }
};
