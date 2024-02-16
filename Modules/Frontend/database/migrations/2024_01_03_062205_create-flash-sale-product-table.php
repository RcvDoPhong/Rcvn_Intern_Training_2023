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
        Schema::create('flash_sale_products', function (Blueprint $table) {
            $table->id('flash_sale_products_id');
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->boolean("is_visible")->default(0)->comment("0: flash sale does not appear'; 1: flash sale appear");
            $table->dateTime('start_at');
            $table->dateTime('expire_at');
            $table->foreignId('updated_by')->constrained('admins', 'admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sale_products');
    }
};
