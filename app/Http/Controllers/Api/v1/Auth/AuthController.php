<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Enums\ClientStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Traits\ApiResponse;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        // Use DB transaction to ensure data consistency
        return DB::transaction(function () use ($request) {
            // Create a new client record
            $client = Client::create([
                'name'          => $request->name,
                'username'      => $request->username,
                'email'         => $request->email,
                'password'      => $request->password,
                'dob'           => $request->dob,
                'phone'         => $request->phone,
                'blood_type_id' => $request->blood_type_id,
                'city_id'       => $request->city_id
            ]);

            // Generate API token for the client
            $token = $client->createToken('ApiToken')->plainTextToken;

            // Prepare data to return
            $data = [
                'client' => $client->only(['id', 'name', 'username', 'email', 'phone', 'dob', 'status']),
                'token'  => $token,
            ];

            // Return success response
            return $this->apiDataResponse($data, 'Registration Successful');
        });
    }

    public function login(LoginRequest $request)
    {
        $login = trim($request->login);
        $password = $request->password;

        // Find client by phone or username
        $client = Client::where('phone', $login)
            ->orWhere('username', $login)
            ->first();

        // Validate credentials and active status
        if (!$client || !Hash::check($password, $client->password) || $client->status !== ClientStatus::ACTIVE) {
            // General error message to avoid leaking sensitive info
            return $this->apiErrorResponse('Invalid credentials', 401);
        }

        // Generate API token
        $token = $client->createToken('ApiToken')->plainTextToken;

        // Prepare data to return
        $data = [
            'client' => $client->only(['id', 'name', 'username', 'email', 'phone', 'dob', 'status']),
            'token'  => $token,
        ];

        // Return success response
        return $this->apiDataResponse($data, 'Login Successful');
    }

}































































