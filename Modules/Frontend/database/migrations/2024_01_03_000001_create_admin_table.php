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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('admin_id');
            $table->foreignId('role_id')->constrained('roles', 'role_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->rememberToken();
            $table->string('nickname');
            $table->date('birthday');
            $table->string('password');
            $table->tinyInteger('gender')->comment('0: female; 1: male');
            $table->tinyInteger('is_active')->default(1)->comment('0: Non-active; 1: active');
            $table->tinyInteger('is_delete')->default(1)->comment('0: delete; 1: active');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('admin_id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
