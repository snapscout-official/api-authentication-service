<?php

namespace App\Actions\Agency;

use App\Http\Requests\Agency\AgencyRegisterRequest;
use App\Models\Agency\AgencyCategory;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAgencyCredentials
{
    use AsAction;
    public function handle(AgencyRegisterRequest $request): User
    {
        try {
            DB::beginTransaction();
            $date = Carbon::parse($request->dateOfBirth);
            $user = User::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'birth_date' => $date,
                'tin_number' => $request->tinNumber,
                'gender' => $request->gender,
                'phone_number' => $request->contactNumber,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => Role::AGENCY
            ]);

            $location = Location::create([
                'building_name' => $request->buildingName,
                'street' => $request->street,
                'barangay' => $request->barangay,
                'city' => $request->city,
                'province' => $request->province,
                'country' => $request->country,
            ]);
            $agencyCategory = AgencyCategory::create([
                'agency_category_name' => $request->agencyCategory
            ]);

            $agency = $user->agency()->create([
                'agency_name' => $request->agency,
                'position' => $request->position,
                'location_id' => $location->location_id,
                'category_id' => $agencyCategory->id,
            ]);
            DB::commit();

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return null;
            }

            event(new Registered($user));
            return $user;

        } catch (\Throwable $e) {

            return response()->json([
                'error' => 'something went wrong'
            ], 422);
        }


    }
}
