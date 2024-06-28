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
            'departure_flight_number' => 'required|string|max:200|unique:flights,flight_number',
            'departure_flight_date' => 'required|date',
            'departure_aircraft_id' => 'required|exists:aircrafts,id',
            'departure_origin_airport_id' => 'required|exists:airports,id',
            'departure_destination_airport_id' => 'required|exists:airports,id',
            'departure_departure_time' => 'required|date_format:H:i',
            'departure_arrival_time' => 'required|date_format:H:i|after:departure_departure_time',
            'departure_flight_type' => 'required|in:normal_flight,simulated_flight,unloaded_flight,airplane_test',
            'departure_aircraft_number' => 'required|string|max:200',
            'return_flight_number' => 'required|string|max:200|unique:flights,flight_number',
            'return_flight_date' => 'required|date',
            'return_aircraft_id' => 'required|exists:aircrafts,id',
            'return_origin_airport_id' => 'required|exists:airports,id',
            'return_destination_airport_id' => 'required|exists:airports,id',
            'return_departure_time' => 'required|date_format:H:i',
            'return_arrival_time' => 'required|date_format:H:i|after:return_departure_time',
            'return_flight_type' => 'required|in:normal_flight,simulated_flight,unloaded_flight,airplane_test',
            'return_aircraft_number' => 'required|string|max:200',
            'job_id' => 'required|array|exists:jobs,id',
            'crew_id' => 'required|array|exists:crews,id',
        ];
    }
    public function messages(): array
    {
        return [
            'departure_flight_number.required' => 'رقم الرحله مطلوب.',
            'departure_flight_number.max' => 'رقم الرحلة يجب ألا يزيد عن 200 حرف.',
            'departure_flight_number.unique' => 'رقم الرحلة موجود بالفعل.',
            'departure_flight_date.required' => 'تاريخ الرحلة مطلوب.',
            'departure_flight_date.date' => 'تاريخ الرحلة يجب أن يكون تاريخ صحيح.',
            'departure_aircraft_id.required' => 'اسم الطائرة مطلوب.',
            'departure_aircraft_id.exists' => 'الطائرة غير صالح.',
            'departure_origin_airport_id.required' => 'مطار القيام مطلوب',
            'departure_origin_airport_id.exists' => 'مطار القيام هذا غير صالح.',
            'departure_destination_airport_id.required' => 'مطار الوصول مطلوب.',
            'departure_destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'departure_departure_time.required' => 'وقت المغادرة مطلوب.',
            'departure_departure_time.date_format' => 'وقت المغادرة يجب أن يكون في صيغة ساعات ودقائق.',
            'departure_arrival_time.required' => 'وقت الوصول مطلوب.',
            'departure_arrival_time.date_format' => 'وقت الوصول يجب أن يكون في صيغة ساعات ودقائق.',
            'departure_arrival_time.after' => 'وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'departure_flight_type.required' => 'نوع الرحلة مطلوب.',
            'departure_flight_type.in' => 'نوع الرحلة غير صالح.',
            'departure_aircraft_number.required' => 'رقم الطائرة مطلوب.',
            'departure_aircraft_number.max' => 'رقم الطائرة يجب ألا يزيد عن 200 حرف.',
            'return_flight_number.required' => 'رقم الرحله مطلوب.',
            'return_flight_number.max' => 'رقم الرحلة يجب ألا يزيد عن 200 حرف.',
            'return_flight_number.unique' => 'رقم الرحلة موجود بالفعل.',
            'return_flight_date.required' => 'تاريخ الرحلة مطلوب.',
            'return_flight_date.date' => 'تاريخ الرحلة يجب أن يكون تاريخ صحيح.',
            'return_aircraft_id.required' => 'اسم الطائرة مطلوب.',
            'return_aircraft_id.exists' => 'الطائرة غير صالح.',
            'return_origin_airport_id.required' => 'مطار القيام مطلوب',
            'return_origin_airport_id.exists' => 'مطار القيام هذا غير صالح.',
            'return_destination_airport_id.required' => 'مطار الوصول مطلوب.',
            'return_destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'return_departure_time.required' => 'وقت المغادرة مطلوب.',
            'return_departure_time.date_format' => 'وقت المغادرة يجب أن يكون في صيغة ساعات ودقائق.',
            'return_arrival_time.required' => 'وقت الوصول مطلوب.',
            'return_arrival_time.date_format' => 'وقت الوصول يجب أن يكون في صيغة ساعات ودقائق.',
            'return_arrival_time.after' => 'وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'return_flight_type.required' => 'نوع الرحلة مطلوب.',
            'return_flight_type.in' => 'نوع الرحلة غير صالح.',
            'return_aircraft_number.required' => 'رقم الطائرة مطلوب.',
            'return_aircraft_number.max' => 'رقم الطائرة يجب ألا يزيد عن 200 حرف.',
            'job_id.required' => 'اختر وظيفة أولاً.',
            'job_id.exists' => 'هذه الوظيفة غير صالحة.',
            'job_id.array' => 'يجب أن تختار مجموعة من الوظائف.',
            'crew_id.required' => 'اختر الموظف أولاً.',
            'crew_id.exists' => 'هذا الموظف غير صالح.',
            'crew_id.array' => 'يجب أن تختار مجموعة من الموظفين.',
        ];
    }
}
