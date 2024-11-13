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
        Schema::table('survey_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('kota_id')->nullable()->after('outlet_id');
            $table->unsignedBigInteger('unit_bisnis_id')->nullable()->after('kota_id');
            $table->unsignedBigInteger('direktorat_id')->nullable()->after('unit_bisnis_id');

            $table->foreign('kota_id')->references('id')->on('kota');
            $table->foreign('unit_bisnis_id')->references('id')->on('unit_bisnis');
            $table->foreign('direktorat_id')->references('id')->on('direktorat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_reports', function (Blueprint $table) {
            $table->dropForeign(['kota_id']);
            $table->dropForeign(['unit_bisnis_id']);
            $table->dropForeign(['direktorat_id']);

            $table->dropColumn('kota_id');
            $table->dropColumn('unit_bisnis_id');
            $table->dropColumn('direktorat_id');
        });
    }
};
