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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id('shipping_method_id');
            $table->string('shipping_method_name');
            $table->integer('shipping_price');
            $table->integer('shipping_sale_price');
            $table->float('shipping_sale_price_percent');
            $table->tinyInteger('shipping_type')->default(0)->comment("0: all areas (in vietnam); 1: specific locations");
            $table->tinyInteger('estimate_shipping_days');
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
        Schema::dropIfExists('shipping_methods');
    }
};
