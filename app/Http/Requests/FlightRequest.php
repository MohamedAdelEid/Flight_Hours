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
            'departure_landing_time' => 'required|date_format:H:i',
            'departure_arrival_time' => 'required|date_format:H:i|after:departure_time',
            'departure_door_closed_at' => 'required|date_format:H:i',
            'departure_door_opened_at' => 'required|date_format:H:i|after:door_closed_at',
            'return_flight_number' => 'required|string|max:200|unique:flights,flight_number',
            'return_flight_date' => 'required|date',
            'return_aircraft_id' => 'required|exists:aircrafts,id',
            'return_origin_airport_id' => 'required|exists:airports,id',
            'return_destination_airport_id' => 'required|exists:airports,id',
            'return_departure_time' => 'required|date_format:H:i',
            'return_landing_time' => 'required|date_format:H:i',
            'return_arrival_time' => 'required|date_format:H:i|after:departure_time',
            'return_door_closed_at' => 'required|date_format:H:i',
            'return_door_opened_at' => 'required|date_format:H:i|after:door_closed_at',
            'job_id' => 'required|array|exists:jobs,id',
            'crew_id' => 'required|array|exists:crews,id',
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
            'departure_flight_number.required' => ' رقم الرحله مطلوب.',
            'departure_flight_number.max' => 'رقم الرحلة يجب ألا يزيد عن 200 حرف.',
            'departure_flight_number.unique' => 'رقم الرحلة موجود بالفعل.',
            'departure_flight_date.required' => ' تاريخ الرحلة مطلوب.',
            'departure_flight_date.date' => '  تاريخ الرحلة يجب أن يكون تاريخ صحيح.',
            'departure_aircraft_id.required' => ' اسم الطائرة مطلوب.',
            'departure_aircraft_id.exists' => ' الطائرة غير صالح.',
            'departure_origin_airport_id.required' => '  مطار القيام مطلوب',
            'departure_origin_airport_id.exists' => ' مطار القيام هذا غير صالح.',
            'departure_destination_airport_id.required' => 'مطار الوصول  مطلوب.',
            'departure_destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'departure_departure_time.required' => ' وقت المغادرة مطلوب.',
            'departure_departure_time.date_format' => ' وقت المغادرة يجب أن يكون في صيغة ساعات و دقائق.',
            'departure_landing_time.required' => ' وقت الهبوط مطلوب.',
            'departure_landing_time.date_format' => ' وقت الهبوط يجب أن يكون في صيغة ساعات و دقائق.',
            'departure_arrival_time.required' => ' وقت الوصول مطلوب.',
            'departure_arrival_time.date_format' => ' وقت الوصول يجب أن يكون في صيغة صيغة ساعات و دقائق.',
            'departure_arrival_time.after' => ' وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'departure_door_closed_at.required' => ' وقت إغلاق الباب مطلوب.',
            'departure_door_closed_at.date_format' => ' وقت إغلاق الباب يجب أن يكون في صيغة صيغة ساعات و دقائق.',
            'departure_door_opened_at.required' => ' وقت فتح الباب مطلوب.',
            'departure_door_opened_at.date_format' => ' وقت فتح الباب يجب أن يكون في صيغةصيغة ساعات و دقائق.',
            'departure_door_opened_at.after' => ' وقت فتح الباب  يجب أن يكون بعد وقت غلق الباب .',
            'return_flight_number.required' => ' رقم الرحله مطلوب.',
            'return_flight_number.max' => 'رقم الرحلة يجب ألا يزيد عن 200 حرف.',
            'return_flight_number.unique' => 'رقم الرحلة موجود بالفعل.',
            'return_flight_date.required' => ' تاريخ الرحلة مطلوب.',
            'return_flight_date.date' => '  تاريخ الرحلة يجب أن يكون تاريخ صحيح.',
            'return_aircraft_id.required' => ' اسم الطائرة مطلوب.',
            'return_aircraft_id.exists' => ' الطائرة غير صالح.',
            'return_origin_airport_id.required' => '  مطار القيام مطلوب',
            'return_origin_airport_id.exists' => ' مطار القيام هذا غير صالح.',
            'return_destination_airport_id.required' => 'مطار الوصول  مطلوب.',
            'return_destination_airport_id.exists' => 'مطار الوصول هذا غير صالح.',
            'return_departure_time.required' => ' وقت المغادرة مطلوب.',
            'return_departure_time.date_format' => ' وقت المغادرة يجب أن يكون في صيغة ساعات و دقائق.',
            'return_landing_time.required' => ' وقت الهبوط مطلوب.',
            'return_landing_time.date_format' => ' وقت الهبوط يجب أن يكون في صيغة ساعات و دقائق.',
            'return_arrival_time.required' => ' وقت الوصول مطلوب.',
            'return_arrival_time.date_format' => ' وقت الوصول يجب أن يكون في صيغة صيغة ساعات و دقائق.',
            'return_arrival_time.after' => ' وقت الوصول يجب أن يكون بعد وقت المغادرة.',
            'return_door_closed_at.required' => ' وقت إغلاق الباب مطلوب.',
            'return_door_closed_at.date_format' => ' وقت إغلاق الباب يجب أن يكون في صيغة صيغة ساعات و دقائق.',
            'return_door_opened_at.required' => ' وقت فتح الباب مطلوب.',
            'return_door_opened_at.date_format' => ' وقت فتح الباب يجب أن يكون في صيغةصيغة ساعات و دقائق.',
            'return_door_opened_at.after' => ' وقت فتح الباب  يجب أن يكون بعد وقت غلق الباب .',
            'job_id.required' => 'اختر وظيفة اولا ',
            'job_id.exists' => 'هذه الوظيفة غير صالحه',
            'job_id.array' => 'يجب ان تختار مجموعة من الوظائف',
            'crew_id.required' => 'اختر الموظف اولا',
            'crew_id.exists' => 'هذه الموظف غير صالحه',
            'crew_id.array' => 'يجب ان تختار مجموعة من الموظفين',
        ];
    }
}
