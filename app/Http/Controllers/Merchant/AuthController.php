<?php

namespace App\Http\Controllers\Merchant;

use App\Actions\Merchant\CreateMerchantCredentials;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\LoginRequest;
use App\Http\Requests\Merchant\SignupRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function signup(SignupRequest $request){
        $user = CreateMerchantCredentials::run($request);
        event(new Registered($user));
        $token = $user->generateToken();
        return $request->expectsJson() ? 
                response()->json([
                    'message' => 'sucessfully created merchant user',
                    'token' => $token,
                    'token_type' => 'bearer'
                ]) :
                [
                    'message' => 'sucessfully created merchant user',
                    'token' => $token,
                    'token_type' => 'bearer'
                ];
    }
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        //validation of user type
        if (!$user || $user->role_id !== Role::MERCHANT){
            return response()->json([
                'error' => 'You are not allowed to log in as merchant',
                'email' => $request->email,
            ], 401);
        }
        //if the user credentials are incorrect
        if (!auth()->attempt($request->all())){
            return response()->json([
                'error' => 'credentials error',
                'email' => $request->email,
            ], 401);
        }
        $token = $user->generateToken();
        return response()->json([
            'message' => 'server sucessfully authenticated the user',
            'token' => $token,
            'token_type' => 'bearer',
            'user_type' => 'Merchant',
            'role_id' => Role::MERCHANT
        ]);
    }
}
