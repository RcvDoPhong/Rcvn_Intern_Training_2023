<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->unsignedBigInteger('parent_categories_id')->nullable();
            $table->foreign('parent_categories_id')->references('category_id')->on('categories');
            $table->string('category_name');
            $table->tinyInteger('is_active')->default(1)->comment('0: non-active; 1: active');
            $table->tinyInteger('is_delete')->default(0)->comment('0: active; 1: delete');
            $table->foreignId('updated_by')->constrained('admins', 'admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
