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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->foreignId('role_id')->nullable()->constrained('roles', 'role_id');
            $table->foreignId('delivery_city_id')->nullable()->constrained('cities', 'city_id');
            $table->foreignId('delivery_district_id')->nullable()->constrained('districts', 'district_id');
            $table->foreignId('delivery_ward_id')->nullable()->constrained('wards', 'ward_id');
            $table->foreignId('billing_city_id')->nullable()->constrained('cities', 'city_id');
            $table->foreignId('billing_district_id')->nullable()->constrained('districts', 'district_id');
            $table->foreignId('billing_ward_id')->nullable()->constrained('wards', 'ward_id');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('nickname');
            $table->tinyInteger('is_subscription')->default(0)->comment('0: No subscribe; 1: Subscribed');
            $table->date('birthday');
            $table->string('password');
            $table->tinyInteger('gender')->comment('0: female; 1: male');
            $table->string('delivery_fullname')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_zipcode', 10)->nullable();
            $table->string('delivery_phone_number', 11)->nullable();
            $table->string('billing_fullname')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_zipcode', 10)->nullable();
            $table->string('billing_phone_number', 11)->nullable();
            $table->string('billing_tax_id_number', 15)->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('0: Non-active; 1: active');
            $table->tinyInteger('is_delete')->default(1)->comment('0: Delete; 1: active');
            $table->timestamp('email_verified_at')->nullable();
            
            $table->rememberToken();
            $table->foreignId('updated_by')->nullable()->constrained('admins', 'admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
