<?php
namespace App\JWT_traits;

use App\Models\Role;

trait HasClaims{
    
    public function getJWTIdentifier()
    {
        return $this->id;
    }
    public function getJWTCustomClaims()
    {
        $claims = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'tin_number' => $this->tin_number,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'role_id' => null,
            'location'
        ];

        if ($this->role_id === Role::AGENCY){
            $agency_data = $this->agency;
            $claims['agency'] = $agency_data;
            $claims['location'] = $agency_data->location;
            return $claims;
        }
        if ($this->role_id === Role::MERCHANT){
            $merchant_data = $this->merchant;
            $claims['merchant'] = $merchant_data;
            $claims['location'] = $merchant_data->location;
            return $claims;
        }
    }
}