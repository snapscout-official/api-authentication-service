<?php

namespace App\Http\Controllers\Agency;

use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\LoginAgencyRequest;

class AgencyAuthController extends Controller
{
    public function login(LoginAgencyRequest $request){
        $user = User::where('email', $request->email)->first();
        //validation of user type
        if (!$user || $user->role_id !== Role::AGENCY){
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
            'user_type' => 'Agency',
            'role_id' => Role::AGENCY
        ]);
    }
}
