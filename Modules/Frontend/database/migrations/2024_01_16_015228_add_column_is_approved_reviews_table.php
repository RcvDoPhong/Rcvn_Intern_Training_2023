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
        if (Schema::hasTable('reviews')) {
            if (!Schema::hasColumn('reviews', 'is_approved')) {
                Schema::table('reviews', function (Blueprint $table) {
                    $table->tinyInteger('is_approved')->default(0)->comment('0: Not Approved; 1: Approved');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('is_approved');
            });
        }
    }
};
