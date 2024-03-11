<?php

namespace App\Guard;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;

class JWTGuard implements Guard{
    use GuardHelpers;
    protected JWT $jwt;
    protected Request $request;

    public function __construct(JWT $jwt, Request $request)
    {
        $this->jwt = $jwt;
        $this->request = $request;
    }
    public function user()
    {
        if (is_null($this->user)){
            return null;
        }
        return $this->user;
    }
    public function validate(array $credentials = [])
    {
        
    }   
}