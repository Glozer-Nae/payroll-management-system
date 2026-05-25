<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\DeductionType;
use App\Models\PayrollDeduction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    // =========================
    // PAYROLL LIST
    // =========================
    public function index(Request $request)
    {
        $query = Payroll::with('employee');

        // Filter by month
        if ($request->month) {
            $query->where('month', $request->month);
        }

        // Filter by employee name
        if ($request->employee) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->employee . '%')
                  ->orWhere('last_name', 'like', '%' . $request->employee . '%');
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $payrolls = $query->latest()->get();

        return view('payrolls.index', compact('payrolls'));
    }

    // =========================
    // EMPLOYEE VIEW OWN PAYROLL
    // =========================
    public function myPayrolls()
    {
        $user = Auth::user();

        if (!$user || !$user->employee) {
            abort(404, 'Employee record not found.');
        }

        $payrolls = Payroll::where('employee_id', $user->employee->id)
            ->latest()
            ->get();

        return view('payrolls.my', compact('payrolls'));
    }

    // =========================
    // PAYSLIP VIEW
    // =========================
    public function show(Payroll $payroll)
    {
        $user = Auth::user();

        if (
            $user->role === 'employee' &&
            (
                !$user->employee ||
                $payroll->employee_id !== $user->employee->id
            )
        ) {
            abort(403);
        }

        $payroll = Payroll::with([
            'employee',
            'payrollDeductions.deductionType'
        ])->findOrFail($payroll->id);

        return view('payrolls.show', compact('payroll'));
    }

    // =========================
    // GENERATE PAYROLL
    // =========================
    public function generatePayroll(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m'
        ]);

        $month = $request->month;

        // Only active employees
        $employees = Employee::where('is_active', true)->get();

        // Active deduction types
        $deductionTypes = DeductionType::where('is_active', true)->get();

        DB::transaction(function () use ($employees, $month, $deductionTypes) {

            foreach ($employees as $employee) {

                // Check existing payroll
                $existing = Payroll::where('employee_id', $employee->id)
                    ->where('month', $month)
                    ->first();

                // Prevent overwrite if finalized
                if ($existing && $existing->status === 'finalized') {
                    continue;
                }

                // Delete existing draft payroll
                if ($existing) {
                    $existing->delete();
                }

                // =========================
                // ATTENDANCE
                // =========================
                $startDate = $month . '-01';
                $endDate = date('Y-m-t', strtotime($startDate));

                $attendance = Attendance::where('employee_id', $employee->id)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->get();

                $absences = $attendance->where('status', 'absent')->count();

                $overtimeHours = $attendance->sum('overtime_hours');

                // =========================
                // LEAVES
                // =========================
                $unpaidLeaves = Leave::where('employee_id', $employee->id)
                    ->where('status', 'approved')
                    ->where('is_paid', false)
                    ->whereBetween('start_date', [$startDate, $endDate])
                    ->get();

                $leaveDays = 0;

                foreach ($unpaidLeaves as $leave) {
                    $days = (
                        strtotime($leave->end_date) -
                        strtotime($leave->start_date)
                    ) / 86400 + 1;

                    $leaveDays += $days;
                }

                // =========================
                // SALARY CALCULATIONS
                // =========================
                $salary = $employee->salary;

                $dailyRate = $salary / 22;

                $absencesDeduction = $dailyRate * $absences;

                $leavesDeduction = $dailyRate * $leaveDays;

                $overtimePay = $overtimeHours * 100;

                // =========================
                // DEDUCTIONS
                // =========================
                $totalDeductions =
                    $absencesDeduction +
                    $leavesDeduction;

                // Create payroll first
                $payroll = Payroll::create([
                    'employee_id' => $employee->id,
                    'salary' => $salary,
                    'absences_deduction' => $absencesDeduction,
                    'leaves_deduction' => $leavesDeduction,
                    'overtime_pay' => $overtimePay,
                    'deductions' => 0,
                    'net_salary' => 0,
                    'month' => $month,
                    'status' => 'draft'
                ]);

                // Deduction records
                foreach ($deductionTypes as $deductionType) {

                    if ($deductionType->type === 'fixed') {
                        $amount = $deductionType->value;
                    } else {
                        $amount = ($salary * $deductionType->value) / 100;
                    }

                    PayrollDeduction::create([
                        'payroll_id' => $payroll->id,
                        'deduction_type_id' => $deductionType->id,
                        'amount' => $amount
                    ]);

                    $totalDeductions += $amount;
                }

                // Final salary
                $netSalary = max(
                    0,
                    ($salary + $overtimePay) - $totalDeductions
                );

                // Update totals
                $payroll->update([
                    'deductions' => $totalDeductions,
                    'net_salary' => $netSalary
                ]); 
            }
        });

        return redirect()
            ->route('payrolls.index')
            ->with('success', 'Payroll generated successfully.');
    }

    // =========================
    // FINALIZE PAYROLL
    // =========================
    public function finalize(Payroll $payroll)
    {
        $payroll->update([
            'status' => 'finalized'
        ]);

        return back()->with('success', 'Payroll finalized.');
    }

    // =========================
    // DOWNLOAD PDF
    // =========================
    public function download(Payroll $payroll)
    {
        $user = Auth::user();

        if (
            $user->role === 'employee' &&
            (
                !$user->employee ||
                $payroll->employee_id !== $user->employee->id
            )
        ) {
            abort(403);
        }

        $payroll = Payroll::with([
            'employee',
            'payrollDeductions.deductionType'
        ])->findOrFail($payroll->id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'payrolls.show',
            compact('payroll')
        );

        return $pdf->download(
            'Payslip-' .
            $payroll->employee->first_name .
            '-' .
            $payroll->month .
            '.pdf'
        );
    }
}