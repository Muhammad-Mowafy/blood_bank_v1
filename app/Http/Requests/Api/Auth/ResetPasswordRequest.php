<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            'phone' => ['bail','required', 'string', 'regex:/^\+?[0-9]{8,15}$/'],
            'verification_code' => ['bail','required', 'digits:6'],
            'password' => [
                'bail',
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            // رقم الهاتف
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string'   => 'رقم الهاتف يجب أن يكون نصاً.',
            'phone.regex'    => 'رقم الهاتف غير صحيح، يجب أن يكون بالصيغة الدولية.',

            // كود التحقق
            'verification_code.required' => 'كود التحقق مطلوب.',
            'verification_code.digits'   => 'كود التحقق يجب أن يتكون من 6 أرقام.',

            // كلمة المرور
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.string'    => 'كلمة المرور يجب أن تكون نصاً.',
            'password.min'       => 'كلمة المرور يجب ألا تقل عن 8 أحرف.',
            'password.letters'   => 'كلمة المرور يجب أن تحتوي على أحرف.',
            'password.mixed'     => 'كلمة المرور يجب أن تحتوي على أحرف كبيرة وصغيرة.',
            'password.numbers'   => 'كلمة المرور يجب أن تحتوي على أرقام.',
            'password.symbols'   => 'كلمة المرور يجب أن تحتوي على رموز.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ];
    }
}
