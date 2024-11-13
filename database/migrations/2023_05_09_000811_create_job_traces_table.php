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
        Schema::create('job_traces', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('model');
            $table->text('file_path')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->integer('status')->default(0);
            $table->text('logs')->nullable();
            $table->unsignedBigInteger('requested_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('requested_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_traces', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
        });
        
        Schema::dropIfExists('job_traces');
    }
};
