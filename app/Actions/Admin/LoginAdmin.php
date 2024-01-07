<?php
namespace App\Actions\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginAdmin{
    use AsAction;
    public function handle(LoginRequest $request){
        $credentials = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($credentials)){
            return $request->expectsJson() ? 
                response()->json([
                    'error' =>  'credentials incorrect for admin user',
                    'email' => $request->email,
                    'authenticated' => false
                ]) : [
                    'error' =>  'credentials incorrect for admin user',
                    'email' => $request->email,
                    'authenticated' => false
                ];
        }
        $user = User::where('email', $request->email)->first();
        return $request->expectsJson() ? response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer' 
        ]) : [
            'token' => $token,
            'token_type' => 'bearer',

        ];
    }
}