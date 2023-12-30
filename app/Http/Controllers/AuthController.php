<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials =   $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)){
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
}
