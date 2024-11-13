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
        Schema::table('answers', function (Blueprint $table) {
            $table->tinyInteger('is_required')->default(0)->after('show_freetext');
        });

        Schema::table('survey_reports', function (Blueprint $table) {
            $table->datetime('started_at')->nullable()->after('survey');
            $table->datetime('ended_at')->nullable()->after('started_at');
        });

        Schema::create('survey_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('survey_id')->index();
            $table->timestamps();
            $table->softDeletes();
     
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('survey_id')->references('id')->on('surveys');
        });

        Schema::create('survey_feedback_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_feedback_id');

            $table->bigInteger('module_id')->index();
            $table->text('module_name');
            $table->text('feedback');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('survey_feedback_id')->references('id')->on('survey_feedback');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('is_required');
        });

        Schema::table('survey_reports', function (Blueprint $table) {
            $table->dropColumn('started_at');
            $table->dropColumn('ended_at');
        });

        Schema::table('survey_feedback', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['survey_id']);
        });

        Schema::table('survey_feedback_details', function (Blueprint $table) {
            $table->dropForeign(['survey_feedback_id']);
        });

        Schema::dropIfExists('survey_feedback_details');
        Schema::dropIfExists('survey_feedback');
    }
};
