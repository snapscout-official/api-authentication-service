<?php

namespace App\Http\Controllers\Agency;

use App\Actions\Agency\CreateAgencyCredentials;
use App\Http\Requests\Agency\AgencyRegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\LoginAgencyRequest;

class AgencyAuthController extends Controller
{
    public function login(LoginAgencyRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        //validation of user type
        if (!$user || $user->role_id !== Role::AGENCY) {
            return response()->json([
                'error' => 'You are not allowed to log in as merchant',
                'email' => $request->email,
            ], 401);
        }
        //if the user credentials are incorrect
        if (!auth('jwt')->attempt($request->all())) {
            return response()->json([
                'error' => 'credentials error',
                'email' => $request->email,
            ], 401);
        }
        $token = $user->generateToken();
        $user = collect($user)->merge([
            'role' => 'Agency'
        ]);
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
    public function signup(AgencyRegisterRequest $request)
    {
        try {
            $user = CreateAgencyCredentials::run($request);
            if (is_null($user)) {
                return response()->json([
                "error" => "error creating user in the server" ,
                'success' => false
            ], 422);
            }
            $token = $user->generateToken();
            $user = $user->merge([
                'role' => 'agency'
            ]);
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage(),
                'success' => false

            ], 422);
        }

    }
}
