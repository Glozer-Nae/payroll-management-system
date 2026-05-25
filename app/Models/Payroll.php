<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PayrollDeduction;
use App\Models\Employee;

class Payroll extends Model
{
    protected $fillable = [
    'employee_id',
    'salary',
    'deductions',
    'absences_deduction',
    'leaves_deduction',
    'overtime_pay',
    'net_salary',
    'month',
    'status'
];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payrollDeductions()
    {
        return $this->hasMany(PayrollDeduction::class);
    }
}
