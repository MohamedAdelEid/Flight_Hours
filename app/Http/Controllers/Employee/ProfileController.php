<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = auth()->user();

        return view('employee.profile.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        $employee = auth()->user();

        $validator = Validator::make($request->all(),
            [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'current_password' => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:6',
        ],
            [
            'name.string' => 'الاسم يجب أن يكون نصاً',
            'name.max' => 'الاسم لا يمكن أن يتجاوز ٢٥٥ حرفاً',

            'phone.string' => 'رقم الهاتف يجب أن يكون نصاً',
            'phone.max' => 'رقم الهاتف لا يمكن أن يتجاوز ٢٥٥ حرفاً',

            'current_password.string' => 'كلمة المرور الحالية يجب أن تكون نصاً',
            'current_password.min' => 'كلمة المرور الحالية يجب ألا تقل عن ٦ أحرف',

            'new_password.string' => 'كلمة المرور الجديدة يجب أن تكون نصاً',
            'new_password.min' => 'كلمة المرور الجديدة يجب ألا تقل عن ٦ أحرف',
            'new_password.confirmed' => 'تأكيد كلمة المرور الجديدة غير مطابق',
        ]);
        $validator->after(function ($validator) use ($employee, $request) {
            if ($request->filled('current_password') && !Hash::check($request->current_password, $employee->password)) {
                $validator->errors()->add('current_password', 'كلمة السر القديمة غير صحيحة');
            }

            if ($request->filled('new_password') && !$request->filled('current_password')) {
                $validator->errors()->add('current_password', 'كلمة المرور الحالية مطلوبة لتغيير كلمة المرور الجديدة');
            }
        });

        $validatedData = $validator->validate();
        $employee->update(array_filter($validatedData));

        return redirect()->back()->with('success', 'تم تعديل البيانات الشخصية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
