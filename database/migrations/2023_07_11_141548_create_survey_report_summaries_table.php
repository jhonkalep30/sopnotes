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
        Schema::create('survey_report_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_report_id');
            $table->integer('total')->default(0);
            $table->integer('uncompleted')->default(0);
            $table->integer('completed')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('survey_report_id')->references('id')->on('survey_reports');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_report_summaries', function (Blueprint $table) {
            $table->dropForeign(['survey_report_id']);
        });

        Schema::dropIfExists('survey_report_summaries');
    }
};
