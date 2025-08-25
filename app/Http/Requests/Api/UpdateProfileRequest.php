<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseRequest
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
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:clients,username,' .$this->user()->id,
            'email' => 'sometimes|email|unique:clients,email,' . $this->user()->id,
            'password' => 'sometimes|string|min:6|confirmed',
            'phone' => 'sometimes|string|max:20|unique:clients,phone,' . $this->user()->id,
            'dob' => 'sometimes|date',
            'last_date_of_donation' => 'sometimes|date',
            'blood_type_id' => 'sometimes|exists:blood_types,id',
            'city_id' => 'sometimes|exists:cities,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'الاسم لازم يكون نص.',
            'name.max' => 'الاسم لا يمكن أن يتجاوز 255 حرف.',

            'username.string' => 'اسم المستخدم لازم يكون نص.',
            'username.max' => 'اسم المستخدم لا يمكن أن يتجاوز 255 حرف.',
            'username.unique' => 'اسم المستخدم مستخدم بالفعل.',

            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',

            'phone.string' => 'رقم الهاتف لازم يكون نص.',
            'phone.max' => 'رقم الهاتف لا يمكن أن يتجاوز 20 رقم.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',

            'dob.date' => 'تاريخ الميلاد يجب أن يكون تاريخ صالح.',
            'last_date_of_donation.date' => 'تاريخ آخر تبرع يجب أن يكون تاريخ صالح.',

            'blood_type_id.exists' => 'فصيلة الدم غير موجودة.',
            'city_id.exists' => 'المدينة غير موجودة.',
        ];
    }

}
