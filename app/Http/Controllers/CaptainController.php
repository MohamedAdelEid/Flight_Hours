<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\FlightHour;
use Illuminate\Http\Request;

class CaptainController extends Controller
{
    public function index(){
        $airports = Airport::all();
        $aircrafts = Aircraft::all();
        return view('captain.home', compact('airports', 'aircrafts'));
    }
    public function addNormalFlight(Request $request){
        $validatedData = $request->validate([
            // Departure Flight Validations
            'departure_origin_airport_id' => 'required|exists:airports,id',
            'departure_destination_airport_id' => 'required|exists:airports,id|different:departure_origin_airport_id',
            'departure_flight_date' => 'required|date',
            'departure_flight_number' => 'required|numeric',
            // Return Flight Validations
            'return_origin_airport_id' => 'nullable|exists:airports,id',
            'return_destination_airport_id' => 'nullable|exists:airports,id|different:return_origin_airport_id',
            'return_flight_date' => 'required|date|after:departure_flight_date',
            'return_flight_number' => 'required|numeric',
        ],
            [
            // Custom validation messages
            'departure_origin_airport_id.required' => 'مطلوب اختيار مطار المغادرة.',
            'departure_destination_airport_id.required' => 'مطلوب اختيار مطار الوصول.',
            'departure_flight_date.required' => 'مطلوب تحديد تاريخ الرحلة.',
            'departure_flight_date.after' => 'يجب أن يكون تاريخ الرحلة بعد اليوم.',
            'departure_flight_number.required' => 'مطلوب إدخال رقم الرحلة.',
            'departure_destination_airport_id.different' => 'يجب أن يكون مطار الوصول مختلفًا عن مطار المغادرة.',
            'return_destination_airport_id.different' => 'يجب أن يكون مطار الوصول مختلفًا عن مطار المغادرة.',
            'return_flight_date.after' => 'يجب ان يكون تاريخ رحلة العودة بعد تاريخ رحلة الذهاب'
        ]);
        $departureFlight = Flight::create([
            'flight_number' => $validatedData['departure_flight_number'],
            'flight_date' => $validatedData['departure_flight_date'],
            'origin_airport_id' => $validatedData['departure_origin_airport_id'],
            'destination_airport_id' => $validatedData['departure_destination_airport_id'],
            'user_id' => auth()->user()->id,
        ]);
        FlightHour::calcFlightHours($departureFlight);

        $returnFlight = Flight::create([
            'flight_number' => $validatedData['return_flight_number'],
            'flight_date' => $validatedData['return_flight_date'],
            'origin_airport_id' => $validatedData['return_origin_airport_id'],
            'destination_airport_id' => $validatedData['return_destination_airport_id'],
            'user_id' => auth()->user()->id,
        ]);
        FlightHour::calcFlightHours($returnFlight);

        if ($departureFlight && $returnFlight) {
            return redirect()->route('captain.home')->with('successCreate','تم اضافة الرحلة بنجاح');
        } else {
            return redirect()->route('captain.home')->with('error', 'حدث خطأ أثناء إضافة الرحلتين. الرجاء المحاولة مرة أخرى.');
        }
    }
}
