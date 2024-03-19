<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class MerchantNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies merchant users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       Redis::subscribe('notifies:merchant', function($notificationData){
        $notificationData = json_decode($notificationData);
        foreach($notificationData as $notificationId){
            echo 'ids looped' . PHP_EOL;
        }
       });
    }
}
