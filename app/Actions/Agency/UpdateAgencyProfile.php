<?php

namespace App\Actions\Agency;
use App\Exceptions\AgencyException;
use App\Http\Requests\UpdateAgencyProfileRequest;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;



class UpdateAgencyProfile{
    use AsAction;

    // email verification not yet implemented
    public function handle(UpdateAgencyProfileRequest $request):JsonResponse{
        /* @var $user User */
        $user = auth()->user();
        //check if we have currently authenticated user
        if (is_null($user)){
            throw new AgencyException("User does not exist in the server", 404);
        }
        //updates user profile
        try{
            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
            $user->email = $request->email;
            $user->save();
            return response()->json([
                'message' => 'user profile has been successfully updated',
                'success' => true
            ]);
        }catch(Throwable $th){
            throw new AgencyException($th->getMessage(), $th->getCode());
        }
    }
}
