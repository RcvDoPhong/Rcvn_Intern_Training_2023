<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('view_permissions')) {
            Schema::table('view_permissions', function (Blueprint $table) {
                 $table->renameColumn('view_permission_id', 'permission_id');
                 $table->renameColumn('route_name', 'name');

                // DB::statement('ALTER TABLE view_permissions CHANGE view_permission_id permission_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                // DB::statement('ALTER TABLE view_permissions CHANGE route_name name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL');
            });

            Schema::rename('view_permissions', 'permissions');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('permissions')) {
            Schema::table('permissions', function (Blueprint $table) {
                 $table->renameColumn('permission_id', 'view_permission_id');
                 $table->renameColumn('name', 'route_name');

                // DB::statement('ALTER TABLE permissions CHANGE permission_id view_permission_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                // DB::statement('ALTER TABLE permissions CHANGE name route_name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL');
            });

            Schema::rename('permissions', 'view_permissions');
        }
    }
};
