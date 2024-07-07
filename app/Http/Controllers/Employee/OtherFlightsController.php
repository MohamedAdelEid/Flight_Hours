<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOtherFlightsRequest;
use App\Models\Crew;
use App\Models\CrewFlight;
use App\Models\OtherFlights;

class OtherFlightsController extends Controller
{
    public function storeSimulatedFlight(StoreOtherFlightsRequest $request){
        return $this->storeFlight($request, 'flight.createSimulatedFlight', 'تم اضافة رحلة طيران تشبيهي بنجاح','simulated_flight');
    }
    public function storeUnloadedFlight(StoreOtherFlightsRequest $request){
        return $this->storeFlight($request, 'flight.createUnloadedFlight', 'تم اضافة رحلة طيران غير محمل بنجاح','unloaded_flight');
    }
    public function storeFlyingTest(StoreOtherFlightsRequest $request){
        return $this->storeFlight($request, 'flight.createFlyingTest', 'تم اضافة رحلة اختبار طائرة بنجاح','airplane_test');
    }
    private function storeFlight(StoreOtherFlightsRequest $request, $route, $message, $flightType){
        $data = $request->validated();

        $flight = OtherFlights::create([
            'airport_id' => $data['airport_id'],
            'aircraft_id' => $data['aircraft_id'],
            'flight_number' => $data['flight_number'],
            'flight_date' => $data['flight_date'],
            'flight_type' => $flightType
        ]);

        $financial_numbers = $data['financial_number'];
        $training_start_at = $data['training_start_at'];
        $training_end_at = $data['training_end_at'];

        foreach ($financial_numbers as $index => $financial_number) {
            $crew_id = Crew::where('financial_number', $financial_number)->value('id');
            if (!$crew_id) {
                return redirect()->back()->withErrors(['financial_number' => 'Invalid crew ID for financial number: ' . $financial_number]);
            }
            CrewFlight::create([
                'flight_id' => $flight->id,
                'crew_id' => $crew_id,
                'user_id' => auth()->user()->id,
                'training_start_at' => $training_start_at[$index],
                'training_end_at' => $training_end_at[$index]
            ]);
        }
        return redirect()->route($route)->with('successCreate', $message);
    }

}
