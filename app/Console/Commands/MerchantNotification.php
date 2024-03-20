<?php

namespace App\Console\Commands;

use App\Models\Merchant;
use App\Models\User;
use App\Notifications\Merchant\CheckListNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;

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
        try{
            Redis::subscribe('notifies:merchant', function($notificationData){
                $notificationData = json_decode($notificationData);
                [$merchantIds, $checklist] = $notificationData;
                // dd($merchantIds);
                $merchants = User::whereIn('id', $merchantIds)->get();
                Notification::send($merchants, new CheckListNotification($checklist));
            });
        
        }catch(ConnectionException $e){
            echo 'error' . $e->getMessage() . PHP_EOL;
        }
    }
}
