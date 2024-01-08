<?php

namespace App\Actions\Merchant;

use App\Models\Role;
use App\Models\User;
use App\Models\Location;
use App\Models\Merchant\Philgep;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Merchant\MerchantCategory;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Merchant\SignupRequest;

class CreateMerchantCredentials{
    use AsAction;

    public function handle(SignupRequest $request){
        DB::beginTransaction();

        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'birth_date' => $request->dateOfBirth,
            'tin_number' => $request->tinNumber,
            'gender' => $request->gender,
            'phone_number' => $request->phoneNumber,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::MERCHANT,
        ]);

        $location = Location::create([
            'building_name' => $request->building,
            'street' => $request->street,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'country' => $request->country
        ]);

        $category = MerchantCategory::create([
            'merchant_name' => $request->category,
        ]);
        $philgeps = Philgep::create([
            'type' => $request->philgeps
        ]);
        $user->merchant()->create([
            'business_name' => $request->businessName,
            'location_id' => $location->location_id,
            'category_id' => $category->id,
            'philgeps_id' => $philgeps->id,
        ]);

        DB::commit();
        return $user;
    }
}