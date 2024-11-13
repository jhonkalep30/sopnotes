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
        if (!Schema::hasTable('permissions'))
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('group_key')->nullable();
            $table->string('group_label')->nullable();
            $table->string('action_key');
            $table->string('action_label');
            $table->string('url_method')->nullable();
            $table->string('url')->nullable();
            $table->string('permission_key');
            $table->timestamps();
            $table->softDeletes();

        });

        if (!Schema::hasTable('menus'))
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->string('label');
            $table->string('type')->comment('section, group, link');
            $table->integer('order')->default(1);
            $table->text('icon')->nullable();
            $table->text('url')->nullable();
            $table->tinyInteger('is_hidden')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('menus');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        if (!Schema::hasTable('role_permissions'))
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->tinyInteger('access')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('permissions');
    }
};
