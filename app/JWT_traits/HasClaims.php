<?php
namespace App\JWT_traits;
trait HasClaims{
    
    public function getJWTIdentifier()
    {
        return $this->id;
    }
    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            ''
        ];
    }
}