<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Update this to return true to authorize the request
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
            'aircraft_id' => 'required|exists:aircrafts,id',
            'origin_airport_id' => 'required|exists:airports,id',
            'destination_airport_id' => 'required|exists:airports,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'flight_code' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'aircraft_id.required' => 'حقل الطائرة مطلوب.',
            'aircraft_id.exists' => ' الطائرة غير صالح.',
            'origin_airport_id.required' => '  مطار القيام مطلوب',
            'origin_airport_id.exists' => ' مطار القيام هذا غير صالح.',
            'destination_airport_id.required' => 'مطار الوصول  مطلوب.',
            'destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'departure_time.required' => ' وقت المغادرة مطلوب.',
            'departure_time.date' => ' وقت المغادرة يجب أن يكون تاريخ صحيح.',
            'arrival_time.required' => ' وقت الوصول مطلوب.',
            'arrival_time.date' => ' وقت الوصول يجب أن يكون تاريخ صحيح.',
            'arrival_time.after' => ' وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'flight_code.required' => ' رمز الرحلة مطلوب.',
            'flight_code.string' => ' رمز الرحلة يجب أن يكون نص.',
            'flight_code.max' => ' رمز الرحلة يجب ألا يزيد عن 255 حرف.',
        ];
    }
}
