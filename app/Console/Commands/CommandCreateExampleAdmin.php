<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Admin\App\Models\Admin;

class CommandCreateExampleAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmt-create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an example admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Admin::created([
            "name" => "Example",
            "email" => "admintest@example.com",
            "password" => Hash::make("password"),
            "role_id" => 1,
            'gender' => 0,
            'is_active' => 1,
            'nickname' => 'Admin',
            "update_by" => 1
        ]);
    }
}
