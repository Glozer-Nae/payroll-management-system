<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\Leave;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // =========================
        // ADMIN DASHBOARD
        // =========================
        if ($user->role === 'admin') {

            $month = $request->month ?? now()->format('Y-m');

            $totalEmployees = Employee::count();

            $payrollsThisMonth = Payroll::where('month', $month);

            $totalSalary = $payrollsThisMonth->sum('net_salary');

            $employeesPaid = $payrollsThisMonth->count();

            $employeesWithDeductions = Payroll::where('month', $month)
                ->where('deductions', '>', 0)
                ->count();

            $monthlyData = Payroll::selectRaw('month, SUM(net_salary) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
                
            $payrollSummary = DB::select("CALL GetEmployeePayrolls()");

            $attendanceSummary = DB::select("CALL GetAttendanceSummary()");  

            return view('dashboard.admin', compact(
                'totalEmployees',
                'totalSalary',
                'employeesPaid',
                'employeesWithDeductions',
                'monthlyData',
                'month',
                'payrollSummary',
                'attendanceSummary'
            ));
        }

        // =========================
        // PAYROLL OFFICER DASHBOARD
        // =========================
        if ($user->role === 'payroll_officer') {

            $month = now()->format('Y-m');

            $totalPayrollThisMonth = Payroll::where('month', $month)
                ->sum('net_salary');

            $employeesPaid = Payroll::where('month', $month)
                ->where('status', 'finalized')
                ->distinct('employee_id')
                ->count('employee_id');

            $totalDraftPayrolls = Payroll::where('month', $month)
                ->where('status', 'draft')
                ->count();

            return view('dashboard.payroll_officer', compact(
                'month',
                'totalPayrollThisMonth',
                'employeesPaid',
                'totalDraftPayrolls'
            ));
        }

        // =========================
        // EMPLOYEE DASHBOARD
        // =========================
        if ($user->role === 'employee') {

            $employee = $user->employee;

            $latestPayroll = Payroll::where('employee_id', $employee->id)
                ->latest()
                ->first();

            $attendanceCount = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->count();

            $pendingLeaves = Leave::where('employee_id', $employee->id)
                ->where('status', 'pending')
                ->count();

            $overtimeHours = Attendance::where('employee_id', $employee->id)
                ->sum('overtime_hours');

            return view('dashboard.employee', compact(
                'latestPayroll',
                'attendanceCount',
                'pendingLeaves',
                'overtimeHours'
            ));
        }

        abort(403, 'Unauthorized role');
    }
}
