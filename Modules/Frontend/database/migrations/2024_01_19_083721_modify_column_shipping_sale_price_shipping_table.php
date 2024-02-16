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
        if (Schema::hasColumn('shipping_methods', 'shipping_sale_price')
            && Schema::hasColumn('shipping_methods', 'shipping_sale_price_percent')) {
            Schema::table('shipping_methods', function (Blueprint $table) {
                $table->float('shipping_sale_price')->nullable()->change();
                $table->float('shipping_sale_price_percent')->default(0)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('shipping_methods', 'shipping_sale_price')) {
            Schema::table('shipping_methods', function (Blueprint $table) {
                $table->float('shipping_sale_price')->change();
                $table->float('shipping_sale_price_percent')->change();
            });
        }
    }
};
