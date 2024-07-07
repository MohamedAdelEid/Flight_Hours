<?php

namespace App\Http\Requests;

use App\Rules\UniqueFinancialNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreOtherFlightsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'airport_id' => 'required|integer|exists:airports,id',
            'aircraft_id' => 'required|exists:aircrafts,id',
            'flight_number' => 'required|string|max:255',
            'flight_date' => 'required|date',
            'training_start_at' => 'required|array',
            'training_start_at.*' => 'required|date_format:H:i',
            'training_end_at' => 'required|array',
            'training_end_at.*' => 'required|date_format:H:i|after:training_start_at.*',
            'financial_number' => ['required', 'array', 'exists:crews,financial_number', new UniqueFinancialNumber],
        ];
    }

    public function messages(): array
    {
        return [
            'airport_id.required' => 'اسم المطار مطلوب.',
            'airport_id.exists' => 'اسم المطار غير موجود.',
            'aircraft_id.required' => 'اسم الطائرة مطلوب.',
            'aircraft_id.exists' => 'اسم الطائرة غير موجود.',
            'flight_number.required' => 'رقم الرحلة مطلوب.',
            'flight_number.string' => 'رقم الرحلة يجب أن يكون نصاً.',
            'flight_number.max' => 'رقم الرحلة يجب ألا يتجاوز 255 حرفًا.',
            'flight_date.required' => 'تاريخ الرحلة مطلوب.',
            'flight_date.date' => 'تاريخ الرحلة يجب أن يكون تاريخًا صحيحًا.',
            'training_start_at.required' => 'وقت بداية التدريب مطلوب.',
            'training_start_at.date_format' => 'وقت بداية التدريب يجب أن يكون في صيغة ساعات ودقائق.',
            'training_start_at.array' => 'يجب أن تختار مجموعة من المواعيد.',
            'training_end_at.required' => 'وقت نهاية التدريب مطلوب.',
            'training_end_at.array' => 'يجب أن تختار مجموعة من المواعيد.',
            'training_end_at.date_format' => 'وقت نهاية التدريب يجب أن يكون في صيغة ساعات ودقائق.',
            'training_end_at.after' => 'وقت نهاية التدريب يجب أن يكون بعد وقت بداية التدريب.',
            'financial_number.required' => 'اختر الرقم المالي أولاً.',
            'financial_number.exists' => 'هذا الرقم المالي غير صالح.',
            'financial_number.array' => 'يجب أن تختار مجموعة من الأرقام المالية.',
        ];
    }

}
