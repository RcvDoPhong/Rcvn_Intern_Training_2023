<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


// warning use for mariaDB version 10, if you use Schema class,  it won't work at all
return new class extends Migration {
    public function up()
    {
        // DB::statement('ALTER TABLE order_detail CHANGE user_id order_id BIGINT UNSIGNED');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('ALTER TABLE order_detail CHANGE order_id user_id BIGINT UNSIGNED');
    }
};
