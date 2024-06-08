<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AircraftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'aircraft_name' => ['required', 'string', 'max:255'],
            'aircraft_code' => ['required', 'string', 'max:255'],
            'manufacturer' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive,maintenance'],
            'registration_number' => ['nullable', 'string', 'max:20', 'unique:aircrafts,registration_number'],
        ];
    }
    public function messages()
    {
        return [
            'aircraft_name.required' => 'حقل اسم الطائرة مطلوب.',
            'aircraft_name.string' => 'يجب أن يكون اسم الطائرة نصًا.',
            'aircraft_name.max' => 'قد لا يكون اسم الطائرة أكبر من 255 حرفًا.',
            'aircraft_code.required' => 'حقل رمز الطائرة مطلوب.',
            'aircraft_code.string' => 'يجب أن يكون رمز الطائرة نصًا.',
            'aircraft_code.max' => 'قد لا يكون رمز الطائرة أكبر من 255 حرفًا.',
            'manufacturer.required' => 'حقل اسم الصانع مطلوب.',
            'manufacturer.string' => 'يجب أن يكون اسم الصانع نصًا.',
            'manufacturer.max' => 'قد لا يكون اسم الصانع أكبر من 255 حرفًا.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'يجب أن تكون الحالة إما "نشطة" أو "غير نشطة" أو "صيانة".',
            'registration_number.string' => 'يجب أن يكون رقم التسجيل نصًا.',
            'registration_number.max' => 'قد لا يكون رقم التسجيل أكبر من 20 حرفًا.',
            'registration_number.unique' => 'رقم التسجيل مستخدم بالفعل.',
        ];
    }
}

