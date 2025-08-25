<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ApiResponse;

    public function show()
    {
        return $this->apiDataResponse(
            Auth::user(),
            'Profile fetched successfully'
        );
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->only([
            'name',
            'username',
            'email',
            'password',
            'phone',
            'dob',
            'last_date_of_donation',
            'blood_type_id',
            'city_id',
        ]);

        $user->update($data);

        return $this->apiDataResponse(
            $user,
            'Profile updated successfully'
        );
    }

}
