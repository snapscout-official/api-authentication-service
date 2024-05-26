<?php

namespace App\Http\Requests\Agency;

use Illuminate\Foundation\Http\FormRequest;

class AgencyRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'dateOfBirth' => 'required',
            'tinNumber' => 'required|unique:users,tin_number',
            'gender' => 'required',
            'contactNumber' => 'required|unique:users,phone_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'agency' => 'required',
            'buildingName' => 'required',
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'agencyCategory' => 'required',
            'position' => 'required'
        ];
    }
}
