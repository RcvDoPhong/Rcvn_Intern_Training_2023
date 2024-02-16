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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id('coupon_id');
            $table->string('code');
            $table->float('sale_price')->default(0);
            $table->float('sale_price_percent')->default(0);
            $table->tinyInteger('sale_type')->default(0)->comment("0: plain price; 1: percent type");
            $table->string('description');
            $table->float('shipping_price')->default(0);
            $table->float('shipping_price_percent')->default(0);
            $table->tinyInteger('shipping_type')->default(0)->comment("0: plain price; 1: percent type");
            $table->tinyInteger('is_active')->default(1)->comment('0: non-active; 1: active');
            $table->tinyInteger('is_delete')->default(0)->comment('0: active; 1: delete');
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
        Schema::dropIfExists('coupons');
    }
};
