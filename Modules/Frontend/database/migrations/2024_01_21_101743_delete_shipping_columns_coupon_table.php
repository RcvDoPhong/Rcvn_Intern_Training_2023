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
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('shipping_price');
            $table->dropColumn('shipping_price_percent');

            $table->dropColumn('shipping_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->float('shipping_price')->default(0);
            $table->float('shipping_price_percent')->default(1.0);
            $table->tinyInteger('shipping_type')->default(0)->comment('0: plain price; 1: percent type');
        });
    }
};
