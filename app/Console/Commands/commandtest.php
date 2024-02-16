<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Models\Brand;
use Modules\Admin\App\Models\Product;
use Modules\Admin\App\Models\Role;

class commandtest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(Product::all() as $product) {
            $product->searchable();
        }

        foreach(Role::all() as $role) {
            $role->searchable();
        }

        foreach(Brand::all() as $brand) {
            $brand->searchable();
        }
    }
}
