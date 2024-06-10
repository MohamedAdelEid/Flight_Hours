<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{

    public function index()
    {
       return view('employee.flight.index',[
           'flight'=> Flight::with('flightHours')
               ->orderByDesc('created_at')->get()
       ]);
    }

    public function create()
    {
        return view('employee.flight.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlightRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
