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
        $listTable = \DB::select('SHOW TABLES');
        foreach($listTable as $list){
            foreach ($list as $key => $value){
                if (Schema::hasColumn($value, 'created_at') && Schema::hasColumn($value, 'updated_at')){
                    Schema::table($value, function (Blueprint $table) {
                        $table->unsignedBigInteger('created_by')->nullable();
                        $table->unsignedBigInteger('updated_by')->nullable();

                        $table->foreign('created_by')->references('id')->on('users');
                        $table->foreign('updated_by')->references('id')->on('users');
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $listTable = \DB::select('SHOW TABLES');
        foreach($listTable as $list){
            foreach ($list as $key => $value){
                if (Schema::hasColumn($value, 'created_by') && Schema::hasColumn($value, 'updated_by')){
                    Schema::table($value, function (Blueprint $table) {
                        $table->dropForeign(['created_by']);
                        $table->dropForeign(['updated_by']);
                    });
                }

                if (Schema::hasColumn($value, 'created_by') && Schema::hasColumn($value, 'updated_by')){
                    Schema::table($value, function (Blueprint $table) {
                        $table->dropColumn(['created_by', 'updated_by']);
                    });
                }
            }
        }
    }
};
