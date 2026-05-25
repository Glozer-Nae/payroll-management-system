<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;

class LeaveController extends Controller
{
    // ✅ ADMIN VIEW ALL
    public function index(Request $request)
    {
        $query = Leave::with('employee');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $leaves = $query->latest()->get();

        return view('leaves.adminIndex', compact('leaves'));
    }

    // ✅ EMPLOYEE APPLY FORM
    public function create()
    {
        return view('leaves.create');
    }

    // ✅ STORE LEAVE REQUEST
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sick,vacation,emergency',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_paid' => 'required|boolean'
        ]);

        $user = Auth::user();

        if (!$user || !$user->employee) {
                abort(403, 'No employee record found');
            }


        Leave::create([
            'employee_id' => Auth::user()->employee->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_paid' => $request->is_paid,
            'status' => 'pending'
        ]);

        return redirect()->route('leaves.my')->with('success', 'Leave submitted');
    }

    // ✅ EMPLOYEE VIEW OWN LEAVES
    public function myLeaves()
    {
        $leaves = Leave::where('employee_id', Auth::user()->employee->id)
            ->latest()
            ->get();

        return view('leaves.my', compact('leaves'));
    }

    // ✅ ADMIN APPROVE
    public function approve(Leave $leave)
    {
        $leave->update(['status' => 'approved']);
        return back()->with('success', 'Approved');
    }

    // ✅ ADMIN REJECT
    public function reject(Leave $leave)
    {
        $leave->update(['status' => 'rejected']);
        return back()->with('success', 'Rejected');
    }
}
