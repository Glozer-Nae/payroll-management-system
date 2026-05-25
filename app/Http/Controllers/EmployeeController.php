<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function myProfile()
    {
        $user = Auth::user();

        if (!$user || !$user->employee) {
            abort(404, 'Employee record not found');
        }

        $employee = $user->employee;
        return view('employees.profile', compact('employee'));
    }

    // ✅ INDEX (LIST)
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function viewOnly()
    {
        $employees = Employee::with('department')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('employees.view_only', compact('employees'));
    }

    // ✅ CREATE FORM
    public function create()
    {
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    // ✅ STORE 
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'department_id' => 'required',
            'position' => 'required',
            'salary' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'employee'
        ]);

       
       $employee = Employee::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'salary' => $request->salary,
            'is_active' => $request->is_active
        ]);
       

        // ✅ Redirect to list
        return redirect()->route('employees.index')->with('success', 'Employee added successfully');
    }

    // ✅ EDIT
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    // ✅ UPDATE
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'department_id' => 'required',
            'position' => 'required',
            'salary' => 'required|numeric',
            'is_active' => 'required|boolean'
        ]);

       $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'department_id' => $request->department_id,
            'position' => $request->position,
            'salary' => $request->salary,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('employees.index')->with('success', 'Updated');
    }

    // ✅ DELETE
    public function destroy(Employee $employee)
    {
        $employee->update(['is_active' => false]);
        return redirect()->route('employees.index')
            ->with('success', 'Employee deactivated successfully');
    }
}
