<?php

namespace App\Http\Requests;

use App\Rules\UniqueFinancialNumber;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFlightRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'departure_flight_number' => 'required|string|max:200',
            'departure_flight_date' => 'required|date',
            'departure_aircraft_id' => 'required|exists:aircrafts,id',
            'departure_origin_airport_id' => 'required|exists:airports,id',
            'departure_destination_airport_id' => 'required|exists:airports,id|different:departure_origin_airport_id',
            'departure_departure_time' => 'required|date_format:H:i',
            'departure_arrival_time' => 'required|date_format:H:i|after:departure_departure_time',
            'departure_aircraft_number' => 'required|string|max:200',
            'return_flight_number' => 'required|string|max:200',
            'return_flight_date' => 'required|date',
            'return_aircraft_id' => 'required|exists:aircrafts,id',
            'return_origin_airport_id' => 'required|exists:airports,id',
            'return_destination_airport_id' => 'required|exists:airports,id|different:return_origin_airport_id',
            'return_departure_time' => 'required|date_format:H:i',
            'return_arrival_time' => 'required|date_format:H:i|after:return_departure_time',
            'return_aircraft_number' => 'required|string|max:200',
            'financial_number' => ['required', 'array', 'exists:crews,financial_number', new UniqueFinancialNumber],
            'job_id' => ['required', 'array'],
            'job_id.*' => ['required', 'exists:jobs,id'],
        ];
    }

    public function messages()
    {
        return [
            'departure_flight_number.required' => 'رقم رحلة الذهاب مطلوب.',
            'departure_flight_number.max' => 'رقم الرحلة يجب ألا يزيد عن 200 حرف.',
            'departure_flight_date.required' => 'تاريخ رحلة الذهاب مطلوب.',
            'departure_flight_date.date' => 'تاريخ الرحلة يجب أن يكون تاريخ صحيح.',
            'departure_aircraft_id.required' => 'اسم الطائرة مطلوب.',
            'departure_aircraft_id.exists' => 'الطائرة غير صالحة.',
            'departure_origin_airport_id.required' => 'مطار القيام مطلوب',
            'departure_origin_airport_id.exists' => 'مطار القيام هذا غير صالح.',
            'departure_destination_airport_id.required' => 'مطار الوصول مطلوب.',
            'departure_destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'departure_destination_airport_id.different' => 'قم باختيار مطار وصول مختلف',
            'departure_departure_time.required' => 'وقت المغادرة مطلوب.',
            'departure_departure_time.date_format' => 'وقت المغادرة يجب أن يكون في صيغة ساعات ودقائق.',
            'departure_arrival_time.required' => 'وقت الوصول مطلوب.',
            'departure_arrival_time.date_format' => 'وقت الوصول يجب أن يكون في صيغة ساعات ودقائق.',
            'departure_arrival_time.after' => 'وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'departure_aircraft_number.required' => 'رقم الطائرة مطلوب.',
            'departure_aircraft_number.max' => 'رقم الطائرة يجب ألا يزيد عن 200 حرف.',
            'return_flight_number.required' => 'رقم رحلة العودة مطلوب.',
            'return_flight_number.max' => 'رقم الرحلة يجب ألا يزيد عن 200 حرف.',
            'return_flight_date.required' => 'تاريخ رحلة العودة مطلوب.',
            'return_flight_date.date' => 'تاريخ الرحلة يجب أن يكون تاريخ صحيح.',
            'return_aircraft_id.required' => 'اسم الطائرة مطلوب.',
            'return_aircraft_id.exists' => 'الطائرة غير صالحة.',
            'return_origin_airport_id.required' => 'مطار القيام مطلوب',
            'return_origin_airport_id.exists' => 'مطار القيام هذا غير صالح.',
            'return_destination_airport_id.required' => 'مطار الوصول مطلوب.',
            'return_destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'return_destination_airport_id.different' => 'قم باختيار مطار وصول مختلف',
            'return_departure_time.required' => 'وقت المغادرة مطلوب.',
            'return_departure_time.date_format' => 'وقت المغادرة يجب أن يكون في صيغة ساعات ودقائق.',
            'return_arrival_time.required' => 'وقت الوصول مطلوب.',
            'return_arrival_time.date_format' => 'وقت الوصول يجب أن يكون في صيغة ساعات ودقائق.',
            'return_arrival_time.after' => 'وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'return_aircraft_number.required' => 'رقم الطائرة مطلوب.',
            'return_aircraft_number.max' => 'رقم الطائرة يجب ألا يزيد عن 200 حرف.',
            'financial_number.required' => 'اختر الرقم المالي أولاً.',
            'financial_number.exists' => 'هذا الرقم المالي غير صالح.',
            'financial_number.array' => 'يجب أن تختار مجموعة من الارقام المالية.',
            'job_id.required' => 'اختر الوظيفة لكل فرد طاقم.',
            'job_id.array' => 'يجب أن تختار مجموعة من الوظائف.',
            'job_id.*.required' => 'الوظيفة مطلوبة لكل فرد طاقم.',
            'job_id.*.exists' => 'الوظيفة المحددة غير صالحة.',
        ];
    }
}
