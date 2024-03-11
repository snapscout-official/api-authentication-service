<?php

use App\Events\CheckListEvent;
use App\Http\Controllers\Agency\AgencyAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Merchant\AuthController as MerchantAuthController;
use App\Http\Controllers\SendNotificationController;
use Illuminate\Support\Facades\Cache;

Route::post('/admin/login', [AuthController::class, 'loginAsAdmin']);
Route::group(['prefix' => 'merchant'], function(){
    Route::controller(MerchantAuthController::class)->group(function(){
        Route::post('/signup', 'signup');
        Route::post('/login', 'login');
    });
});
Route::group(['prefix' => 'agency'], function(){
    Route::controller(AgencyAuthController::class)->group(function(){
        Route::post('/login', 'login');
    });
});
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/cache', function(){
    $my_cache = Cache::get('test');
    return response()->json([
        'message' => 'retrieved cached'
    ]);
})->name('cache');
Route::post('/send-notification', [SendNotificationController::class, 'send']);

