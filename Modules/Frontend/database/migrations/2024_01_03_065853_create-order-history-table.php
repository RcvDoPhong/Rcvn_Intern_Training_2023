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
        Schema::create('order_history', function (Blueprint $table) {
            $table->id('order_history_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id');
            $table->foreignId('order_status_id')->default(1)->constrained('order_status', 'order_status_id');
            $table->foreignId('updated_by')->nullable()->constrained('admins', 'admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_history');
    }
};
