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
        return $this->storeFlight($request, 'flight.createSimulatedFlight', 'تم اضافة رحلة طيران تشبيهي بنجاح');
    }
    public function storeUnloadedFlight(StoreOtherFlightsRequest $request){
        return $this->storeFlight($request, 'flight.createUnloadedFlight', 'تم اضافة رحلة طيران غير محمل بنجاح');
    }
    public function storeFlyingTest(StoreOtherFlightsRequest $request){
        return $this->storeFlight($request, 'flight.createFlyingTest', 'تم اضافة رحلة اختبار طائرة بنجاح');
    }
    private function storeFlight(StoreOtherFlightsRequest $request,$route,$message){
        $data = $request->validated();
        $flight = OtherFlights::create([
            'airport_id' => $data['airport_name'],
            'aircraft_id' => $data['aircraft_name'],
            'flight_number' => $data['flight_number'],
            'flight_date' => $data['flight_date'],
        ]);
        $financial_numbers = $data['financial_number'];
        foreach ($financial_numbers as $financial_number) {
            $crew_id = Crew::where('financial_number', $financial_number)->value('id');
            if (!$crew_id) {
                throw new \Exception('Invalid crew ID for financial number: ' . $financial_number);
            }

            CrewFlight::create([
                'flight_id' => $flight->id,
                'crew_id' => $crew_id,
                'user_id' => auth()->user()->id,
                'training_start_at' => $data['training_start_at'] ,
                'training_end_at' => $data['training_end_at']
            ]);

            CrewFlight::create([
                'flight_id' => $flight->id,
                'crew_id' => $crew_id,
                'user_id' => auth()->user()->id,
                'training_start_at' => $data['training_start_at'] ,
                'training_end_at' => $data['training_end_at']
            ]);
        }
        return redirect()->route($route)->with('successCreate',$message);
    }
}
