<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials =   $request->only('email', 'password');
        if (!$token = auth('jwt')->attempt($credentials)){
            abort(406);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
                'token_type' => 'bearer'
            ]
        ]);
    }
    public function loginAsAdmin(Request $request){
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', $request->email)->first();
        if ($user->role_id !== Role::ADMIN){
            return response()->json([
                'error' => 'you are not allowed to login as admin',
                'email' => $request->email
            ]);
        }
        if (!auth('jwt')->attempt($credentials)){
            return response()->json([
                'error'
            ], 422);
        }
        $token = $user->generateToken();
        return response()->json([
            'token' => $token
        ]);
    }

}
