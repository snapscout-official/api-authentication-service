<?php

use App\Http\Controllers\Agency\AgencyAuthController;
use App\Models\Role;
use App\Models\User;
use App\Models\Merchant;
use App\Events\CheckListEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Merchant\CheckListNotification;
use Illuminate\Support\Facades\URL;

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
    return "Hello World";
});
Route::get('/notification', function () {
    event(new CheckListEvent('Hello websocket'));
    return 'hello';
});
Route::get('/notify', function () {
    $user = User::where('role_id', Role::MERCHANT)->get();
    Notification::send($user, new CheckListNotification());
    // Redis::wset('Gio', 'test');
    return 'test';
});

Route::get('/agency/update-profile', [AgencyAuthController::class, 'update_profile']);
