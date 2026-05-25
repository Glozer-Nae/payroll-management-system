<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payroll;
use App\Models\DeductionType;

class PayrollDeduction extends Model
{
    protected $fillable = [
        'payroll_id',
        'deduction_type_id',
        'amount'
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function deductionType()
    {
        return $this->belongsTo(DeductionType::class);
    }
}
