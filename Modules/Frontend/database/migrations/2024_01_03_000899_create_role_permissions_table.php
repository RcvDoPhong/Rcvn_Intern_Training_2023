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
        Schema::create('role_view_permissions', function (Blueprint $table) {
            $table->primary(['role_id', 'view_permission_id']);
            $table->foreignId('role_id')->constrained('roles', 'role_id');
            $table->foreignId('view_permission_id')->constrained('view_permissions', 'view_permission_id');
            $table->tinyInteger('permission_type')->default(1)->comment('0: not allow; 1: allow');
            $table->foreignId('updated_by')->nullable()->constrained('admins', 'admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_view_permissions');
    }
};
