<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => User::count(),
            'employees' => User::where('role', 'employee')->count(),
            'captains' => User::where('role', 'captain')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.index', compact('users', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:employee,captain',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return back()->with('success', "تم إنشاء حساب {$user->name} بنجاح");
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role' => 'required|in:employee,captain',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($data);
        return back()->with('success', 'تم تحديث بيانات الحساب بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'تم حذف الحساب بنجاح');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $msg = $user->is_active ? 'تم تفعيل الحساب' : 'تم تعطيل الحساب';
        return back()->with('success', $msg);
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);
        $user->update(['password' => Hash::make($newPassword)]);
        return back()->with('success', "تم إعادة تعيين كلمة المرور: {$newPassword}");
    }
}
