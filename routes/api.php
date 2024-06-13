<?php

use App\Http\Controllers\Agency\AgencyAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Merchant\AuthController as MerchantAuthController;
use App\Http\Controllers\SendNotificationController;
use Illuminate\Support\Facades\Cache;

Route::post('/admin/login', [AuthController::class, 'loginAsAdmin']);
Route::group(['prefix' => 'merchant'], function () {
    Route::controller(MerchantAuthController::class)->group(function () {
        Route::post('/signup', 'signup');
        Route::post('/login', 'login');
    });
});
Route::group(['prefix' => 'agency'], function () {
    Route::controller(AgencyAuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/signup', 'signup');
        Route::post('/update-profile', function (Request $request) {
            dd($request);
            return "Not yet implemented";
        });
    });
});
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/cache', function () {
    $my_cache = Cache::get('test');
    return response()->json([
        'message' => 'retrieved cached'
    ]);
})->name('cache');
Route::post('/send-notification', [SendNotificationController::class, 'send']);
Route::middleware(['auth:jwt'])->group(function () {
    Route::get('/bar', function (Request $request) {
        return response()->json([
            'message' => 'Welcome'
        ]);
    });
    Route::post('/verify-token', function (Request $request) {
        $validated = $request->validate([
            'token' => 'required|string'
        ], $request->all());
        $authenticatedUser = $request->user();
        return response()->json([
            'message' => 'token is valid',
            'email' => $authenticatedUser->email,
            'name' => "{$authenticatedUser->first_name} {$authenticatedUser->last_name}"
        ]);
    });

});
