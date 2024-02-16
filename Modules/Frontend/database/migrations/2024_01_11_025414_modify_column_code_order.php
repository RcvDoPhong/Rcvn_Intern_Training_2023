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



        if (Schema::hasTable('orders')) {
            Schema::table('orders', function($table) {
                $table->string('zip_code')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function($table) {
            $table->string('zip_code')->change();
        });
    }
};
