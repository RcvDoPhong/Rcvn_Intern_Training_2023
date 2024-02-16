<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('role_view_permissions')) {
            Schema::table('role_view_permissions', function (Blueprint $table) {
                $table->dropForeign(['updated_by']);
                $table->dropColumn('updated_by');

                 $table->renameColumn('view_permission_id', 'permission_id');
                 $table->renameColumn('permission_type', 'allow');

                //                 DB::statement('ALTER TABLE role_view_permissions CHANGE view_permission_id permission_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                //                 DB::statement("ALTER TABLE `role_permission` CHANGE `allow` `all` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '0: not checked; 1: checked';
                // ");


            });
            Schema::rename("role_view_permissions", "role_permission");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('role_permission')) {
            Schema::table('role_permission', function (Blueprint $table) {
                if (!Schema::hasColumn('role_permission', 'updated_by')) {
                    $table->foreignId('updated_by')->nullable()->constrained('admins', 'admin_id');
                }

                 $table->renameColumn('permission_id', 'view_permission_id');
                 $table->renameColumn('allow', 'permission_type');

                // DB::statement('ALTER TABLE role_permission CHANGE permission_id view_permission_id  BIGINT UNSIGNED');
                // DB::statement('ALTER TABLE role_permission CHANGE allow permission_type TINYINT(4)');
            });
            Schema::rename("role_permission", "role_view_permissions");
        }
    }
};
