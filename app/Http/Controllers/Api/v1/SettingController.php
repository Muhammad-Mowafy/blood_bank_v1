<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $settings = Setting::first();

        if (!$settings) {
            return $this->apiErrorResponse('Settings not found', 404);
        }

        return $this->apiSuccessResponse($settings, 'Settings fetched successfully');
    }
}
