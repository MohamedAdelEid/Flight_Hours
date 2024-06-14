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
     * @return array
     */
    public function rules(): array
    {
        return [
            'flight_number' => 'required|string|max:200|unique:flights,flight_number',
            'flight_date' => 'required|date',
            'aircraft_id' => 'required|exists:aircrafts,id',
            'origin_airport_id' => 'required|exists:airports,id',
            'destination_airport_id' => 'required|exists:airports,id',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'door_closed_at' => 'required|date_format:H:i',
            'door_opened_at' => 'required|date_format:H:i|after:door_closed_at',
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
            'flight_number.required' => ' رقم الرحله مطلوب.',
            'flight_number.max' => 'رقم الرحلة يجب ألا يزيد عن 200 حرف.',
            'flight_number.unique' => 'رقم الرحلة موجود بالفعل.',
            'flight_date.required' => ' تاريخ الرحلة مطلوب.',
            'flight_date.date' => '  تاريخ الرحلة يجب أن يكون تاريخ صحيح.',
            'aircraft_id.required' => ' اسم الطائرة مطلوب.',
            'aircraft_id.exists' => ' الطائرة غير صالح.',
            'origin_airport_id.required' => '  مطار القيام مطلوب',
            'origin_airport_id.exists' => ' مطار القيام هذا غير صالح.',
            'destination_airport_id.required' => 'مطار الوصول  مطلوب.',
            'destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'departure_time.required' => ' وقت المغادرة مطلوب.',
            'departure_time.date_format' => ' وقت المغادرة يجب أن يكون في صيغة ساعات و دقائق.',
            'arrival_time.required' => ' وقت الوصول مطلوب.',
            'arrival_time.date_format' => ' وقت الوصول يجب أن يكون في صيغة صيغة ساعات و دقائق.',
            'arrival_time.after' => ' وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'door_closed_at.required' => ' وقت إغلاق الباب مطلوب.',
            'door_closed_at.date_format' => ' وقت إغلاق الباب يجب أن يكون في صيغة صيغة ساعات و دقائق.',
            'door_opened_at.required' => ' وقت فتح الباب مطلوب.',
            'door_opened_at.date_format' => ' وقت فتح الباب يجب أن يكون في صيغةصيغة ساعات و دقائق.',
            'door_opened_at.after' => ' وقت فتح الباب  يجب أن يكون بعد وقت غلق الباب .',
        ];
    }
}
