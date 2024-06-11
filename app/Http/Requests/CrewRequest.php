<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'financial_number' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'license_number' => 'nullable|string|max:255',
            'job_id' => 'required|exists:jobs,id',
            'job_type' => 'required|exists:job_types,id',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'financial_number.required' => 'الرقم المالي مطلوب.',
            'financial_number.string' => 'الرقم المالي يجب أن يكون نصاً.',
            'financial_number.max' => 'الرقم المالي يجب ألا يتجاوز 255 حرفاً.',

            'first_name.required' => 'الاسم الأول مطلوب.',
            'first_name.string' => 'الاسم الأول يجب أن يكون نصاً.',
            'first_name.max' => 'الاسم الأول يجب ألا يتجاوز 255 حرفاً.',

            'last_name.required' => 'الاسم الأخير مطلوب.',
            'last_name.string' => 'الاسم الأخير يجب أن يكون نصاً.',
            'last_name.max' => 'الاسم الأخير يجب ألا يتجاوز 255 حرفاً.',

            'nickname.string' => 'اللقب يجب أن يكون نصاً.',
            'nickname.max' => 'اللقب يجب ألا يتجاوز 255 حرفاً.',

            'date_of_birth.date' => 'تاريخ الميلاد يجب أن يكون تاريخاً صحيحاً.',

            'license_number.string' => 'رقم الرخصة يجب أن يكون نصاً.',
            'license_number.max' => 'رقم الرخصة يجب ألا يتجاوز 255 حرفاً.',

            'job_id.required' => 'المسمى الوظيفي مطلوب.',
            'job_id.exists' => 'المسمى الوظيفي غير موجود.',

            'job_type.required' => 'نوع الوظيفة مطلوب.',
            'job_type.exists' => 'نوع الوظيفة غير موجود.',

            'status.required' => 'الحالة مطلوبة.',
            'status.in' => 'الحالة يجب أن تكون إما نشط أو غير نشط.',
        ];
    }
}
