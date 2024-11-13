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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('name');
            $table->string('level_jabatan')->nullable();
            $table->string('jenis_jabatan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            migration_created_updated_by($table);

            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::create('jabatan_classifiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jabatan_id');
            $table->unsignedBigInteger('classifier_id');

            $table->timestamps();
            $table->softDeletes();

            migration_created_updated_by($table);

            $table->foreign('jabatan_id')->references('id')->on('jabatan');
            $table->foreign('classifier_id')->references('id')->on('classifiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
