<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // ✅ ADMIN VIEW ALL
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        // Filter by date
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->latest()->get();

        return view('attendances.index', compact('attendances'));
    }

    // ✅ CREATE FORM
    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
        'employee_id' => 'required',
        'date' => 'required|date',
        'overtime_hours' => 'nullable|integer|min:0',
        'status' => 'required|in:present,absent,late'
    ]);

    // Prevent overtime if absent
    if ($request->status === 'absent' && $request->overtime_hours > 0) {

        return back()
            ->withInput()
            ->withErrors([
                'overtime_hours' => 'Absent employees cannot have overtime hours.'
            ]);
        }

        Attendance::create($request->all());

        return redirect()->route('attendances.index')
            ->with('success', 'Attendance recorded');
    }

    // ✅ EDIT
    public function edit(Attendance $attendance)
    {
        $employees = Employee::where('is_active', true)->get();
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    // ✅ UPDATE
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
        'employee_id' => 'required',
        'date' => 'required|date',
        'overtime_hours' => 'nullable|integer|min:0',
        'status' => 'required|in:present,absent,late'
    ]);

    // Prevent overtime if absent
    if ($request->status === 'absent' && $request->overtime_hours > 0) {

        return back()
            ->withInput()
            ->withErrors([
                'overtime_hours' => 'Absent employees cannot have overtime hours.'
            ]);
        }

        $attendance->update($request->all());

        return redirect()->route('attendances.index')
            ->with('success', 'Updated');
    }

    // ✅ DELETE
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Deleted');
    }

    // ✅ EMPLOYEE VIEW (OWN ONLY)
    public function myAttendance()
    {
        $user = Auth::user();

        if (!$user || !$user->employee) {
            abort(403);
        }

        $attendances = Attendance::where('employee_id', $user->employee->id)
            ->latest()
            ->get();

        return view('attendances.my', compact('attendances'));
    }
}
