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
            'aircraft_id' => 'required|exists:aircrafts,id',
            'flight_number' => 'required|numeric',
            'flight_date' => 'required|date|after_or_equal:today',
            'door_closed_at' => 'required|date_format:H:i',
            'departure_time' => 'required|date_format:H:i|after:door_closed_at',
            'landing_time' => 'required|date_format:H:i|after:departure_time',
            'door_opened_at' => 'required|date_format:H:i|after:landing_time',
            'arrival_time' => 'required|date_format:H:i|after:door_opened_at',
            'job_id.*' => 'required|exists:jobs,id',
            'crew_id.*' => 'required|exists:crews,id',
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
            'origin_airport_id.required' => 'يرجى اختيار مطار المغادرة',
            'destination_airport_id.required' => 'يرجى اختيار مطار الوصول',
            'destination_airport_id.different' => 'مطار الوصول يجب أن يكون مختلفاً عن مطار المغادرة',
            'aircraft_id.required' => 'يرجى اختيار الطائرة',
            'flight_number.required' => 'يرجى إدخال رقم الرحلة',
            'flight_date.required' => 'يرجى إدخال تاريخ الرحلة',
            'door_closed_at.required' => 'يرجى إدخال وقت إغلاق الباب',
            'departure_time.required' => 'يرجى إدخال وقت الإقلاع',
            'landing_time.required' => 'يرجى إدخال وقت الهبوط',
            'door_opened_at.required' => 'يرجى إدخال وقت فتح الباب',
            'arrival_time.required' => 'يرجى إدخال وقت الوصول',
            'job_id.*.required' => 'يرجى اختيار وظيفة لكل طاقم',
            'crew_id.*.required' => 'يرجى اختيار موظف لكل طاقم',
        ];
    }
}

