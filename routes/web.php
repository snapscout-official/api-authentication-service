<?php

use App\Models\Merchant;
use App\Events\CheckListEvent;
use Illuminate\Support\Facades\Route;

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
    // return view('welcome');
    // return storage_path(env('JWT_PUBLIC_KEY'));
});
Route::get('/notification', function(){
    event(new CheckListEvent('Hello websocket'));
    return 'hello';
});
