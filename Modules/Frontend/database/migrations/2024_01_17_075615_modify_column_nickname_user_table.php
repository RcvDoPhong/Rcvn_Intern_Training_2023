<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('users', 'nickname')) {
            Schema::table('users', function ($table) {
                $table->string('nickname', 50)->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'nickname')) {
            Schema::table('users', function ($table) {
                $table->string('nickname', 50)->nullable(false)->change();
            });
        }
    }
};
