<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\traits\ApiResponse;

class BaseRequest extends FormRequest
{
    use ApiResponse;

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->apiErrorResponse(
                'Validation Error',
                $validator->errors()->toArray(),
                422
            )
        );
    }

        protected function failedAuthorization()
    {
        throw new HttpResponseException(
            $this->apiErrorResponse(
                'This action is unauthorized.',
                [],
                403
            )
        );
    }

}
