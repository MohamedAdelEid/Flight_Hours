<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change this as per your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'origin_airport_id' => 'required|exists:airports,id',
            'destination_airport_id' => 'required|exists:airports,id|different:origin_airport_id',
            'flight_date' => 'required|date',
            'aircraft_id' => 'required|exists:aircrafts,id',
            'flight_number' => 'required|integer',
            'aircraft_number' => 'required|integer',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'financial_number' => 'required|array|exists:crews,financial_number',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'origin_airport_id.required' => 'مطار القيام مطلوب.',
            'origin_airport_id.exists' => 'مطار القيام هذا غير صالح.',
            'destination_airport_id.required' => 'مطار الوصول مطلوب.',
            'destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'destination_airport_id.different' => 'قم باختيار مطار وصول مختلف عن مطار القيام.',
            'flight_date.required' => 'تاريخ الرحلة مطلوب.',
            'flight_date.date' => 'تاريخ الرحلة يجب أن يكون تاريخًا صحيحًا.',
            'aircraft_id.required' => 'رقم الطائرة مطلوب.',
            'aircraft_id.exists' => 'رقم الطائرة هذا غير صالح.',
            'flight_number.required' => 'رقم الرحلة مطلوب.',
            'flight_number.integer' => 'رقم الرحلة يجب أن يكون عددًا صحيحًا.',
            'aircraft_number.required' => 'رقم الطائرة مطلوب.',
            'aircraft_number.integer' => 'رقم الطائرة يجب أن يكون عددًا صحيحًا.',
            'departure_time.required' => 'وقت المغادرة مطلوب.',
            'departure_time.date_format' => 'وقت المغادرة يجب أن يكون بتنسيق HH:mm.',
            'arrival_time.required' => 'وقت الوصول مطلوب.',
            'arrival_time.date_format' => 'وقت الوصول يجب أن يكون بتنسيق HH:mm.',
            'arrival_time.after' => 'وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'financial_number.required' => 'الرقم المالي مطلوب.',
            'financial_number.exists' => 'رقم مالي غير صالح موجود.',
        ];
    }
}

