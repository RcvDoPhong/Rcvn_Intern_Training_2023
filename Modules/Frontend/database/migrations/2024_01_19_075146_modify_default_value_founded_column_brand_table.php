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
        if (Schema::hasColumn('brands', 'founded')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->date('founded')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('brands', 'founded')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->date('founded')->change();
            });
        }
    }
};
