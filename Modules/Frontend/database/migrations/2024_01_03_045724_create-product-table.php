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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'category_id');
            $table->foreignId('brand_id')->nullable()->constrained('brands', 'brand_id');
            $table->string('product_uuid')->unique()->nullable();
            $table->string('product_name')->unique();
            $table->string('option_name');
            $table->string('product_thumbnail')->default('product_logo_placeholder.png');
            $table->bigInteger('base_price');
            $table->bigInteger('sale_price');
            $table->float('sale_price_percent')->default(0.0);
            $table->tinyInteger('sale_type')->default(0)->comment('0: sale-with-plain-price; 1: sale-with-percent type');
            $table->text('product_description')->nullable();
            $table->string('brief_description')->nullable();
            $table->integer('stock')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: stop-selling; 1: selling; 2: sold-out');
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
        Schema::dropIfExists('products');
    }
};
