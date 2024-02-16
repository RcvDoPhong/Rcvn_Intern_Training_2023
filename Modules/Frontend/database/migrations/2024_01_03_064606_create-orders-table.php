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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('zip_code');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('shipping_method_id')->constrained('shipping_methods', 'shipping_method_id');
            $table->foreignId('city_id')->constrained('cities', 'city_id');
            $table->foreignId('district_id')->constrained('districts', 'district_id');
            $table->foreignId('ward_id')->constrained('wards', 'ward_id');
            $table->string('order_uid')->unique();
            $table->tinyInteger('payment_method')->default(0)->comment("0: cod method; 1: banking method (visa, master card,...)");
            $table->string('coupon_code')->nullable();
            $table->float('total_price')->default(0);
            $table->float('subtotal_price')->default(0);
            $table->float('coupon_price')->default(0);
            $table->float('shipping_price')->default(0);
            $table->string('delivery_address');
            $table->string('telephone_number');
            $table->foreignId('updated_by')->nullable()->constrained('admins', 'admin_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
