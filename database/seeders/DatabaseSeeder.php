<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Agency\AgencyCategory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // $roles = ['merchant', 'agency', 'admin'];
        // foreach($roles as $role) {
        //     Role::create([
        //         'role_name' => $role
        //     ]);
        // }
        $date = Carbon::createFromFormat('F j, Y', 'March 21, 2002')
        ->format('Y-m-d');
        // $adminUser = User::create([
        //     'first_name' => 'Mary',
        //     'last_name' => 'Soliva',
        //     'birth_date' => $date,
        //     'tin_number' => '4411233',
        //     'gender' => 'Female',
        //     'phone_number' => '09338603326',
        //     'email' => 'mary.soliva@carsu.edu.ph',
        //     'password' => Hash::make('starmovies3144'),
        //     'role_id' => Role::ADMIN]);
        $agencyUser = User::create([
          'first_name' => 'Klinth',
          'last_name' => 'Matugas',
          'birth_date' => $date,
          'tin_number' => '12313130',
          'gender' => 'Male',
          'phone_number' => '09918804162',
          'email' => 'klinth.matugas@carsu.edu.ph',
          'password' => Hash::make('test'),
          'role_id' => Role::AGENCY
        ]);
        $location = Location::create([
           'building_name' => 'SM',
           'street' => 'Zacor',
           'barangay' => 'Zacor',
           'city' => 'Butuan City',
           'province' => 'Agusan Del Norte',
           'country' => 'Philippines'
        ]);
        $agencyCategory = AgencyCategory::create([
           'agency_category_name' => 'General Merchandise'
        ]);
        $agency = $agencyUser->agency()->create([
          'agency_name' => 'COA',
          'position' => 'GSO',
          'location_id' => $location->location_id,
          'category_id' => $agencyCategory->id
        ]);
    }
}
