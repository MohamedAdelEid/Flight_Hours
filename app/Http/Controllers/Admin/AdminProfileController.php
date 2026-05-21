<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        return view('admin.profile.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = auth()->user();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $admin->id,
                'phone' => 'nullable|string|max:255',
                'current_password' => 'nullable|string|min:6',
                'new_password' => 'nullable|string|min:6',
            ],
            [
                'name.string' => 'الاسم يجب أن يكون نصاً',
                'name.max' => 'الاسم لا يمكن أن يتجاوز ٢٥٥ حرفاً',
                'email.email' => 'البريد الإلكتروني غير صالح',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
                'phone.string' => 'رقم الهاتف يجب أن يكون نصاً',
                'phone.max' => 'رقم الهاتف لا يمكن أن يتجاوز ٢٥٥ حرفاً',
                'current_password.string' => 'كلمة المرور الحالية يجب أن تكون نصاً',
                'current_password.min' => 'كلمة المرور الحالية يجب ألا تقل عن ٦ أحرف',
                'new_password.string' => 'كلمة المرور الجديدة يجب أن تكون نصاً',
                'new_password.min' => 'كلمة المرور الجديدة يجب ألا تقل عن ٦ أحرف',
            ]
        );

        $validator->after(function ($validator) use ($admin, $request) {
            if ($request->filled('current_password') && !Hash::check($request->current_password, $admin->password)) {
                $validator->errors()->add('current_password', 'كلمة السر القديمة غير صحيحة');
            }

            if ($request->filled('new_password') && !$request->filled('current_password')) {
                $validator->errors()->add('current_password', 'كلمة المرور الحالية مطلوبة لتغيير كلمة المرور الجديدة');
            }
        });

        $validatedData = $validator->validate();

        $admin->update(array_filter($validatedData, function ($key) {
            return in_array($key, ['name', 'email', 'phone']);
        }, ARRAY_FILTER_USE_KEY));

        if ($request->filled('new_password')) {
            $admin->password = Hash::make($request->new_password);
            $admin->save();
        }

        return redirect()->back()->with('success', 'تم تعديل البيانات الشخصية بنجاح');
    }

    public function changePhoto(Request $request)
    {
        $validatedData = $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $admin = auth()->user();
        if ($request->hasFile('profile')) {
            $filePath = $request->file('profile')->store('images', 'public');
            $admin->image = $filePath;
        }
        $admin->save();
        return redirect()->back()->with('success', 'تم تغيير الصورة الشخصية بنجاح');
    }
}