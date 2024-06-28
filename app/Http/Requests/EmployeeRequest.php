<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'name' =>['string','max:200'],
        'email' =>['email','unique:users,email','max:200'],
        'password' => ['int','min:6','max:16'],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 200 حرف.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صحيحًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني 200 حرف.',
            'password.int' => 'يجب أن تكون كلمة المرور رقمية.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 6 أرقام.',
            'password.max' => 'يجب ألا تزيد كلمة المرور عن 16 رقم.',
        ];
    }
}
