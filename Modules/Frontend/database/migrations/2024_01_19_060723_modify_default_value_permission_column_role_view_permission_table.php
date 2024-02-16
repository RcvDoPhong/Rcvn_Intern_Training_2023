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
        if (Schema::hasColumn('role_view_permissions', 'permission_type')) {
            Schema::table('role_view_permissions', function (Blueprint $table) {
                $table->tinyInteger('permission_type')->default(1)->comment('0: not checked; 1: checked')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('role_view_permissions', 'permission_type')) {
            Schema::table('role_view_permissions', function (Blueprint $table) {
                $table->string('permission_type')->change();
            });
        }
    }
};
