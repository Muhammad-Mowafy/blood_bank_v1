<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function apiResponse($success, $message = null, $data = null, $errors = null, $responseCode = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
            'errors'  => $errors,
        ], $responseCode);
    }

    public function apiDataResponse($data, $message = null)
    {
        return $this->apiResponse(true, $message, $data);
    }

    public function apiSuccessResponse($message, $data = null)
    {
        return $this->apiResponse(true, $message, $data);
    }

    public function apiErrorResponse($message, $errors = null, $responseCode = 400)
    {
        return $this->apiResponse(false, $message, null, $errors, $responseCode);
    }
}
