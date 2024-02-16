<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\Frontend\app\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Modules\Frontend\app\Notification\PushNotification;

class TestPushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to push a user description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::find(2);
        $sendToOneUser = User::find(1);
        Notification::send([$sendToOneUser], new PushNotification($user, "Đây là một đoạn test message"));
    }
}
