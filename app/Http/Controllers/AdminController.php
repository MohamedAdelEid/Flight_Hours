<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createUser(){
        return view('admin.create-user');
    }
    public function storeUser(EmployeeRequest $employeeRequest){
         User::create($employeeRequest->validated(),array_merge([
             'role' => 'employee'
         ]));
         return to_route('admin.index')->with('success','تم اضافة الموظف بنجاح');
    }
    public function editUser(User $employee){
        return view('admin.edit-user',[
            'employee' => $employee
        ]);
    }
    public function updateUser(EmployeeRequest $employeeRequest,User $employee){
        $employee->update($employeeRequest->validated());
        return to_route('admin.index')->with('success','تم تعديل بيانات الموظف بنجاح');
    }
    public function deleteUser(Request $request,User $employee){
        $employee->delete();
        return to_route('admin.index')->with('success','تم حذف الموظف بنجاح');
    }
}
