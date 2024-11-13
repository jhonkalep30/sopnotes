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
        Schema::create('survey_classifiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('classifier_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->foreign('classifier_id')->references('id')->on('classifiers');
        });

        Schema::create('survey_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('user_id');
            $table->datetime('available_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('survey_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('survey_id')->index()->nullable()->after('user_id');
            $table->text('description')->nullable()->after('survey');

            $table->foreign('survey_id')->references('id')->on('surveys');
        });

        Schema::table('survey_report_details', function (Blueprint $table) {
            $table->unsignedBigInteger('question_group_id')->index()->nullable()->after('survey_report_id');
            $table->unsignedBigInteger('question_id')->index()->nullable()->after('question_group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_classifiers', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            $table->dropForeign(['classifier_id']);
        });

        Schema::dropIfExists('survey_classifiers');

        Schema::table('survey_availabilities', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('survey_availabilities');

        Schema::table('survey_reports', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            
            $table->dropColumn('survey_id');
            $table->dropColumn('description');
        });

        Schema::table('survey_report_details', function (Blueprint $table) {
            $table->dropColumn('question_group_id');
            $table->dropColumn('question_id');
        });
    }
};
