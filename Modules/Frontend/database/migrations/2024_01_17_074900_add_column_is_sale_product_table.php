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
        if (!Schema::hasColumn('products', 'is_sale')) {
            Schema::table('products', function (Blueprint $table) {
                $table->tinyInteger('is_sale')->default(0)->comment('0: Not on sale; 1: On sale');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'is_sale')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('is_sale');
            });
        }
    }
};
