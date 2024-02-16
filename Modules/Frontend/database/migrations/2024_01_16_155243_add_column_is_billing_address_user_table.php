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
        if (!Schema::hasColumn('users', 'is_billing_address')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('is_billing_address')->default(0)->comment('0: No; 1: Yes');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_billing_address')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_billing_address');
            });
        }
    }
};
