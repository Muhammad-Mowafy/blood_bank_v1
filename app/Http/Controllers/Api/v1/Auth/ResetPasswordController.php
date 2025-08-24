<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;

use App\Mail\SendResetPassword;
use App\Models\Client;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            // Find the client by phone number
            $client = Client::where('phone', $request->phone)->first();

            // Default response message for security (don't reveal if account exists or not)
            $responseMessage = 'If the account exists, a verification code was sent.';

            if ($client) {
                // Generate a random 6-digit verification code
                $code = random_int(100000, 999999);

                // Hash the verification code before saving it in the database
                $client->verification_code = Hash::make($code);

                // Set the expiration time for the verification code (15 minutes from now)
                $client->verification_code_expires_at = now()->addMinutes(15);

                // Save the client record with the new verification code and expiry time
                $client->save();

                // Send the verification code to the client's email
                Mail::to($client->email)->send(new  SendResetPassword($client, $code));
            }

            // Return success response regardless of whether the client exists
            return $this->apiSuccessResponse($responseMessage);

        } catch (\Exception $e) {
            // Catch any unexpected errors and return a general error response
            return $this->apiErrorResponse('Failed to send verification code. Please try again.', 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        // Get input values from the request
        $phone = $request->phone;
        $inputCode = $request->verification_code;
        $newPassword = $request->password;

        // Find the client by phone number
        $client = Client::where('phone', $phone)->first();

        // If client does not exist, return error
        if (!$client) {
            return $this->apiErrorResponse('Client not found', 404);
        };

        // Check if the verification code has expired
        if (now()->greaterThan($client->verification_code_expires_at)) {
            return $this->apiErrorResponse('Verification code expired', 422);
        };

        // Create a unique cache key for this client's password reset attempts
        $attemptsKey = 'password_reset_attempts_' . $client->id;

        // Get the number of failed attempts from cache, default to 0
        $attempts = Cache::get($attemptsKey, 0);

        // If the client exceeded maximum allowed attempts, return error
        if ($attempts >= 5) {
            return $this->apiErrorResponse('Too many attempts. Try again later.', 429);
        }

        // Check if the verification code entered by user is correct
        if (!Hash::check($inputCode, $client->verification_code)) {
            // Increase the number of failed attempts in cache and set expiration (15 minutes)
            Cache::put($attemptsKey, $attempts + 1, now()->addMinutes(15));
            return $this->apiErrorResponse('Invalid or expired verification code', 422);
        }

        // If verification code is correct, hash the new password and update it
        $client->password = Hash::make($newPassword);

        // Clear the verification code and its expiration date
        $client->verification_code = null;
        $client->verification_code_expires_at = null;

        // Save the updated client record in the database
        $client->save();

        // Return a success response
        return $this->apiSuccessResponse('Password has been reset successfully', []);
    }

}
































