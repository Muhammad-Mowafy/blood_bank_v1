<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class RegisterRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower(trim($this->email)),
            'username' => trim($this->username),
            'phone' => preg_replace('/\s+/', '', $this->phone),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:100',
            'username' => 'bail|required|string|alpha_num|max:100|unique:clients,username',
            'email' => 'bail|required|email:rfc,dns|max:150|unique:clients,email',
            'password' => [
                'bail',
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'phone' => 'bail|required|string|max:20|unique:clients,phone|regex:/^\+?[0-9]{10,20}$/',
            'dob' => 'nullable|date',
            'last_date_of_donation' => 'nullable|date|before_or_equal:today',
            'blood_type_id'     => 'bail|required|exists:blood_types,id',
            'city_id'           => 'bail|required|exists:cities,id',
        ];
    }

    public function messages(): array
    {
        return [
            // الاسم
            'name.required' => 'الاسم مطلوب.',
            'name.string'   => 'الاسم يجب أن يكون نصاً.',
            'name.max'      => 'الاسم لا يجب أن يتعدى 100 حرف.',

            // اسم المستخدم
            'username.required'  => 'اسم المستخدم مطلوب.',
            'username.string'    => 'اسم المستخدم يجب أن يكون نصاً.',
            'username.alpha_num' => 'اسم المستخدم يجب أن يحتوي على حروف وأرقام فقط.',
            'username.max'       => 'اسم المستخدم لا يجب أن يتعدى 100 حرف.',
            'username.unique'    => 'اسم المستخدم مستخدم بالفعل.',

            // البريد الإلكتروني
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email'    => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.max'      => 'البريد الإلكتروني لا يجب أن يتعدى 150 حرف.',
            'email.unique'   => 'البريد الإلكتروني مستخدم بالفعل.',

            // كلمة المرور
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min'       => 'كلمة المرور يجب ألا تقل عن 8 أحرف.',
            'password.letters'   => 'كلمة المرور يجب أن تحتوي على أحرف.',
            'password.mixed'     => 'كلمة المرور يجب أن تحتوي على أحرف كبيرة وصغيرة.',
            'password.numbers'   => 'كلمة المرور يجب أن تحتوي على أرقام.',
            'password.symbols'   => 'كلمة المرور يجب أن تحتوي على رموز.',
            'password.uncompromised' => 'كلمة المرور غير آمنة، جرب كلمة مرور أخرى.',

            // رقم الهاتف
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string'   => 'رقم الهاتف يجب أن يكون نصاً.',
            'phone.max'      => 'رقم الهاتف لا يجب أن يتعدى 20 رقم.',
            'phone.unique'   => 'رقم الهاتف مستخدم بالفعل.',
            'phone.regex'    => 'صيغة رقم الهاتف غير صحيحة، يجب أن يكون رقم دولي صحيح.',

            // تاريخ الميلاد
            'dob.date'   => 'تاريخ الميلاد غير صحيح.',
            'dob.before' => 'يجب أن يكون العمر 18 سنة على الأقل.',

            // آخر تاريخ تبرع
            'last_date_of_donation.date' => 'تاريخ آخر تبرع غير صحيح.',
            'last_date_of_donation.before_or_equal' => 'تاريخ آخر تبرع يجب أن يكون اليوم أو قبله.',

            // فصيلة الدم
            'blood_type_id.required' => 'فصيلة الدم مطلوبة.',
            'blood_type_id.exists'   => 'فصيلة الدم غير صحيحة.',

            // المدينة
            'city_id.required' => 'المدينة مطلوبة.',
            'city_id.exists'   => 'المدينة غير صحيحة.',
        ];
    }

}
