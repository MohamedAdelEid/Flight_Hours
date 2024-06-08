<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AirportController extends Controller
{
    public function index()
    {
        $airports = Airport::all()->sortByDesc('created_at');
        return view('employee.airport.index', ['airports' => $airports]);
    }

    public function create()
    {
        return view('employee.airport.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'airport_name' => ['required', 'string', 'max:255'],
            'airport_code' => ['required', 'string', 'max:10','unique:airports,airport_code'],
        ], [
            'airport_name.required' => 'حقل اسم المطار مطلوب.',
            'airport_name.string' => 'يجب أن يكون اسم المطار نصًا.',
            'airport_name.max' => 'قد لا يكون اسم المطار أكبر من 255 حرفًا.',
            'airport_code.required' => 'حقل كود المطار مطلوب.',
            'airport_code.string' => 'يجب أن يكون رمز المطار نصًا.',
            'airport_code.max' => 'قد لا يكون رمز المطار أكبر من 10 أحرف.',
            'airport_code.unique' => 'لا يمكن تكرار هذا الكود لاكثر من مطار'
        ]);


        Airport::create([
            'airport_name' => $validatedData['airport_name'],
            'airport_code' => $validatedData['airport_code'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('airport.index')->with('successCreate', 'تم إضافة المطار بنجاح');
    }

    public function show(Airport $airport)
    {
        return view('employee.airport.show', ['airport' => $airport]);
    }

    public function edit(Airport $airport)
    {
        return view('employee.airport.edit', ['airport' => $airport]);
    }

    public function update(Request $request, Airport $airport)
    {
        $validatedData = $request->validate([
            'airport_name' => ['required', 'string', 'max:255'],
            'airport_code' => ['required', 'string', 'max:10'],
        ], [
            'airport_name.required' => 'The airport name field is required.',
            'airport_name.string' => 'The airport name must be a string.',
            'airport_name.max' => 'The airport name may not be greater than 255 characters.',
            'airport_code.required' => 'The airport code field is required.',
            'airport_code.string' => 'The airport code must be a string.',
            'airport_code.max' => 'The airport code may not be greater than 10 characters.',
        ]);

        $airport->update([
            'airport_name' => $validatedData['airport_name'],
            'airport_code' => $validatedData['airport_code'],
        ]);

        return redirect()->route('airport.index')->with('success', 'Airport Updated Successfully');
    }

    public function destroy(Airport $airport)
    {
        $airport->delete();
        return redirect()->route('airport.index')->with('success', 'Airport Deleted Successfully');
    }
}
