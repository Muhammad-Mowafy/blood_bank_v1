<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'login' => trim($this->login),
        ]);
    }

    public function rules(): array
    {
        return [
            'login' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:30',
            ],
            'password' => [
                'bail',
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // حقل تسجيل الدخول
            'login.required' => 'حقل تسجيل الدخول مطلوب.',
            'login.string'   => 'حقل تسجيل الدخول يجب أن يكون نصاً.',
            'login.min'      => 'حقل تسجيل الدخول يجب أن يكون 3 أحرف على الأقل.',
            'login.max'      => 'حقل تسجيل الدخول لا يجب أن يتعدى 30 حرف.',

            // كلمة المرور
            'password.required'       => 'كلمة المرور مطلوبة.',
            'password.string'         => 'كلمة المرور يجب أن تكون نصاً.',
            'password.min'            => 'كلمة المرور يجب ألا تقل عن 8 أحرف.',
            'password.letters'        => 'كلمة المرور يجب أن تحتوي على أحرف.',
            'password.mixedCase'      => 'كلمة المرور يجب أن تحتوي على أحرف كبيرة وصغيرة.',
            'password.numbers'        => 'كلمة المرور يجب أن تحتوي على أرقام.',
            'password.symbols'        => 'كلمة المرور يجب أن تحتوي على رموز.',
            'password.uncompromised'  => 'كلمة المرور غير آمنة، جرب كلمة مرور أخرى.',
        ];
    }

}
