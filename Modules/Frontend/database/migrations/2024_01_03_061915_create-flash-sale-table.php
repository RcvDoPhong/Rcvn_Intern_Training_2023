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
        Schema::create('flash_sale', function (Blueprint $table) {
            $table->id('flash_sale_id');
            $table->float('sale_price')->default(0);
            $table->float('sale_price_percent')->default(0);
            $table->tinyInteger('sale_type')->default(0)->comment("0: plain price; 1: percent type");
            $table->foreignId('updated_by')->constrained('admins', 'admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sale');
    }
};
