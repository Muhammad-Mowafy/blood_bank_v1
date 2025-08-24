<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\City;
use App\Models\Governorate;
use App\traits\ApiResponse;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    use ApiResponse;

    public function bloodTypes()
    {
        $bloodTypes = BloodType::all();
        $data = [
            'bloodTypes' => $bloodTypes
        ];
        return $this->apiDataResponse($data);
    }

    public function governorates()
    {
        $governorates = Governorate::all();
        $data = [
            'governorates' => $governorates
        ];
        return $this->apiDataResponse($data);
    }

    public function cities(Request $request)
    {
        $cities = City::where(function ($query) use ($request) {
            if ($request->has('governorate_id')) {
                $query->where('governorate_id', $request->governorate_id);
            }
        })->get();
        $data = [
            'cities' => $cities
        ];
        return $this->apiDataResponse($data);
    }

}
