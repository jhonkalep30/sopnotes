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
        Schema::create('survey_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->text('file_path');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('survey_id')->references('id')->on('surveys');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_files', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
        });

        Schema::dropIfExists('survey_files');
    }
};
