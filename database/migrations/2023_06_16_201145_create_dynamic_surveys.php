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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->tinyInteger('privacy')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('question_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('icon')->nullable();
            $table->tinyInteger('position');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('survey_id')->references('id')->on('surveys');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_group_id');
            $table->text('content')->nullable();
            $table->string('answer_type');
            $table->tinyInteger('position');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_group_id')->references('id')->on('question_groups');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->text('content')->nullable();
            $table->tinyInteger('show_freetext')->default(0);
            $table->tinyInteger('position');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_id')->references('id')->on('questions');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('questions');
            $table->foreign('answer_id')->references('id')->on('answers');
        });

        Schema::create('survey_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('survey');
            $table->text('signature')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('survey_report_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_report_id');
            $table->text('question_group');
            $table->text('question');
            $table->text('answer');
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
        Schema::table('survey_report_details', function (Blueprint $table) {
            $table->dropForeign(['survey_report_id']);
        });

        Schema::table('survey_reports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['question_group_id']);
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['answer_id']);
        });

        Schema::table('question_groups', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
        });

        Schema::dropIfExists('survey_report_details');
        Schema::dropIfExists('survey_reports');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_groups');
        Schema::dropIfExists('surveys');
    }
};
