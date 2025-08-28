<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'facebook_url'  => 'nullable|url|max:255',
            'twitter_url'   => 'nullable|url|max:255',
            'youtube_url'   => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'about_app'     => 'nullable|string',
        ];
    }
}
