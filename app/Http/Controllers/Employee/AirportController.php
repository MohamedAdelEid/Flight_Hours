<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AirportController extends Controller
{
    public function index()
    {
        return view('employee.airport.index', [
            'airports' => Airport::orderByDesc('created_at')->get(),
        ]);
    }

    public function create()
    {
        return view('employee.airport.add');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatedData($request);

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
        $validatedData = $this->validatedData($request, $airport);
        $airport->update($validatedData);

        return redirect()->route('airport.index')->with('successUpdate', 'تم تعديل المطار بنجاح');
    }

    public function destroy(Airport $airport)
    {
        try {
            $airport->delete();
        } catch (QueryException) {
            return redirect()->route('airport.index')->with('error', 'لا يمكن حذف المطار لأنه مرتبط برحلات');
        }

        return redirect()->route('airport.index')->with('success', 'تم حذف المطار بنجاح');
    }

    private function validatedData(Request $request, ?Airport $airport = null): array
    {
        return $request->validate([
            'airport_name' => ['required', 'string', 'max:255'],
            'airport_code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('airports', 'airport_code')->ignore($airport?->id),
            ],
        ]);
    }
}