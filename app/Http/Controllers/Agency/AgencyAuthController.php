<?php

namespace App\Http\Controllers\Agency;

use App\Actions\Agency\CreateAgencyCredentials;
use App\Actions\Agency\UpdateAgencyProfile;
use App\Http\Requests\Agency\AgencyRegisterRequest;
use App\Http\Requests\UpdateAgencyProfileRequest;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\LoginAgencyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AgencyAuthController extends Controller
{
    public function login(LoginAgencyRequest $request):JsonResponse
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
    public function signup(AgencyRegisterRequest $request):JsonResponse
    {
        try {
            $user = CreateAgencyCredentials::run($request);
            if (is_null($user) || !($user instanceof User)) {
                return response()->json([
                "error" => "error creating user in the server" ,
                'success' => false
            ], 422);
            }
            $token = $user->generateToken();
            $user = collect($user)->merge([
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
    public function update(UpdateAgencyProfileRequest $request): JsonResponse{
        //update user fields

       return UpdateAgencyProfile::run($request);
    }
    // this is for the email verification. will be implemented in the future
    // public function update_profile(Request $request):JsonResponse{
    //     if (!$request->hasValidSignature){
    //         return response()->json([
    //             'message' => 'the url might be modified'
    //         ],422);
    //     }
    //     $user = auth()->user();
    //     if (is_null($user)){
    //         return response()->json([
    //             'message' => 'no currently authenticated user'
    //         ],422);
    //     }
    // }

}
