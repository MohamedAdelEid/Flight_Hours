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
    public function addSimulateFlight(Request $request){
        $validatedData = $request->validate([
            'aircraft_id' => 'required|exists:aircrafts,id',
            'flight_date' => 'required|date|after_or_equal:today',
            'flight_number' => 'required|numeric',
        ],
            [
            'aircraft_id.required' => 'مطلوب اختيار الطائرة.',
            'aircraft_id.exists' => 'الطائرة المختارة غير موجودة.',
            'flight_date.required' => 'مطلوب تحديد تاريخ الرحلة.',
            'flight_date.after_or_equal' => 'يجب أن يكون تاريخ الرحلة في اليوم الحالي أو في المستقبل.', 'flight_number.required' => 'مطلوب إدخال رقم الرحلة.',
            ]);
        $validatedData['flight_type'] = 'simulated_flight';
        Flight::create([
            'flight_number' => $validatedData['flight_number'],
            'flight_date' => $validatedData['flight_date'],
            'aircraft_id' => $validatedData['aircraft_id'],
            'flight_type' => $validatedData['flight_type'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('successCreate', 'تم إضافة الرحلة  بنجاح.');
    }
    public function addUnloadedFlight(Request $request){
        $validatedData = $request->validate([
            'aircraft_id' => 'required|exists:aircrafts,id',
            'flight_date' => 'required|date|after_or_equal:today',
            'flight_number' => 'required|numeric',
        ],
            [
                'aircraft_id.required' => 'مطلوب اختيار الطائرة.',
                'aircraft_id.exists' => 'الطائرة المختارة غير موجودة.',
                'flight_date.required' => 'مطلوب تحديد تاريخ الرحلة.',
                'flight_date.after_or_equal' => 'يجب أن يكون تاريخ الرحلة في اليوم الحالي أو في المستقبل.', 'flight_number.required' => 'مطلوب إدخال رقم الرحلة.',
            ]);
        $validatedData['flight_type'] = 'unloaded_flight';
        Flight::create([
            'flight_number' => $validatedData['flight_number'],
            'flight_date' => $validatedData['flight_date'],
            'aircraft_id' => $validatedData['aircraft_id'],
            'flight_type' => $validatedData['flight_type'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('successCreate', 'تم إضافة الرحلة  بنجاح.');
    }
    public function addTestFlight(Request $request){
        $validatedData = $request->validate([
            'aircraft_id' => 'required|exists:aircrafts,id',
            'flight_date' => 'required|date|after_or_equal:today',
            'flight_number' => 'required|numeric',
        ],
            [
                'aircraft_id.required' => 'مطلوب اختيار الطائرة.',
                'aircraft_id.exists' => 'الطائرة المختارة غير موجودة.',
                'flight_date.required' => 'مطلوب تحديد تاريخ الرحلة.',
                'flight_date.after_or_equal' => 'يجب أن يكون تاريخ الرحلة في اليوم الحالي أو في المستقبل.', 'flight_number.required' => 'مطلوب إدخال رقم الرحلة.',
            ]);
        $validatedData['flight_type'] = 'airplane_test';
        Flight::create([
            'flight_number' => $validatedData['flight_number'],
            'flight_date' => $validatedData['flight_date'],
            'aircraft_id' => $validatedData['aircraft_id'],
            'flight_type' => $validatedData['flight_type'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('successCreate', 'تم إضافة الرحلة  بنجاح.');
    }
}
