<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Merchant;
use App\Events\CheckListEvent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Merchant\CheckListNotification;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return storage_path(env('JWT_PUBLIC_KEY'));
    return storage_path( env('JWT_PUBLIC_KEY'));
});
Route::get('/notification', function(){
    event(new CheckListEvent('Hello websocket'));
    return 'hello';
});
Route::get('/notify', function(){
    $user = User::where('role_id', Role::MERCHANT)->get();
    Notification::send($user, new CheckListNotification());
    Redis::set('Gio', 'test');
    return 'test';
});
