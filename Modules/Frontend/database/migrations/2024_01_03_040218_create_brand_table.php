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
        Schema::create('brands', function (Blueprint $table) {
            $table->id('brand_id');
            $table->string('brand_logo')->default('brand_logo_placeholder.png');
            $table->string('brand_name');
            $table->date('founded');
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
        Schema::dropIfExists('brands');
    }
};
